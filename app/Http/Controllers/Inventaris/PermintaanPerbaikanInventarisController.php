<?php

namespace App\Http\Controllers\Inventaris;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use App\Models\Pegawai;
use App\Models\PermintaanPerbaikanInventaris;
use App\Models\PerbaikanInventaris;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermintaanPerbaikanInventarisController extends Controller
{
    // Menampilkan daftar permintaan
    public function index()
{
    $permintaans = PermintaanPerbaikanInventaris::with(['inventaris', 'pegawai', 'perbaikan'])->get();

    foreach ($permintaans as $permintaan) {
        if ($permintaan->perbaikan && $permintaan->perbaikan->waktu_mulai) {
            $permintaan->response_time = Carbon::parse($permintaan->tanggal)->diffInMinutes(Carbon::parse($permintaan->perbaikan->waktu_mulai));
        }
    }

    return view('inventaris.permintaan_index', compact('permintaans'));
}

    // Menampilkan form untuk membuat permintaan baru
public function create()
{
    $inventaris = Inventaris::all();
    $pegawai = Pegawai::all();
    
    // Filter hanya departemen IT dan IPS
    $departemens = Departemen::whereIn('dep_id', ['IT', 'IPS'])->get();

    $today = Carbon::today();
    $count = PermintaanPerbaikanInventaris::whereDate('tanggal', $today)->count() + 1;
    $no_permintaan = 'PPI' . $today->format('Ymd') . sprintf('%03d', $count);

    return view('inventaris.permintaan_create', compact('inventaris', 'pegawai', 'departemens', 'no_permintaan'));
}
    // Menyimpan permintaan baru
    public function store(Request $request)
    {
        $request->validate([
            'no_inventaris' => 'required|exists:sik3.inventaris,no_inventaris',
            'nik' => 'required|exists:sik3.pegawai,nik',
            'tanggal' => 'required|date_format:Y-m-d\TH:i',
            'deskripsi_kerusakan' => 'required',
            'status' => 'required|in:Pending,In Progress,Completed,Cancelled',
            'prioritas' => 'required|in:Low,Medium,High',
        ]);

        $today = Carbon::today();
        $count = PermintaanPerbaikanInventaris::whereDate('tanggal', $today)->count() + 1;
        $no_permintaan = 'PPI' . $today->format('Ymd') . sprintf('%03d', $count);

        PermintaanPerbaikanInventaris::create([
            'no_permintaan' => $no_permintaan,
            'no_inventaris' => $request->no_inventaris,
            'nik' => $request->nik,
            'tanggal' => $request->tanggal,
            'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
            'status' => $request->status,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->route('permintaan.index')->with('success', 'Permintaan Perbaikan berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit permintaan
    public function edit($no_permintaan)
    {
        $permintaan = PermintaanPerbaikanInventaris::where('no_permintaan', $no_permintaan)->firstOrFail();
        $inventaris = Inventaris::all();
        $pegawai = Pegawai::all();

        return view('inventaris.permintaan_edit', compact('permintaan', 'inventaris', 'pegawai'));
    }

    // Memperbarui permintaan
    public function update(Request $request, $no_permintaan)
    {
        $request->validate([
            'no_inventaris' => 'required|exists:sik3.inventaris,no_inventaris',
            'nik' => 'required|exists:sik3.pegawai,nik',
            'tanggal' => 'required|date',
            'deskripsi_kerusakan' => 'required',
        ]);

        $permintaan = PermintaanPerbaikanInventaris::where('no_permintaan', $no_permintaan)->firstOrFail();
        $permintaan->update($request->all());

        return redirect()->route('permintaan.index')->with('success', 'Permintaan Perbaikan berhasil diperbarui.');
    }

    // Menghapus data permintaan
    public function destroy($id)
    {
        $permintaan = PermintaanPerbaikanInventaris::findOrFail($id);
        $permintaan->delete();

        return redirect()->route('permintaan.index')->with('success', 'Permintaan Perbaikan berhasil dihapus.');
    }

    public function startRepairForm($no_permintaan)
{
    // Ambil data permintaan perbaikan berdasarkan no_permintaan
    $permintaan = PermintaanPerbaikanInventaris::where('no_permintaan', $no_permintaan)->firstOrFail();

    // Load view untuk memulai perbaikan
    return view('inventaris.start_repair', compact('permintaan'));
}
    // Memulai proses perbaikan
    public function startRepair(Request $request, $no_permintaan)
    {
        $permintaan = PermintaanPerbaikanInventaris::where('no_permintaan', $no_permintaan)->firstOrFail();

        // Ubah status permintaan menjadi "In Progress"
        $permintaan->status = 'In Progress';
        $permintaan->save();

        // Simpan data ke tabel perbaikan_inventaris
        PerbaikanInventaris::create([
            'no_permintaan' => $no_permintaan,
            'tanggal' => now(),
            'uraian_kegiatan' => $request->uraian_kegiatan,
            'nip' => $request->nip,
            'pelaksana' => $request->pelaksana,
            'biaya' => $request->biaya,
            'keterangan' => $request->keterangan,
            'status' => 'Bisa Diperbaiki',
            'waktu_mulai' => now(),
            'prioritas' => $permintaan->prioritas,
        ]);

        return redirect()->route('perbaikan.index')->with('success', 'Perbaikan telah dimulai.');
    }

    // Menghitung response time
    public function getResponseTime($no_permintaan)
    {
        $permintaan = PermintaanPerbaikanInventaris::with('perbaikan')->where('no_permintaan', $no_permintaan)->firstOrFail();

        if ($permintaan->perbaikan && $permintaan->perbaikan->waktu_mulai) {
            $responseTime = $permintaan->tanggal->diffInMinutes($permintaan->perbaikan->waktu_mulai);
            return "Response time: {$responseTime} minutes";
        } else {
            return "Perbaikan belum dimulai.";
        }
    }
    
    public function getPegawaiByDepartemen($dep_id)
{
    // Ambil pegawai berdasarkan departemen
    $pegawai = Pegawai::where('departemen', $dep_id)->get();

    // Kembalikan response dalam bentuk JSON
    return response()->json($pegawai);
}

}
