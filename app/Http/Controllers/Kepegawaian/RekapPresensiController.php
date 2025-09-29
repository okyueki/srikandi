<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\RekapPresensi;
use App\Models\JadwalPegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class RekapPresensiController extends Controller
{
    public function index(Request $request)
{
    // Filter berdasarkan bulan, default adalah bulan saat ini
    $bulan = $request->input('bulan', Carbon::now()->format('Y-m'));

    // Dapatkan NIK dari user yang sedang login
    $nik = Auth::user()->username;

    // Jika ini adalah request AJAX dari DataTables
    if ($request->ajax()) {
        $rekapPresensi = RekapPresensi::with('pegawai')
            ->whereHas('pegawai', function ($query) use ($nik) {
                $query->where('nik', $nik);
            })
            ->whereYear('jam_datang', '=', Carbon::parse($bulan)->year)
            ->whereMonth('jam_datang', '=', Carbon::parse($bulan)->month);

        return DataTables::of($rekapPresensi)
            ->addIndexColumn()
            ->addColumn('nama_pegawai', function ($row) {
                return $row->pegawai->nama;
            })
            ->addColumn('departemen', function ($row) {
                return $row->pegawai->departemen;
            })
            ->addColumn('photo', function ($row) {
                return '<img src="' . $row->photo . '" alt="Photo" style="max-width: 100px;">';
            })
            ->rawColumns(['photo'])
            ->make(true);
    }

    // Mengambil data presensi user berdasarkan bulan untuk statistik
    $presensi = RekapPresensi::whereHas('pegawai', function ($query) use ($nik) {
        $query->where('nik', $nik);
    })
    ->whereYear('jam_datang', '=', Carbon::parse($bulan)->year)
    ->whereMonth('jam_datang', '=', Carbon::parse($bulan)->month)
    ->get();

    // Hitung jumlah tepat waktu dan terlambat
    $jumlahTepatWaktu = $presensi->whereIn('status', ['Tepat Waktu', 'Tepat Waktu & PSW'])->count();
    $jumlahTerlambat = $presensi->whereNotIn('status', ['Tepat Waktu', 'Tepat Waktu & PSW'])->count();
    $totalKehadiran = $presensi->count();
    $persenTerlambat = $totalKehadiran > 0 ? ($jumlahTerlambat / $totalKehadiran) * 100 : 0;
    $persenTepatWaktu = $totalKehadiran > 0 ? ($jumlahTepatWaktu / $totalKehadiran) * 100 : 0;

    // Mengambil data jadwal pegawai dengan join ke tabel pegawai
    $jadwalPegawai = JadwalPegawai::whereHas('pegawai', function ($query) use ($nik) {
        $query->where('nik', $nik);
    })
    ->where('tahun', Carbon::parse($bulan)->year)
    ->where('bulan', Carbon::parse($bulan)->format('m'))
    ->first();

    // Pastikan $jadwalPegawai terdefinisi meskipun null
    $jadwalPegawai = $jadwalPegawai ?? new JadwalPegawai();

    // Menghitung wajib masuk dan cek hari yang absen
    $wajibMasuk = 0;
    $missedDays = [];

    if ($jadwalPegawai->exists) {
        foreach (range(1, 31) as $day) {
            $field = 'h' . $day;
            if (!empty($jadwalPegawai->$field)) {
                $wajibMasuk++;

                // Cek apakah ada kehadiran di hari tersebut
                $tanggal = Carbon::parse($bulan . '-' . str_pad($day, 2, '0', STR_PAD_LEFT))->toDateString();
                $hadir = $presensi->contains(function ($item) use ($tanggal) {
                    return Carbon::parse($item->jam_datang)->toDateString() === $tanggal;
                });

                // Jika tidak hadir, masukkan ke dalam daftar missedDays
                if (!$hadir) {
                    $missedDays[] = $day;
                }
            }
        }
    }
    
    $hariHadir = $wajibMasuk - count($missedDays);
    $persenHadir = $wajibMasuk > 0 ? ($hariHadir / $wajibMasuk) * 100 : 0;
    $persenHadir = number_format($persenHadir, 2);
    // Kirim data ke view
    return view('presensi.rekap_presensi', compact('bulan', 'jumlahTerlambat', 'jumlahTepatWaktu', 'persenTerlambat', 'persenTepatWaktu', 'wajibMasuk', 'missedDays', 'jadwalPegawai', 'persenHadir'));
}

public function getPresensiData(Request $request)
{
    $bulan = $request->input('bulan', Carbon::now()->format('Y-m'));
    $nik = Auth::user()->username;

    $presensi = RekapPresensi::whereHas('pegawai', function ($query) use ($nik) {
        $query->where('nik', $nik);
    })
    ->whereYear('jam_datang', '=', Carbon::parse($bulan)->year)
    ->whereMonth('jam_datang', '=', Carbon::parse($bulan)->month)
    ->get();

    $jumlahTepatWaktu = $presensi->whereIn('status', ['Tepat Waktu', 'Tepat Waktu & PSW'])->count();
    $jumlahTerlambat = $presensi->whereNotIn('status', ['Tepat Waktu', 'Tepat Waktu & PSW'])->count();
    $totalKehadiran = $presensi->count();
    $persenTerlambat = $totalKehadiran > 0 ? ($jumlahTerlambat / $totalKehadiran) * 100 : 0;
    $persenTepatWaktu = $totalKehadiran > 0 ? ($jumlahTepatWaktu / $totalKehadiran) * 100 : 0;

    $jadwalPegawai = JadwalPegawai::whereHas('pegawai', function ($query) use ($nik) {
        $query->where('nik', $nik);
    })
    ->where('tahun', Carbon::parse($bulan)->year)
    ->where('bulan', Carbon::parse($bulan)->format('m'))
    ->first();

    $wajibMasuk = 0;
    $missedDays = [];

    if ($jadwalPegawai) {
        foreach (range(1, 31) as $day) {
            $field = 'h' . $day;
            if (!empty($jadwalPegawai->$field)) {
                $wajibMasuk++;

                $tanggal = Carbon::parse($bulan . '-' . str_pad($day, 2, '0', STR_PAD_LEFT))->toDateString();
                $hadir = $presensi->contains(function ($item) use ($tanggal) {
                    return Carbon::parse($item->jam_datang)->toDateString() === $tanggal;
                });

                if (!$hadir) {
                    $missedDays[] = $day;
                }
            }
        }
    }

    return response()->json([
        'jumlahTerlambat' => $jumlahTerlambat,
        'jumlahTepatWaktu' => $jumlahTepatWaktu,
        'persenTerlambat' => $persenTerlambat,
        'persenTepatWaktu' => $persenTepatWaktu,
        'wajibMasuk' => $wajibMasuk,
        'missedDays' => $missedDays,
        'daysInMonth' => Carbon::parse($bulan)->daysInMonth,
        'jadwalPegawai' => $jadwalPegawai ? $jadwalPegawai->toArray() : []
    ]);
}
}
