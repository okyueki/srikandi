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

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Surat Masuk';
        $nik = Auth::user()->username; // Mendapatkan NIK user yang sedang login

        if ($request->ajax()) {
            // Mengambil data surat yang sesuai dengan verifikator (nik_verifikator) dan status 'Dikirim'
            $surat = Surat::with(['pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat'])
                ->whereHas('verifikasi', function($query) use ($nik) {
                    $query->where('nik_verifikator', $nik)
                          ->where('status_surat', 'Dikirim');
                })
                ->get();

            return DataTables::of($surat)
                ->addIndexColumn() // Menambahkan kolom index
                ->addColumn('nama_pegawai', function ($row) {
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->verifikasi ? $row->verifikasi->status_surat : '-';
                })
                ->addColumn('action', function ($row) {
                    // Tombol edit dan lihat surat
                    return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_masuk.verifikasi', encrypt($row->kode_surat)).'"><i class="far fa-edit"></i></a> ';
                })
                ->rawColumns(['action']) // Mengizinkan HTML di kolom action
                ->make(true); // Mengirim response JSON ke DataTables
        }

        return view('surat_masuk.index', compact('title')); // Menampilkan view index
    }
    public function verifikasi($encryptedKodeSurat) 
{
    $title = 'Verifikasi Surat Masuk';
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