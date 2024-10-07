<?php

namespace App\Http\Controllers\Inventaris;
use App\Http\Controllers\Controller; // Import Controller utama
use App\Models\PerbaikanInventaris;
use App\Models\PermintaanPerbaikanInventaris;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PerbaikanInventarisController extends Controller
{
    // Method index - Menampilkan daftar perbaikan
    public function index()
    {
        $perbaikans = PerbaikanInventaris::with(['permintaanPerbaikan', 'petugas'])->paginate(10);
        return view('inventaris.perbaikan_index', compact('perbaikans'));
    }

public function create($no_permintaan = null)
{
    // Jika no_permintaan disertakan, cari permintaan perbaikan terkait
    $permintaan = null;
    if ($no_permintaan) {
        $permintaan = PermintaanPerbaikanInventaris::where('no_permintaan', $no_permintaan)->first();
    }

    $petugas = Petugas::all();  // Ambil semua petugas

    // Kirim data permintaan dan petugas ke view
    return view('inventaris.perbaikan_create', compact('permintaan', 'petugas'));
}


public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'no_permintaan' => 'required|exists:sik3.permintaan_perbaikan_inventaris,no_permintaan',
        'tanggal' => 'required|date',
        'uraian_kegiatan' => 'required|string|max:255',
        'nip' => 'required|exists:sik3.petugas,nip',
        'pelaksana' => 'required|in:Teknisi Rumah Sakit,Teknisi Rujukan,Pihak ke III',
        'biaya' => 'nullable|numeric',
        'keterangan' => 'nullable|string|max:255',
        'status' => 'required|in:Bisa Diperbaiki,Tidak Bisa Diperbaiki', // Status validasi
        'waktu_mulai' => 'required|date', // Validasi waktu mulai
        'waktu_selesai' => 'nullable|date', // Validasi waktu selesai (opsional)
        'prioritas' => 'required|in:rendah,sedang,tinggi,kritis',
    ]);

    // Simpan data perbaikan
    PerbaikanInventaris::create($request->all());

    // Redirect ke halaman index setelah berhasil menyimpan
    return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil ditambahkan.');
}

public function edit($no_permintaan)
{
    $perbaikan = PerbaikanInventaris::findOrFail($no_permintaan);
    $permintaan = PermintaanPerbaikanInventaris::all();
    $petugas = Petugas::all();
    return view('inventaris.perbaikan_edit', compact('perbaikan', 'permintaan', 'petugas'));
}

public function update(Request $request, $no_permintaan)
{
    $request->validate([
        'no_permintaan' => 'required|exists:sik3.permintaan_perbaikan_inventaris,no_permintaan',
        'tanggal' => 'required|date',
        'uraian_kegiatan' => 'required|string|max:255',
        'nip' => 'required|exists:sik3.petugas,nip',
        'pelaksana' => 'required|in:Teknisi Rumah Sakit,Teknisi Rujukan,Pihak ke III',
        'biaya' => 'nullable|numeric',
        'keterangan' => 'nullable|string|max:255',
        'status' => 'required|in:Bisa Diperbaiki,Tidak Bisa Diperbaiki',
        'waktu_mulai' => 'required|date',
        'waktu_selesai' => 'nullable|date',
        'prioritas' => 'required|in:rendah,sedang,tinggi,kritis',
    ]);

    $perbaikan = PerbaikanInventaris::findOrFail($no_permintaan);  
    $perbaikan->update($request->all());

    return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil diperbarui.');
}


public function destroy($no_permintaan)
{
    $perbaikan = PerbaikanInventaris::findOrFail($no_permintaan);  // Cari berdasarkan 'no_permintaan'
    $perbaikan->delete();

    return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil dihapus.');
}

}
