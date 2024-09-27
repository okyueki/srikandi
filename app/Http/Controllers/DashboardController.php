<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\RegPeriksa;
use App\Models\KamarInap;
use App\Models\TemporaryPresensi;
use App\Models\PemeriksaanRalan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // Jangan lupa untuk menambahkan 'pertumbuhanPasien' ke compact()
        return view('dashboard.index', compact('departemen', 'jumlahPegawai', 'pegawaiUlangTahun', 'bidang', 'jumlahPerBidang', 'jumlahPasienHariIni', 'pertumbuhanPasien','jumlahPasienRawatInap','jumlahPasienIGD','topTerlambat','topPegawaiRajin'));
    }
    
}