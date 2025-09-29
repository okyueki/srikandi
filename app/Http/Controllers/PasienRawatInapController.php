<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KamarInap;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class PasienRawatInapController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Laporan Rawat Inap';

        if ($request->ajax()) {
            $bulan = $request->bulan ?? Carbon::now()->format('Y-m');

            // Tentukan tanggal awal dan akhir bulan
            $startDate = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d');

            // Query data per tanggal di bulan itu
            $data = KamarInap::selectRaw("
                    tgl_masuk as tanggal,
                    COUNT(CASE WHEN stts_pulang = '-' AND (tgl_keluar IS NULL OR tgl_keluar = '') THEN 1 END) as masih_dirawat,
                    COUNT(CASE WHEN stts_pulang = 'Membaik' THEN 1 END) as membaik,
                    COUNT(CASE WHEN stts_pulang = 'Rujuk' THEN 1 END) as rujuk,
                    COUNT(CASE WHEN stts_pulang = 'Meninggal' THEN 1 END) as meninggal
                ")
                ->whereBetween('tgl_masuk', [$startDate, $endDate])
                ->groupBy('tgl_masuk')
                ->orderBy('tgl_masuk')
                ->get();

            // Buat range tanggal lengkap agar hari tanpa data tetap tampil 0
            $period = [];
            $start = Carbon::createFromFormat('Y-m-d', $startDate);
            $end = Carbon::createFromFormat('Y-m-d', $endDate);

            while ($start->lte($end)) {
                $period[$start->format('Y-m-d')] = [
                    'tanggal' => $start->format('Y-m-d'),
                    'masih_dirawat' => 0,
                    'membaik' => 0,
                    'rujuk' => 0,
                    'meninggal' => 0,
                ];
                $start->addDay();
            }

            foreach ($data as $row) {
                $period[$row->tanggal] = [
                    'tanggal' => $row->tanggal,
                    'masih_dirawat' => (int) $row->masih_dirawat,
                    'membaik' => (int) $row->membaik,
                    'rujuk' => (int) $row->rujuk,
                    'meninggal' => (int) $row->meninggal,
                ];
            }

            $finalData = collect(array_values($period));

            return datatables()->of($finalData)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return Carbon::parse($row['tanggal'])->translatedFormat('d F Y');
                })
                ->make(true);
        }

        return view('manajemen.rawatinap', compact('title'));
    }
}
