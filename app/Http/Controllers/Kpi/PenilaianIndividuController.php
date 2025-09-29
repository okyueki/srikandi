<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\RekapPresensi;
use App\Models\PenilaianIndividu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianIndividuController extends Controller
{
    public function index()
    {
        $penilaians = PenilaianIndividu::orderBy('created_at', 'desc')->get();
        $title = 'Data Penilaian Individu';

        return view('kpi.penilaian_individu_index', compact('title', 'penilaians'));
    }

    public function create()
    {
        $title = 'Form Penilaian Individu';
        $bulan = now()->format('Y-m');
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();

        $user = Auth::user();
        $nikAtasan = $user->username;
        $namaAtasan = $user->name;

        return view('kpi.penilaian_individu_create', compact('title', 'bulan', 'pegawai', 'nikAtasan', 'namaAtasan'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'penilaian_bulan' => 'required|date_format:Y-m',
        'nik_bawahan' => 'required',
        'kepatuhan' => 'required|numeric|min:0|max:5',
        'keaktifan' => 'required|numeric|min:0|max:5',
        'budaya_kerja' => 'required|numeric|min:0|max:5',
        'kajian' => 'required|numeric|min:0|max:5',
        'kegiatan_rs' => 'required|numeric|min:0|max:5',
        'iht' => 'required|numeric|min:0|max:5',
    ]);

    $validated['penilaian_bulan'] .= '-01';

    $pegawai = Pegawai::where('nik', $validated['nik_bawahan'])->first();
    if (!$pegawai) {
        return redirect()->back()->withErrors('Pegawai tidak ditemukan.');
    }

    $validated['nama_bawahan'] = $pegawai->nama;
    $validated['departemen'] = $pegawai->departemen;

    $bobot = [
        'kepatuhan' => 25,
        'keaktifan' => 20,
        'budaya_kerja' => 25,
        'kajian' => 15,
        'kegiatan_rs' => 10,
        'iht' => 5,
    ];

    $persentase = [];
    foreach (['kepatuhan', 'keaktifan', 'budaya_kerja', 'kajian', 'kegiatan_rs', 'iht'] as $key) {
        $persentase["{$key}_persentase"] = ($validated[$key] * $bobot[$key]) / 5;
    }

    $total_nilai = array_sum(array_values(array_intersect_key($validated, $bobot)));
    $total_persentase = array_sum($persentase);

    $dataToSave = array_merge($validated, $persentase, [
        'nik_atasan' => Auth::user()->username,
        'nama_atasan' => Auth::user()->name,
        'tanggal' => now()->format('Y-m-d'),
        'total_nilai' => $total_nilai,
        'total_persentase' => $total_persentase,
    ]);

    try {
        PenilaianIndividu::create($dataToSave);
        return redirect()->route('penilaian_individu.index')->with('success', 'Penilaian berhasil disimpan!');
    } catch (\Exception $e) {
        \Log::error('Error saat menyimpan data: ' . $e->getMessage());
        return redirect()->back()->withErrors('Gagal menyimpan data. Silakan coba lagi.');
    }
}

    public function show($id)
    {
        $penilaian = PenilaianIndividu::findOrFail($id);
        $title = 'Detail Penilaian Individu';

        return view('kpi.penilaian_individu_show', compact('penilaian', 'title'));
    }

    public function edit($id)
    {
        $penilaian = PenilaianIndividu::findOrFail($id);
        $title = 'Edit Penilaian Individu';
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();

        return view('kpi.penilaian_individu_edit', compact('penilaian', 'title', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $penilaian = PenilaianIndividu::findOrFail($id);

        $validated = $request->validate([
            'penilaian_bulan' => 'required|date_format:Y-m',
            'kepatuhan' => 'required|numeric|min:0|max:5',
            'keaktifan' => 'required|numeric|min:0|max:5',
            'budaya_kerja' => 'required|numeric|min:0|max:5',
            'kajian' => 'required|numeric|min:0|max:5',
            'kegiatan_rs' => 'required|numeric|min:0|max:5',
            'iht' => 'required|numeric|min:0|max:5',
        ]);

        $validated['penilaian_bulan'] .= '-01';

        $bobot = [
            'kepatuhan' => 25,
            'keaktifan' => 20,
            'budaya_kerja' => 25,
            'kajian' => 15,
            'kegiatan_rs' => 10,
            'iht' => 5,
        ];

        $persentase = [];
        foreach (['kepatuhan', 'keaktifan', 'budaya_kerja', 'kajian', 'kegiatan_rs', 'iht'] as $key) {
            $persentase["{$key}_persentase"] = ($validated[$key] * $bobot[$key]) / 5;
        }

        $total_nilai = array_sum(array_values(array_intersect_key($validated, $bobot)));
        $total_persentase = array_sum($persentase);

        $dataToUpdate = array_merge($validated, $persentase, [
            'total_nilai' => $total_nilai,
            'total_persentase' => $total_persentase,
        ]);

        try {
            $penilaian->update($dataToUpdate);
            return redirect()->route('kpi.penilaian.index')->with('success', 'Penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error saat memperbarui data: ' . $e->getMessage());
            return redirect()->back()->withErrors('Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $penilaian = PenilaianIndividu::findOrFail($id);
            $penilaian->delete();
            return redirect()->route('kpi.penilaian.index')->with('success', 'Penilaian berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error saat menghapus data: ' . $e->getMessage());
            return redirect()->back()->withErrors('Gagal menghapus data.');
        }
    }
    
    public function getKepatuhan(Request $request)
    {
        $request->validate([
            'nik_bawahan' => 'required',
            'bulan' => 'required|date_format:Y-m',
        ]);

        $pegawai = Pegawai::where('nik', $request->nik_bawahan)->first();
        if (!$pegawai) {
            return response()->json(['error' => 'Pegawai tidak ditemukan'], 404);
        }

        $presensiCount = RekapPresensi::where('id', $pegawai->id)
            ->whereYear('jam_datang', date('Y', strtotime($request->bulan)))
            ->whereMonth('jam_datang', date('m', strtotime($request->bulan)))
            ->whereIn('status', [
                'Terlambat Toleransi',
                'Terlambat I',
                'Terlambat II',
                'Terlambat Toleransi & PSW',
                'Terlambat I & PSW',
                'Terlambat II & PSW',
            ])
            ->count();

        $nilai = 5 - min($presensiCount, 5);

        return response()->json([
            'keterlambatan' => $presensiCount,
            'nilai' => $nilai,
            'persentase' => ($nilai / 5) * 25, // Perbaiki rumus
        ]);
    }
}
