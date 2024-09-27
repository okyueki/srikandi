<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanLibur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QRCode

class PengajuanLiburController extends Controller
{
    public function show($encryptedKodePengajuanLibur)
    {
        $title = 'Pengajuan Libur';
        $kode_pengajuan_libur = decrypt($encryptedKodePengajuanLibur);

        $pengajuanlibur = PengajuanLibur::with(['pegawai.departemen_unit', 'pegawai2','petugas'])
        ->where('kode_pengajuan_libur', $kode_pengajuan_libur)
        ->firstOrFail();

        // Buat URL untuk menampilkan PDF (gunakan route untuk PDF)
        if ($pengajuanlibur->jenis_pengajuan_libur == 'Ijin'){
            $pdfUrl = route('pengajuan-libur-ijin.pdf', ['kode_pengajuan_libur' => $encryptedKodePengajuanLibur]);
        }else{
            $pdfUrl = route('pengajuan-libur-cuti.pdf', ['kode_pengajuan_libur' => $encryptedKodePengajuanLibur]);
        }
        return view('pengajuan_libur.show', compact('pengajuanlibur','title','pdfUrl'));
    }

    public function generateCutiPDF($encryptedKodePengajuanLibur)
    {
        Carbon::setLocale('id');
         // Ambil data pengajuan libur berdasarkan id
        $kode_pengajuan_libur = decrypt($encryptedKodePengajuanLibur);

        $pengajuan = PengajuanLibur::with(['pegawai.departemen_unit', 'pegawai2', 'petugas'])
        ->where('kode_pengajuan_libur', $kode_pengajuan_libur)
        ->firstOrFail();

        $totalHari = PengajuanLibur::where('kode_pengajuan_libur', $kode_pengajuan_libur)
            ->where('jenis_pengajuan_libur', 'Tahunan')
            ->sum('jumlah_hari');

        $qrCodeData = url('/pengajuan_libur/cuti/pdf/' . $encryptedKodePengajuanLibur);
        $qrcode = QrCode::format('png')->size(300)->margin(0)->generate($qrCodeData);

         // Path ke logo yang akan ditambahkan di QR code
        $logoPath = public_path('assets/images/web.png');

        // Generate QR code dengan logo di tengahnya
        $qrcode = QrCode::format('png')
            ->size(300) // Ukuran QR code
            ->merge($logoPath, 0.2, true) // Tambahkan logo di tengah dengan ukuran relatif (30%)
            ->margin(0)
            ->generate($qrCodeData);

        // Encode QR Code ke base64
        $qrcodeBase64 = base64_encode($qrcode);
        $qrcodeDataUri = 'data:image/png;base64,' . $qrcodeBase64;
    
    // Siapkan data untuk dikirim ke view
    $tanggal_awal = Carbon::parse($pengajuan->tanggal_awal)->translatedFormat('l, d F Y');
    $tanggal_akhir = Carbon::parse($pengajuan->tanggal_akhir)->translatedFormat('l, d F Y');
    $tanggal_dibuat = Carbon::parse($pengajuan->tanggal)->translatedFormat('d F Y');

    // Encode gambar kop surat ke base64
    $path = public_path('assets/images/logo_hitam.png'); // Ganti dengan path gambar Anda
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

       $data = [
           'pengajuan' => $pengajuan,
           'qrcode' =>  $qrcodeDataUri,
           'tanggal_awal' =>$tanggal_awal,
           'tanggal_akhir' =>$tanggal_akhir,
           'tanggal_dibuat' =>$tanggal_dibuat,
           'kop_surat' => $base64,
           'totalHari' => $totalHari,
       ];

        $pdf = PDF::loadView('pengajuan_libur.cutipdfview', $data);
        //return view('verifikasi_pengajuan_libur.pdfview', $data);
        // Stream PDF agar bisa di-embed di halaman browser
        return $pdf->stream('pengajuan_libur_' . $pengajuan->kode_pengajuan_libur . '.pdf');
       // return response($qrcode)->header('Content-Type', 'text/html');
    }

    public function generateIjinPDF($encryptedKodePengajuanLibur)
    {
        Carbon::setLocale('id');
         // Ambil data pengajuan libur berdasarkan id
        $kode_pengajuan_libur = decrypt($encryptedKodePengajuanLibur);

        $pengajuan = PengajuanLibur::with(['pegawai.departemen_unit', 'pegawai2', 'petugas'])
        ->where('kode_pengajuan_libur', $kode_pengajuan_libur)
        ->firstOrFail();

        $totalHari = PengajuanLibur::where('kode_pengajuan_libur', $kode_pengajuan_libur)
            ->where('jenis_pengajuan_libur', 'Tahunan')
            ->sum('jumlah_hari');

        $qrCodeData = url('/pengajuan_libur/ijin/pdf/' . $encryptedKodePengajuanLibur);
        $qrcode = QrCode::format('png')->size(300)->margin(0)->generate($qrCodeData);

         // Path ke logo yang akan ditambahkan di QR code
        $logoPath = public_path('assets/images/web.png');

        // Generate QR code dengan logo di tengahnya
        $qrcode = QrCode::format('png')
            ->size(300) // Ukuran QR code
            ->merge($logoPath, 0.2, true) // Tambahkan logo di tengah dengan ukuran relatif (30%)
            ->margin(0)
            ->generate($qrCodeData);

        // Encode QR Code ke base64
        $qrcodeBase64 = base64_encode($qrcode);
        $qrcodeDataUri = 'data:image/png;base64,' . $qrcodeBase64;
    
    // Siapkan data untuk dikirim ke view
    $tanggal_awal = Carbon::parse($pengajuan->tanggal_awal)->translatedFormat('l, d F Y');
    $tanggal_akhir = Carbon::parse($pengajuan->tanggal_akhir)->translatedFormat('l, d F Y');
    $tanggal_dibuat = Carbon::parse($pengajuan->tanggal)->translatedFormat('d F Y');

    // Encode gambar kop surat ke base64
    $path = public_path('assets/images/logo_hitam.png'); // Ganti dengan path gambar Anda
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

       $data = [
           'pengajuan' => $pengajuan,
           'qrcode' =>  $qrcodeDataUri,
           'tanggal_awal' =>$tanggal_awal,
           'tanggal_akhir' =>$tanggal_akhir,
           'tanggal_dibuat' =>$tanggal_dibuat,
           'kop_surat' => $base64,
           'totalHari' => $totalHari,
       ];

        $pdf = PDF::loadView('pengajuan_libur.ijinpdfview', $data);
       //return view('pengajuan_libur.ijinpdfview', $data);
        // Stream PDF agar bisa di-embed di halaman browser
        return $pdf->stream('pengajuan_libur_' . $pengajuan->kode_pengajuan_libur . '.pdf');
       //return response($qrcode)->header('Content-Type', 'text/html');
    }
}
