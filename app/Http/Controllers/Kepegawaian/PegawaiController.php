<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sttsAktif = $request->input('stts_aktif');
        $departemen = $request->input('departemen');

        // Query untuk mengambil data pegawai dan hitung jumlah pemeriksaan
        $pegawai = Pegawai::withCount('pemeriksaanRalan')
            ->when($search, function ($query, $search) {
                return $query->where('nik', 'like', "%{$search}%")
                             ->orWhere('nama', 'like', "%{$search}%");
            })
            ->when($sttsAktif, function ($query, $sttsAktif) {
                return $query->where('stts_aktif', $sttsAktif);
            })
            ->when($departemen, function ($query, $departemen) {
                return $query->whereHas('indexinsDepartemen', function ($query) use ($departemen) {
                    $query->where('nama', 'like', "%{$departemen}%");
                });
            })
            ->paginate(10)
            ->appends($request->query());  // Retain query parameters during pagination

        // Hitung jumlah pegawai sesuai filter
        $totalPegawai = Pegawai::when($search, function ($query, $search) {
                return $query->where('nik', 'like', "%{$search}%")
                             ->orWhere('nama', 'like', "%{$search}%");
            })
            ->when($sttsAktif, function ($query, $sttsAktif) {
                return $query->where('stts_aktif', $sttsAktif);
            })
            ->when($departemen, function ($query, $departemen) {
                return $query->whereHas('indexinsDepartemen', function ($query) use ($departemen) {
                    $query->where('nama', 'like', "%{$departemen}%");
                });
            })
            ->count();

        return view('presensi.pegawai', compact('pegawai', 'search', 'sttsAktif', 'departemen', 'totalPegawai'));
    }
}
