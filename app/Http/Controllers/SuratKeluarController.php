<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\KlasifikasiSurat;
use App\Models\VerifikasiSurat;
use App\Models\SifatSurat;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QRCode
use Illuminate\Support\Facades\Log;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $title = 'Surat Keluar';
        $nik = Auth::user()->username;
        if (request()->ajax()) {
            $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
                ->where('nik_pengirim', $nik)
                ->get();

            return DataTables::of($surat)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function ($row) {
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_keluar.edit', $row->id_surat).'"><i class="far fa-edit"></i></a> ' .
                           '<form action="'.route('surat_keluar.destroy', $row->id_surat).'" method="POST" style="display:inline;">' .
                           '<input type="hidden" name="_token" value="'.csrf_token().'">' .
                           '<input type="hidden" name="_method" value="DELETE">' .
                           '<button type="submit" class="btn btn-danger waves-effect waves-light deletesurat"><i class="far fa-trash-alt"></i></button></form>' .
                           ' <a class="btn btn-primary waves-effect waves-light" href="'.route('surat_keluar.show', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('surat_keluar.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create Surat Keluar';
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        return view('surat_keluar.create', compact('title','klasifikasiSurat','sifatSurat','pegawai'));
    }

    public function store(Request $request)
    {
        $nik = Auth::user()->username;
        $request->validate([
            'id_klasifikasi_surat' => 'required',
            'id_sifat_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'lampiran' => 'required',
            'file_surat' => 'required|file|mimes:docx',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Generate kode_surat dan nomor_surat
        $kodeSurat = 'SRT-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        $lastSurat = Surat::orderBy('nomor_surat', 'desc')->first();
        $nomorSurat = $lastSurat ? intval($lastSurat->nomor_surat) + 1 : 1;

        $klasifikasi = KlasifikasiSurat::find($request->id_klasifikasi_surat);
        $tahun = date('Y', strtotime($request->tanggal_surat));
        $fullNomorSurat = "RS'ASF/" . $nomorSurat . "/" . $klasifikasi->kode_klasifikasi_surat . "/" . $tahun;

        // Menyimpan data surat ke database
        $surat = Surat::create([
            'id_klasifikasi_surat' => $request->id_klasifikasi_surat,
            'id_sifat_surat' => $request->id_sifat_surat,
            'nik_pengirim' => $nik,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran' => $request->lampiran,
            'kode_surat' => $kodeSurat,
            'nomor_surat' => $fullNomorSurat,
        ]);

        $fileSurat = $request->file('file_surat');
        $fileSuratPath = $fileSurat->store('uploads/surat', 'public');
        $surat->file_surat = $fileSuratPath;
        $surat->save();

        if ($request->hasFile('file_lampiran')) {
            $lampiranPath = $request->file('file_lampiran')->store('uploads/lampiran', 'public');
            $surat->file_lampiran = $lampiranPath;
            $surat->save();
        }

        VerifikasiSurat::create([
            'id_surat' => $surat->id_surat,
            'nik_verifikator' => $request->nik_atasan_langsung,
            'status_surat' => 'Dikirim',
            'tanggal_verifikasi' => null,
            'catatan' => null,
        ]);

        return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Surat Keluar';
        $surat = Surat::findOrFail($id);
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $verifikasiSurat = VerifikasiSurat::where('id_surat', $id)->first();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        return view('surat_keluar.edit', compact('title', 'surat', 'klasifikasiSurat', 'sifatSurat', 'pegawai','verifikasiSurat'));
    }

    public function update(Request $request, $id)
    {
        $nik = Auth::user()->username;
        $request->validate([
            'id_klasifikasi_surat' => 'required',
            'id_sifat_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'lampiran' => 'required',
            'file_surat' => 'nullable|file|mimes:docx',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
    
        $surat = Surat::findOrFail($id);
        $klasifikasi = KlasifikasiSurat::find($request->id_klasifikasi_surat);
    
        // Update nomor surat jika diperlukan
        $nomorSurat = $surat->nomor_surat;
        if ($request->id_klasifikasi_surat != $surat->id_klasifikasi_surat || $request->tanggal_surat != $surat->tanggal_surat) {
            $tahun = date('Y', strtotime($request->tanggal_surat));
            $nomorSurat = "RS'ASF/" . $surat->nomor_surat . "/" . $klasifikasi->kode_klasifikasi_surat . "/" . $tahun;
        }
    
        // Update data surat
        $surat->update([
            'id_klasifikasi_surat' => $request->id_klasifikasi_surat,
            'id_sifat_surat' => $request->id_sifat_surat,
            'nik_pengirim' => $nik,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran' => $request->lampiran,
            'nomor_surat' => $nomorSurat,
        ]);
    
        if ($request->hasFile('file_surat')) {
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }
    
            $fileSurat = $request->file('file_surat');
            $fileSuratPath = $fileSurat->store('uploads/surat', 'public');
            $surat->file_surat = $fileSuratPath;
            $surat->save();
        }
    
        if ($request->hasFile('file_lampiran')) {
            if ($surat->file_lampiran) {
                Storage::disk('public')->delete($surat->file_lampiran);
            }
    
            $fileLampiran = $request->file('file_lampiran');
            $lampiranPath = $fileLampiran->store('uploads/lampiran', 'public');
            $surat->file_lampiran = $lampiranPath;
            $surat->save();
        }
    
        $verifikasiSurat = VerifikasiSurat::where('id_surat', $surat->id_surat)->first();
        if ($verifikasiSurat) {
            $verifikasiSurat->update([
                'nik_verifikator' => $request->nik_atasan_langsung,
                'status_surat' => 'Diperbarui',
                'catatan' => $request->catatan,
            ]);
        }
    
        return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        if ($surat->file_surat) {
            Storage::disk('public')->delete($surat->file_surat);
        }
        if ($surat->file_lampiran) {
            Storage::disk('public')->delete($surat->file_lampiran);
        }
        VerifikasiSurat::where('id_surat', $surat->id_surat)->delete();
        $surat->delete();

        return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function show($encryptedKodeSurat) 
{
    $title = 'Detail Surat Keluar';
    $kode_surat = decrypt($encryptedKodeSurat);

    // Mengambil data surat berdasarkan kode surat
    $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
        ->where('kode_surat', $kode_surat)
        ->firstOrFail();
    $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
    $verifikasiSurat = VerifikasiSurat::with('pegawai')->where('id_surat',$surat->id_surat)->get();

    // Mengambil template DOCX dari storage
    $templatePath = storage_path('app/public/' . $surat->file_surat);
    if (!file_exists($templatePath)) {
        return response()->json(['error' => 'File tidak ditemukan.'], 404);
    }

    // Mengonversi DOCX ke PDF
    $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);

    // Cek apakah PDF berhasil dibuat
    if ($pdfFilePath) {
        // URL untuk menampilkan PDF di browser
        $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));
    } else {
        return response()->json(['error' => 'Konversi gagal.'], 500);
    }

    // Kembali ke tampilan dengan data surat dan PDF
    return view('surat_keluar.show', compact('title', 'surat', 'pdfUrl','tanggalSurat','verifikasiSurat'));
}

private function convertDocxToPdf($docxPath, $surat)
{
    // Mengisi template DOCX dengan data surat menggunakan PhpWord
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($docxPath);
    $templateProcessor->setValue('nomor', $surat->nomor_surat);
    $templateProcessor->setValue('perihal', $surat->perihal);
    $templateProcessor->setValue('sifat', $surat->sifat_surat->nama_sifat_surat);
    $templateProcessor->setValue('tanggal_surat', Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'));
    $templateProcessor->setValue('lampiran', $surat->lampiran);

    // Mengecek status surat
    $verifikasiSurat = VerifikasiSurat::find($surat->id_surat);
    
    if ($verifikasiSurat && $verifikasiSurat->status_surat == "Disetujui") {
        // Generate QR Code dengan URL ke show
        $pdfUrl = url(route('surat_keluar.show', ['encryptedKodeSurat' => encrypt($surat->kode_surat)]));

        // Path untuk menyimpan QR Code
        $qrcodePath = storage_path('app/public/temp_surat/qrcode_with_logo.png');

        // Path ke logo
        $logoPath = public_path('assets/images/web.png');

        // Pastikan logo ada sebelum membuat QR Code
        if (file_exists($logoPath)) {
            // Generate QR Code dan simpan sebagai gambar dengan logo di tengah
            QrCode::format('png')
                ->merge($logoPath, 0.2, true)  // 20% dari ukuran QR code
                ->size(300)
                ->margin(0)
                ->generate($pdfUrl, $qrcodePath);
        } else {
            return response()->json(['error' => 'Logo tidak ditemukan.'], 404);
        }

        // Menempatkan gambar QR Code di template Word
        $templateProcessor->setImageValue('qrcode', [
            'path' => $qrcodePath,
            'width' => 100,
            'height' => 100,
            'ratio' => true
        ]);
    } else {
        // Jika status "Dikirim", set kotak abu-abu
        $kotakAbuPath = public_path('assets/images/kotakabu.jpg'); // Path ke gambar kotak abu-abu

        if (file_exists($kotakAbuPath)) {
            // Menempatkan gambar kotak abu-abu di template Word
            $templateProcessor->setImageValue('qrcode', [
                'path' => $kotakAbuPath,
                'width' => 100,
                'height' => 100,
                'ratio' => true
            ]);
        }
    }

    // Simpan file DOCX yang sudah diisi
    $filledDocxPath = storage_path('app/public/temp_surat/filled_surat_keluar-' . $surat->kode_surat . '.docx');
    $templateProcessor->saveAs($filledDocxPath);

    // Path untuk menyimpan file PDF hasil konversi
    $pdfPath = storage_path('app/public/temp_surat/filled_surat_keluar-' . $surat->kode_surat . '.pdf');
    
    // Path ke LibreOffice
    $libreOfficePath = 'C:\Program Files\LibreOffice\program\soffice.exe';

    // Siapkan command untuk eksekusi
    $command = '"' . $libreOfficePath . '" --headless --convert-to pdf --outdir "' . dirname($pdfPath) . '" "' . $filledDocxPath . '"';

    // Eksekusi command
    shell_exec($command);

    // Cek apakah file PDF berhasil dibuat
    if (file_exists($pdfPath)) {
        return $pdfPath;
    } else {
        return false;
    }
}
}
