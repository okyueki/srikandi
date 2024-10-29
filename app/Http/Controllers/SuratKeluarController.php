<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\KlasifikasiSurat;
use App\Models\VerifikasiSurat;
use App\Models\SifatSurat;
use App\Models\DisposisiSurat;
use App\Models\TandaTangan;
use App\Models\TemplateSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
        $templateSurat=TemplateSurat::all();
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
                    $verifikasi = $row->verifikasi()->orderBy('id_verifikasi_surat', 'ASC')->first();
                    if ($verifikasi && $verifikasi->status_surat == "Disetujui") {
                        return '<a class="btn btn-primary waves-effect waves-light" href="'.route('surat_keluar.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                    }else{
                    return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_keluar.kirimsurat', encrypt($row->kode_surat)).'"><i class="far fa-edit"></i></a> ' .
                           '<form action="'.route('surat_keluar.destroy', $row->id_surat).'" method="POST" style="display:inline;">' .
                           '<input type="hidden" name="_token" value="'.csrf_token().'">' .
                           '<input type="hidden" name="_method" value="DELETE">' .
                           '<button type="submit" class="btn btn-danger waves-effect waves-light deletesurat"><i class="far fa-trash-alt"></i></button></form>' .
                           ' <a class="btn btn-primary waves-effect waves-light" href="'.route('surat_keluar.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('surat_keluar.index', compact('title','templateSurat'));
    }

    public function create()
    {
        $title = 'Create Surat Keluar';
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        
        return view('surat_keluar.create', compact('title', 'klasifikasiSurat', 'sifatSurat', 'pegawai'));
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
            'file_lampiran' => 'nullable|file|mimes:pdf',
            'ttd_utama' => 'required', // Validasi untuk tanda tangan utama
            'ttd_2' => 'nullable', // Validasi untuk tanda tangan tambahan 1
            'ttd_3' => 'nullable', // Validasi untuk tanda tangan tambahan 2
            'ttd_4' => 'nullable', // Validasi untuk tanda tangan tambahan 3
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

        // Menyimpan tanda tangan
        $tandaTangan = [
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_utama, 'status_ttd' => 'qrcode'],
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_2, 'status_ttd' => 'qrcode_2'],
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_3, 'status_ttd' => 'qrcode_3'],
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_4, 'status_ttd' => 'qrcode_4'],
        ];

        foreach ($tandaTangan as $ttd) {
            if (!empty($ttd['nik_penandatangan'])) {
                TandaTangan::create($ttd);
            }
        }

        return redirect()->route('surat_keluar.kirimsurat', ['encryptedKodeSurat' => encrypt($surat->kode_surat)])
            ->with('success', 'Surat berhasil ditambahkan.');
    }

    public function kirimsurat($encryptedKodeSurat) 
    {
        Carbon::setLocale('id');
        $title = 'Kirim Surat Keluar';
        $kode_surat = decrypt($encryptedKodeSurat);

        // Mengambil data surat berdasarkan kode surat
        $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
            ->where('kode_surat', $kode_surat)
            ->firstOrFail();
        $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
        $verifikasiSurat = VerifikasiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();
        $disposisiAll = DisposisiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();

        // Mengambil template DOCX dari storage
        $templatePath = storage_path('app/public/' . $surat->file_surat);
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Mengonversi DOCX ke PDF
        $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);

        // Cek apakah PDF berhasil dibuat
        if ($pdfFilePath) {
            $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));
        } else {
            return response()->json(['error' => 'Konversi gagal.'], 500);
        }
        $verifikasi= VerifikasiSurat::where('id_surat',$surat->id_surat)->first();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        // Kembali ke tampilan dengan data surat dan PDF
        return view('surat_keluar.kirimsurat', compact('title', 'surat', 'verifikasi', 'pegawai','pdfUrl', 'tanggalSurat', 'verifikasiSurat', 'disposisiAll'));
    }
    public function kirimSuratProses(Request $request)
{
    
    // Validate incoming request
    $request->validate([
        'id_surat' => 'required|exists:surat,id_surat',
        'nik_atasan_langsung' => 'required',
    ]);

    // Retrieve the current verifikasi record or create a new one
    $verifikasi = VerifikasiSurat::updateOrCreate(
        ['id_surat' => $request->id_surat], // Unique identifier
        [
            'nik_verifikator' => $request->nik_atasan_langsung,
            'status_surat' => 'Dikirim', // or whatever the status should be
            'tanggal_verifikasi' => now(), // Current date/time
        ]
    );

    // Redirect back with success message
    return redirect()->route('surat_keluar.index')->with('success', 'Verifikasi surat berhasil diperbarui.');
}
    public function edit($id)
    {
        $title = 'Edit Surat Keluar';
        $surat = Surat::findOrFail($id);
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();

        return view('surat_keluar.edit', compact('title', 'surat', 'klasifikasiSurat', 'sifatSurat', 'pegawai'));
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
            'ttd_utama' => 'required', // Validasi untuk tanda tangan utama
            'ttd_2' => 'nullable', // Validasi untuk tanda tangan tambahan 1
            'ttd_3' => 'nullable', // Validasi untuk tanda tangan tambahan 2
            'ttd_4' => 'nullable', // Validasi untuk tanda tangan tambahan 3
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

        // Update atau simpan tanda tangan
        $tandaTanganData = [
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_utama, 'status_ttd' => 'qrcode'],
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_2, 'status_ttd' => 'qrcode_2'],
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_3, 'status_ttd' => 'qrcode_3'],
            ['id_surat' => $surat->id_surat, 'nik_penandatangan' => $request->ttd_4, 'status_ttd' => 'qrcode_4'],
        ];

        // Hapus tanda tangan yang ada sebelumnya
        TandaTangan::where('id_surat', $surat->id_surat)->delete();

        // Simpan tanda tangan yang baru
        foreach ($tandaTanganData as $ttd) {
            if (!empty($ttd['nik_penandatangan'])) {
                TandaTangan::create($ttd);
            }
        }

        return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Temukan surat berdasarkan ID
        $surat = Surat::findOrFail($id);
        // Hapus file surat jika ada
        if ($surat->file_surat) {
            Storage::disk('public')->delete($surat->file_surat);
        }
        // Hapus file lampiran jika ada
        if ($surat->file_lampiran) {
            Storage::disk('public')->delete($surat->file_lampiran);
        }

        VerifikasiSurat::where('id_surat', $surat->id_surat)->delete();
        TandaTangan::where('id_surat', $surat->id_surat)->delete();
        $surat->delete();
        
        return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function detail($encryptedKodeSurat) 
    {
        Carbon::setLocale('id');
        $title = 'Detail Surat Keluar';
        $kode_surat = decrypt($encryptedKodeSurat);

        // Mengambil data surat berdasarkan kode surat
        $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
            ->where('kode_surat', $kode_surat)
            ->firstOrFail();
        $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
        $verifikasiSurat = VerifikasiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();
        $disposisiAll = DisposisiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();
        
        // Mengambil template DOCX dari storage
        $templatePath = storage_path('app/public/' . $surat->file_surat);
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Mengonversi DOCX ke PDF
        $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);

        // Cek apakah PDF berhasil dibuat
        if ($pdfFilePath) {
            $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));
        } else {
            return response()->json(['error' => 'Konversi gagal.'], 500);
        }

        // Kembali ke tampilan dengan data surat dan PDF
        return view('surat_keluar.detail', compact('title', 'surat', 'pdfUrl', 'tanggalSurat', 'verifikasiSurat', 'disposisiAll'));
    }

    private function convertDocxToPdf($docxPath, $surat)
    {
        $templateProcessor = new TemplateProcessor($docxPath);
        $templateProcessor->setValue('nomor', $surat->nomor_surat);
        $templateProcessor->setValue('perihal', $surat->perihal);
        $templateProcessor->setValue('sifat', $surat->sifat_surat->nama_sifat_surat);
        $templateProcessor->setValue('tanggal_surat', Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'));
        $templateProcessor->setValue('lampiran', $surat->lampiran);

        // Ambil semua tanda tangan dari tabel TandaTangan
        $tandaTangan = TandaTangan::where('id_surat', $surat->id_surat)->get();

        // Placeholder list for QR Codes
        $placeholders = ['qrcode', 'qrcode_2', 'qrcode_3', 'qrcode_4']; // Placeholder untuk masing-masing status_ttd
        
        // Path untuk gambar kotak abu-abu dan logo
        $kotakAbuPath = public_path('assets/images/kotakabu.jpg');
        $logoPath = public_path('assets/images/web.png');

        // URL untuk QR Code
        $pdfUrl = url(route('surat.show', ['encryptedKodeSurat' => encrypt($surat->kode_surat)]));

        // Loop untuk tanda tangan dan penanganan QR code atau kotak abu-abu
        foreach ($placeholders as $index => $placeholder) {
            $qrcodePath = storage_path('app/public/temp_surat/qrcode_with_logo_' . $placeholder . '.png');

            // Cek apakah tanda tangan sesuai dengan pengirim
            $ttd = $tandaTangan->where('status_ttd', $placeholder)->first();
            
            // Jika tanda tangan cocok dengan pengirim
            if ($ttd && $ttd->nik_penandatangan === $surat->nik_pengirim) {
                // Jika pengirim, buat QR Code langsung
                if (file_exists($logoPath)) {
                    QrCode::format('png')
                        ->merge($logoPath, 0.2, true)
                        ->size(300)
                        ->margin(0)
                        ->generate($pdfUrl, $qrcodePath);

                    // Tempatkan QR code di placeholder
                    $templateProcessor->setImageValue($placeholder, [
                        'path' => $qrcodePath,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true
                    ]);
                } else {
                    Log::error('Logo file not found at: ' . $logoPath);
                }
            } elseif ($ttd) {
                // Cek apakah status surat disetujui untuk verifikator
                $verifikasiSurat = VerifikasiSurat::where('id_surat', $surat->id_surat)
                    ->where('nik_verifikator', $ttd->nik_penandatangan)
                    ->where('status_surat', 'Disetujui')
                    ->first();

                // Jika verifikasi disetujui, buat QR Code
                if ($verifikasiSurat) {
                    if (file_exists($logoPath)) {
                        QrCode::format('png')
                            ->merge($logoPath, 0.2, true)
                            ->size(300)
                            ->margin(0)
                            ->generate($pdfUrl, $qrcodePath);

                        // Tempatkan QR code di placeholder
                        $templateProcessor->setImageValue($placeholder, [
                            'path' => $qrcodePath,
                            'width' => 100,
                            'height' => 100,
                            'ratio' => true
                        ]);
                    } else {
                        Log::error('Logo file not found at: ' . $logoPath);
                    }
                } else {
                    // Jika tidak memenuhi syarat, tampilkan kotak abu-abu
                    if (file_exists($kotakAbuPath)) {
                        $templateProcessor->setImageValue($placeholder, [
                            'path' => $kotakAbuPath,
                            'width' => 100,
                            'height' => 100,
                            'ratio' => true
                        ]);
                    } else {
                        Log::error('Kotak abu-abu file not found at: ' . $kotakAbuPath);
                    }
                }
            } else {
                // Jika tidak ada tanda tangan, tampilkan kotak abu-abu
                if (file_exists($kotakAbuPath)) {
                    $templateProcessor->setImageValue($placeholder, [
                        'path' => $kotakAbuPath,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true
                    ]);
                }
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
