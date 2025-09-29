<?php

namespace App\Http\Controllers;

use App\Models\PenilaianKpi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PenilaianKpiController extends Controller
{
    public function create()
    {
        // Ambil data pegawai untuk dropdown
        $pegawai = Pegawai::all();
        return view('penilaian_kpi.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required|string|max:20',
            'nik_bawahan' => 'required|string|max:20',
            'tanggal_penilaian' => 'required|date',
            'indikator_id' => 'required|integer',
            'poin' => 'required|integer',
            'nilai_persen' => 'required|numeric',
            'nilai_total' => 'required|numeric',
        ]);

        // Menyimpan data ke database
        PenilaianKpi::create($request->all());

        return redirect()->route('penilaian_kpi.index')->with('success', 'Data penilaian KPI berhasil disimpan.');
    }
}
