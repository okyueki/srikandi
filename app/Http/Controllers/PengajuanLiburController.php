<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanLibur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
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
    
//     public function rekapLibur(Request $request)
// {
//     $title = 'Rekapitulasi Libur Pegawai';

//     // Jika request bukan Ajax, tampilkan halaman rekaplibur.blade.php
//     if (!$request->ajax()) {
//         return view('pengajuan_libur.rekaplibur', compact('title'));
//     }

//     // Ambil data pengajuan cuti dengan relasi ke pegawai
//     $query = PengajuanLibur::with('pegawai')
//         ->select(
//             'pengajuan_libur.nik',
//             'pengajuan_libur.jenis_pengajuan_libur', 
//             'pengajuan_libur.jumlah_hari', 
//             'pengajuan_libur.tanggal_dibuat'
//         );

//     // Filter berdasarkan tanggal jika ada input
//     if ($request->has('start_date') && $request->has('end_date')) {
//         $query->whereBetween('pengajuan_libur.tanggal_dibuat', [$request->start_date, $request->end_date]);
//     }

//     // Ambil data dan kelompokkan berdasarkan NIK
//     $rekap = $query->get()->groupBy('nik')->map(function ($items) {
//         return [
//             'nama'       => optional($items->first()->pegawai)->nama, // Hindari error jika pegawai tidak ditemukan
//             'ijin'       => $items->where('jenis_pengajuan_libur', 'Ijin')->sum('jumlah_hari'),
//             'tahunan'    => $items->where('jenis_pengajuan_libur', 'Tahunan')->sum('jumlah_hari'),
//             'melahirkan' => $items->where('jenis_pengajuan_libur', 'Melahirkan')->sum('jumlah_hari'),
//             'ambil_libur'=> $items->where('jenis_pengajuan_libur', 'Ambil Libur')->sum('jumlah_hari'),
//             'menikah'    => $items->where('jenis_pengajuan_libur', 'Menikah')->sum('jumlah_hari'),
//             'total_hari' => $items->sum('jumlah_hari'),
//         ];
//     })->values();

//     return DataTables::of($rekap)->make(true);
// }

public function rekapLibur(Request $request)
{
    $title = 'Rekapitulasi Libur Pegawai';

    // Jika request bukan Ajax, tampilkan halaman rekaplibur.blade.php
    if (!$request->ajax()) {
        return view('pengajuan_libur.rekaplibur', compact('title'));
    }

    // Ambil data pengajuan cuti dengan relasi ke pegawai
    $query = PengajuanLibur::with('pegawai')
        ->select(
            'pengajuan_libur.nik',
            'pengajuan_libur.jenis_pengajuan_libur', 
            'pengajuan_libur.jumlah_hari', 
            'pengajuan_libur.tanggal_awal',
            'pengajuan_libur.tanggal_akhir',
            'pengajuan_libur.tanggal_dibuat'
        );

    // Filter berdasarkan tanggal jika ada input
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('pengajuan_libur.tanggal_dibuat', [$request->start_date, $request->end_date]);
    }

    // Ambil data dan kelompokkan berdasarkan NIK
    $rekap = $query->get()->groupBy('nik')->map(function ($items) {
        $badge = function ($dates) {
            return $dates->map(fn($i) => "<span class='badge bg-primary'>{$i->tanggal_awal} - {$i->tanggal_akhir}</span>")->implode(' ');
        };

        return [
            'nama'       => optional($items->first()->pegawai)->nama, // Hindari error jika pegawai tidak ditemukan
            'ijin'       => $badge($items->where('jenis_pengajuan_libur', 'Ijin')),
            'tahunan'    => $badge($items->where('jenis_pengajuan_libur', 'Tahunan')),
            'melahirkan' => $badge($items->where('jenis_pengajuan_libur', 'Melahirkan')),
            'ambil_libur'=> $badge($items->where('jenis_pengajuan_libur', 'Ambil Libur')),
            'menikah'    => $badge($items->where('jenis_pengajuan_libur', 'Menikah')),
            'total_hari' => $items->sum('jumlah_hari'),
        ];
    })->values();

    return DataTables::of($rekap)->rawColumns(['ijin', 'tahunan', 'melahirkan', 'ambil_libur', 'menikah'])->make(true);
}
}
