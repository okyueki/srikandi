<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegPeriksa;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class PasienRawatJalanController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Laporan Rawat Jalan';

        if ($request->ajax()) {
            $bulan = $request->bulan ?? Carbon::now()->format('Y-m');

            $startDate = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->format('Y-m-d');

            $data = RegPeriksa::selectRaw("
                    tgl_registrasi as tanggal,
                    COUNT(CASE WHEN stts = 'Belum' THEN 1 END) as belum,
                    COUNT(CASE WHEN stts = 'Sudah' THEN 1 END) as sudah,
                    COUNT(CASE WHEN stts = 'Batal' THEN 1 END) as batal,
                    COUNT(CASE WHEN stts = 'Berkas Diterima' THEN 1 END) as berkas_diterima,
                    COUNT(CASE WHEN stts = 'Dirujuk' THEN 1 END) as dirujuk,
                    COUNT(CASE WHEN stts = 'Meninggal' THEN 1 END) as meninggal,
                    COUNT(CASE WHEN stts = 'Dirawat' THEN 1 END) as dirawat,
                    COUNT(CASE WHEN stts = 'Pulang Paksa' THEN 1 END) as pulang_paksa
                ")
                ->whereBetween('tgl_registrasi', [$startDate, $endDate])
                ->groupBy('tgl_registrasi')
                ->orderBy('tgl_registrasi')
                ->get();

            // Buat tanggal lengkap agar hari tanpa data tetap muncul
            $period = [];
            $start = Carbon::createFromFormat('Y-m-d', $startDate);
            $end = Carbon::createFromFormat('Y-m-d', $endDate);

            while ($start->lte($end)) {
                $period[$start->format('Y-m-d')] = [
                    'tanggal' => $start->format('Y-m-d'),
                    'belum' => 0,
                    'sudah' => 0,
                    'batal' => 0,
                    'berkas_diterima' => 0,
                    'dirujuk' => 0,
                    'meninggal' => 0,
                    'dirawat' => 0,
                    'pulang_paksa' => 0,
                ];
                $start->addDay();
            }

            foreach ($data as $row) {
                $period[$row->tanggal] = [
                    'tanggal' => $row->tanggal,
                    'belum' => (int) $row->belum,
                    'sudah' => (int) $row->sudah,
                    'batal' => (int) $row->batal,
                    'berkas_diterima' => (int) $row->berkas_diterima,
                    'dirujuk' => (int) $row->dirujuk,
                    'meninggal' => (int) $row->meninggal,
                    'dirawat' => (int) $row->dirawat,
                    'pulang_paksa' => (int) $row->pulang_paksa,
                ];
            }

            $finalData = collect(array_values($period));

            return DataTables::of($finalData)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return Carbon::parse($row['tanggal'])->translatedFormat('d F Y');
                })
                ->make(true);
        }

        return view('manajemen.rawatjalan', compact('title'));
    }
}
