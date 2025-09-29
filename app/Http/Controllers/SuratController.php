<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\KlasifikasiSurat;
use App\Models\VerifikasiSurat;
use App\Models\SifatSurat;
use App\Models\StrukturOrganisasi;
use App\Models\DisposisiSurat;
use App\Models\TandaTangan;
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

class SuratController extends Controller
{
    //
    public function show($encryptedKodeSurat) {
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
        $disposisiAll= DisposisiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();
        // Kembali ke tampilan dengan data surat dan PDF
        return view('surat.show', compact('title', 'surat', 'pdfUrl','tanggalSurat','verifikasiSurat','disposisiAll'));
    }
   private function convertDocxToPdf($docxPath, $surat)
{
    $templateProcessor = new TemplateProcessor($docxPath);
    $templateProcessor->setValue('nomor', $surat->nomor_surat);
    $templateProcessor->setValue('perihal', $surat->perihal);
    $templateProcessor->setValue('sifat', $surat->sifat_surat->nama_sifat_surat);
    $templateProcessor->setValue('tanggal_surat', Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'));
    $templateProcessor->setValue('lampiran', $surat->lampiran);

    $tandaTangan = TandaTangan::where('id_surat', $surat->id_surat)->get();
    $placeholders = ['qrcode', 'qrcode_2', 'qrcode_3', 'qrcode_4'];

    $kotakAbuPath = public_path('assets/images/kotakabu.jpg');
    $logoPath = public_path('assets/images/web.png');
    $pdfUrl = url(route('surat.show', ['encryptedKodeSurat' => encrypt($surat->kode_surat)]));

    foreach ($placeholders as $placeholder) {
        $qrcodePath = storage_path('app/public/temp_surat/qrcode_with_logo_' . $placeholder . '.png');

        $ttd = $tandaTangan->where('status_ttd', $placeholder)->first();

        if ($ttd && $ttd->nik_penandatangan === $surat->nik_pengirim) {
            if (file_exists($logoPath)) {
                QrCode::format('png')
                    ->merge($logoPath, 0.2, true)
                    ->size(200)
                    ->margin(0)
                    ->generate($pdfUrl, $qrcodePath);

                $templateProcessor->setImageValue($placeholder, [
                    'path' => $qrcodePath,
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            }
        } elseif ($ttd) {
            $verifikasiSurat = VerifikasiSurat::where('id_surat', $surat->id_surat)
                ->where('nik_verifikator', $ttd->nik_penandatangan)
                ->where('status_surat', 'Disetujui')
                ->first();

            if ($verifikasiSurat && file_exists($logoPath)) {
                QrCode::format('png')
                    ->merge($logoPath, 0.2, true)
                    ->size(200)
                    ->margin(0)
                    ->generate($pdfUrl, $qrcodePath);

                $templateProcessor->setImageValue($placeholder, [
                    'path' => $qrcodePath,
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            } else {
                if (file_exists($kotakAbuPath)) {
                    $templateProcessor->setImageValue($placeholder, [
                        'path' => $kotakAbuPath,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true
                    ]);
                }
            }
        } else {
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

    $filledDocxPath = storage_path('app/public/temp_surat/filled_surat_keluar-' . $surat->kode_surat . '.docx');
    $templateProcessor->saveAs($filledDocxPath);

    $pdfPath = storage_path('app/public/temp_surat/filled_surat_keluar-' . $surat->kode_surat . '.pdf');
    $libreOfficePath = '/usr/bin/libreoffice';
    $command = '"' . $libreOfficePath . '" --headless --convert-to pdf --outdir "' . dirname($pdfPath) . '" "' . $filledDocxPath . '"';
    shell_exec($command);

    return file_exists($pdfPath) ? $pdfPath : false;
}
public function tampillampiran($filename)
{
    $path = 'uploads/lampiran/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        return response("File tidak ditemukan: $path", 404);
    }

    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        return response("File tidak ditemukan secara fisik: $fullPath", 404);
    }

    try {
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
        ]);
    } catch (\Exception $e) {
        return response("Gagal membuka file: " . $e->getMessage(), 500);
    }
}
}
