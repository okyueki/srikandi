<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\JadwalPegawai;
use App\Models\Pegawai;
use App\Models\JamMasuk;
use App\Models\Departemen;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
{
    $perPage = 10;  // Jumlah data per halaman
    $phrase = $request->query('s', '');  // Kata kunci pencarian (nama pegawai)
    $bulan = $request->query('b', date('m'));  // Bulan, default bulan saat ini
    $tahun = $request->query('y', date('Y'));  // Tahun, default tahun saat ini
    $departemen = $request->query('d', '');  // Filter departemen

    // Query dasar untuk mengambil jadwal pegawai dengan filter tahun dan bulan
    $query = JadwalPegawai::with('pegawai')
        ->where('tahun', $tahun)
        ->where('bulan', $bulan);

    // Jika ada kata kunci pencarian, tambahkan filter pencarian berdasarkan nama pegawai
    if (!empty($phrase)) {
        $query->whereHas('pegawai', function ($q) use ($phrase) {
            $q->where('nama', 'like', '%' . $phrase . '%');
        });
    }

    // Jika ada filter departemen, tambahkan filter berdasarkan departemen
    if (!empty($departemen)) {
        $query->whereHas('pegawai', function ($q) use ($departemen) {
            $q->where('departemen', $departemen);
        });
    }

    // Lakukan paginasi hasil query
    $jadwalPegawai = $query->paginate($perPage);

    // Ambil daftar departemen untuk dropdown
    $departemenList = Departemen::pluck('nama', 'dep_id');

    // Mengirimkan data ke view
    return view('presensi.jadwal_pegawai', compact('jadwalPegawai', 'bulan', 'tahun', 'phrase', 'departemen', 'departemenList'));
}

    public function edit($id, $bulan, $tahun)
{
    // Ambil jadwal pegawai berdasarkan id, bulan, dan tahun
    $jadwalPegawai = JadwalPegawai::where('id', $id)
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->firstOrFail(); // Jika tidak ditemukan, munculkan 404

    // Ambil semua shift dari tabel jam_masuk
    $shifts = JamMasuk::all(); 

    // Kirim data ke view
    return view('presensi.edit_jadwal', compact('jadwalPegawai', 'bulan', 'tahun', 'shifts'));
}
    
    public function update(Request $request, $id, $bulan, $tahun)
    {
        // Validasi input
        $validated = $request->validate([
            'h1' => 'nullable|string',
            'h2' => 'nullable|string',
            'h3' => 'nullable|string',
            'h4' => 'nullable|string',
            'h5' => 'nullable|string',
            'h6' => 'nullable|string',
            'h7' => 'nullable|string',
            'h8' => 'nullable|string',
            'h9' => 'nullable|string',
            'h10' => 'nullable|string',
            'h11' => 'nullable|string',
            'h12' => 'nullable|string',
            'h13' => 'nullable|string',
            'h14' => 'nullable|string',
            'h15' => 'nullable|string',
            'h16' => 'nullable|string',
            'h17' => 'nullable|string',
            'h18' => 'nullable|string',
            'h19' => 'nullable|string',
            'h20' => 'nullable|string',
            'h21' => 'nullable|string',
            'h22' => 'nullable|string',
            'h23' => 'nullable|string',
            'h24' => 'nullable|string',
            'h25' => 'nullable|string',
            'h26' => 'nullable|string',
            'h27' => 'nullable|string',
            'h28' => 'nullable|string',
            'h29' => 'nullable|string',
            'h30' => 'nullable|string',
            'h31' => 'nullable|string',
            
        ]);
    
        // Ambil jadwal pegawai
        $jadwalPegawai = JadwalPegawai::where('id', $id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->firstOrFail();
    
        // Loop untuk memastikan tidak ada null di kolom h1 sampai h31
        for ($i = 1; $i <= 31; $i++) {
            $field = 'h' . $i;
            // Jika field tidak ada di request atau null, berikan string kosong sebagai default
            $jadwalPegawai->$field = $request->$field ?? '';
        }
    
        // Simpan perubahan ke database
        $jadwalPegawai->save();
    
        return redirect()->route('jadwal.index', ['b' => $bulan, 'y' => $tahun])
            ->with('success', 'Jadwal berhasil diperbarui');
    }

}