<?php

namespace App\Http\Controllers\grafik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RegPeriksa;
use App\Models\Poliklinik;
use App\Models\Dokter;
use Carbon\Carbon;

class GrafikralanController extends Controller
{
    public function index(Request $request) // Tambahkan $request sebagai parameter
    {
        // Dapatkan tahun saat ini
        $currentYear = Carbon::now()->year;

        // Ambil jumlah pasien per bulan pada tahun ini (total)
        $monthlyCountsTotal = RegPeriksa::selectRaw("MONTH(tgl_registrasi) as month, COUNT(*) as count")
            ->where('status_bayar', 'Sudah Bayar')
            ->whereYear('tgl_registrasi', $currentYear)
            ->groupByRaw("MONTH(tgl_registrasi)")
            ->pluck('count', 'month')
            ->toArray();

        $daftarPoli = Poliklinik::all(); // untuk dropdown Poli
        $daftarDokter = Dokter::all();   // untuk dropdown Dokter

        // Dapatkan filter dari request
        $selectedPoli = $request->input('kd_poli');
        $selectedDokter = $request->input('kd_dokter');

        // Filter data berdasarkan poli jika ada filter
        $monthlyCountsByPoli = RegPeriksa::selectRaw("kd_poli, MONTH(tgl_registrasi) as month, COUNT(*) as count")
            ->where('status_bayar', 'Sudah Bayar')
            ->whereYear('tgl_registrasi', $currentYear)
            ->when($selectedPoli, function ($query) use ($selectedPoli) {
                $query->where('kd_poli', $selectedPoli);
            })
            ->groupByRaw("kd_poli, MONTH(tgl_registrasi)")
            ->with('poliklinik') // Pastikan relasi ini ada di model
            ->get()
            ->groupBy('poliklinik.nm_poli')
            ->map(fn ($data) => $data->pluck('count', 'month')->toArray())
            ->toArray();

        // Filter data berdasarkan dokter jika ada filter
        $monthlyCountsByDokter = RegPeriksa::selectRaw("kd_dokter, MONTH(tgl_registrasi) as month, COUNT(*) as count")
            ->where('status_bayar', 'Sudah Bayar')
            ->whereYear('tgl_registrasi', $currentYear)
            ->when($selectedDokter, function ($query) use ($selectedDokter) {
                $query->where('kd_dokter', $selectedDokter);
            })
            ->groupByRaw("kd_dokter, MONTH(tgl_registrasi)")
            ->with('dokter') // Pastikan relasi ini ada di model
            ->get()
            ->groupBy('dokter.nm_dokter')
            ->map(fn ($data) => $data->pluck('count', 'month')->toArray())
            ->toArray();

        // Nama bulan untuk label X-axis
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        
        // Kirim data ke view
        return view('grafik.grafikralan', compact(
            'monthlyCountsTotal',
            'monthlyCountsByPoli',
            'monthlyCountsByDokter',
            'monthNames',
            'currentYear',
            'daftarPoli',
            'daftarDokter',
            'selectedPoli',
            'selectedDokter'
        ));
    }
}
