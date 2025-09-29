<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\RegPeriksa;
use App\Models\KamarInap;
use App\Models\TemporaryPresensi;
use App\Models\PemeriksaanRalan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PengajuanLibur;

class DashboardController extends Controller
{
    public function index()
{
    // Data untuk pegawai yang terlambat hari ini
    $topTerlambat = TemporaryPresensi::with('pegawai')  // Memuat relasi dengan tabel pegawai
        ->whereIn('status', ['Terlambat Toleransi', 'Terlambat I', 'Terlambat II'])  // Filter berdasarkan status
        ->whereDate('jam_datang', today())  // Data untuk hari ini
        ->orderBy(DB::raw("TIME_TO_SEC(STR_TO_DATE(keterlambatan, '%H:%i:%s'))"), 'desc')  // Urutkan berdasarkan keterlambatan terbesar
        ->limit(5)  // Batas 7 pegawai
        ->get();
            
    $topPegawaiRajin = PemeriksaanRalan::select('pegawai.nama as nama_pegawai', 'pemeriksaan_ralan.nip', DB::raw('COUNT(pemeriksaan_ralan.no_rawat) as jumlah_entri'))
    ->join('pegawai', 'pemeriksaan_ralan.nip', '=', 'pegawai.nik')  // Relasi dengan pegawai melalui nik
    ->where('pemeriksaan_ralan.tgl_perawatan', '>=', now()->subDays(30))  // Data dari 30 hari terakhir
    ->groupBy('pemeriksaan_ralan.nip', 'pegawai.nama')  // Tambahkan pegawai.nama ke dalam GROUP BY
    ->orderBy('jumlah_entri', 'desc')  // Urutkan berdasarkan jumlah entri terbanyak
    ->limit(5)  // Ambil 10 pegawai teratas
    ->get();
            
    // Ambil data jumlah pegawai per departemen dengan filter stts_aktif = 'AKTIF'
    $pegawaiPerDepartemen = Pegawai::select('departemen', \DB::raw('count(*) as total'))
        ->where('stts_aktif', 'AKTIF')
        ->groupBy('departemen')
        ->get();

   $nik = Auth::user()->username;
    $pegawai = Pegawai::where('nik', $nik)->first();

    // Pastikan $presensiUser didefinisikan sebagai collection kosong
    $presensiUser = collect();

    if ($pegawai) {
        // Ambil data presensi jika pegawai ditemukan
        $presensiUser = TemporaryPresensi::where('id', $pegawai->id)
            ->orderBy('jam_datang', 'desc')
            ->get();
    }

    // Cek apakah ada presensi hari ini
    $presensiHariIni = $presensiUser->where('jam_datang', '>=', today())->first();

    // Tentukan pesan presensi berdasarkan apakah sudah ada data presensi hari ini atau belum
    if ($presensiHariIni) {
        $presensiMessage = "Anda sudah melakukan presensi pada pukul " . \Carbon\Carbon::parse($presensiHariIni->jam_datang)->format('H:i');
    } else {
        $presensiMessage = "Anda belum melakukan presensi hari ini.";
    }


    // Siapkan data untuk chart per departemen
    $totalDepartemen = $pegawaiPerDepartemen->sum('total');
    $departemen = $pegawaiPerDepartemen->map(function($item) use ($totalDepartemen) {
        $percentage = ($item->total / $totalDepartemen) * 100;
        return [
            'x' => $item->departemen,
            'y' => $item->total,
            'label' => "{$item->total} (" . number_format($percentage, 2) . "%)"
        ];
    });
    $jumlahPegawai = $pegawaiPerDepartemen->pluck('total');

    // Ambil data jumlah pegawai berdasarkan bidang dengan filter stts_aktif = 'AKTIF'
    $pegawaiPerBidang = Pegawai::select('bidang', \DB::raw('count(*) as total'))
        ->where('stts_aktif', 'AKTIF')
        ->groupBy('bidang')
        ->get();

    // Siapkan data untuk pie chart
    $totalBidang = $pegawaiPerBidang->sum('total');
    $bidang = $pegawaiPerBidang->map(function($item) use ($totalBidang) {
        $percentage = ($item->total / $totalBidang) * 100;
        return [
            'x' => $item->bidang,
            'y' => $item->total,
            'label' => "{$item->total} (" . number_format($percentage, 2) . "%)"
        ];
    });
    $jumlahPerBidang = $pegawaiPerBidang->pluck('total');
    
    // Get the current date
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    // Query to count patients examined today
    $jumlahPasienHariIni = RegPeriksa::whereDate('tgl_registrasi', $today)->count();

    // Query to count patients examined yesterday
    $jumlahPasienKemarin = RegPeriksa::whereDate('tgl_registrasi', $yesterday)->count();

    // Hitung pertumbuhan pasien
    if ($jumlahPasienKemarin > 0) {
        $pertumbuhanPasien = $jumlahPasienHariIni - $jumlahPasienKemarin;
    } else {
        // Jika tidak ada pasien kemarin, anggap pertumbuhannya adalah jumlah pasien hari ini
        $pertumbuhanPasien = $jumlahPasienHariIni;
    }
    
    $jumlahPasienRawatInap = KamarInap::where('stts_pulang', '-')
        ->where('lama', '<', 6)
        ->count();
    
    $jumlahPasienIGD = RegPeriksa::whereDate('tgl_registrasi', $today)
        ->where('kd_poli', 'IGDK')
        ->count();
    
    // Ambil pegawai yang ulang tahun dalam rentang 10 hari ke depan
    $tanggalSekarang = Carbon::now();
    $tanggalAkhir = Carbon::now()->addDays(7);
    $pegawaiUlangTahun = Pegawai::where('stts_aktif', 'AKTIF')
        ->whereRaw("DATE_FORMAT(tgl_lahir, '%m-%d') BETWEEN ? AND ?", [
            $tanggalSekarang->format('m-d'),
            $tanggalAkhir->format('m-d')
        ])
        ->get()
        ->map(function ($pegawai) use ($tanggalSekarang) {
            $tanggalLahir = Carbon::parse($pegawai->tgl_lahir)->year($tanggalSekarang->year);
            $hariIni = $tanggalSekarang->isSameDay($tanggalLahir);
            $sisaHari = $tanggalSekarang->diffInDays($tanggalLahir, false);

            if ($hariIni) {
                $pegawai->status = 'Selamat Ulang Tahun';
                $pegawai->sisaHari = 0;
            } elseif ($sisaHari > 0) {
                $pegawai->status = "Ulang tahun {$sisaHari} hari lagi";
                $pegawai->sisaHari = $sisaHari;
            }

            return $pegawai;
        })
        ->filter(function ($pegawai) {
            return $pegawai->status !== null;
        })
        ->sortBy('sisaHari');
        
        $tahunini = Carbon::now()->year; // Tahun saat ini
        $totalHari = DB::table('pengajuan_libur')
            ->where('jenis_pengajuan_libur', 'Tahunan')
            ->where('nik', $nik)
            ->whereYear('tanggal_dibuat', $tahunini)
            ->sum('jumlah_hari');

    // Jangan lupa untuk menambahkan 'pertumbuhanPasien' ke compact()
    return view('dashboard.index', compact(
        'departemen', 'jumlahPegawai', 'pegawaiUlangTahun', 'bidang', 
        'jumlahPerBidang', 'jumlahPasienHariIni', 'pertumbuhanPasien',
        'jumlahPasienRawatInap', 'jumlahPasienIGD', 'topTerlambat', 
        'topPegawaiRajin', 'presensiUser', 'presensiMessage', 'totalHari'
    ));
}
    public function getPegawaiBelumPresensi()
{
    $today = now()->toDateString(); // Format: YYYY-MM-DD
    $currentMonth = now()->format('m'); // Format: MM
    $currentDayColumn = 'h' . now()->format('j'); // Format: h1, h2, ..., h31
    $shiftsPagi = [
        'Pagi', 'Pagi2', 'Pagi3', 'Pagi4', 'Pagi5', 'Pagi6', 'Pagi7', 'Pagi8', 'Pagi9', 'Pagi10',
        'Midle Pagi1', 'Midle Pagi2', 'Midle Pagi3', 'Midle Pagi4', 'Midle Pagi5', 'Midle Pagi6', 'Midle Pagi7', 'Midle Pagi8', 'Midle Pagi9', 'Midle Pagi10'
    ];

    // 1️⃣ Cari Pegawai yang Dijadwalkan Masuk Hari Ini
    $pegawaiDijadwalkan = JadwalPegawai::where('bulan', $currentMonth)
        ->whereIn($currentDayColumn, $shiftsPagi)
        ->pluck('id'); // Ambil ID pegawai yang masuk shift pagi hari ini

    // 2️⃣ Cari Pegawai yang Sudah Presensi Hari Ini
    $pegawaiSudahPresensi = TemporaryPresensi::whereDate('jam_datang', $today)
        ->whereIn('shift', $shiftsPagi)
        ->pluck('id'); // Ambil ID pegawai yang sudah absen

    // 3️⃣ Cari Pegawai yang Belum Presensi
    $pegawaiBelumPresensi = Pegawai::whereIn('id', $pegawaiDijadwalkan)
        ->whereNotIn('id', $pegawaiSudahPresensi)
        ->get();

    return response()->json($pegawaiBelumPresensi);
}

}