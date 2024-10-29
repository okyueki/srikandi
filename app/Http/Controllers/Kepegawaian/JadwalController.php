<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\JadwalPegawai;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;  // Jumlah data per halaman
        $phrase = $request->query('s', '');  // Kata kunci pencarian (nama pegawai)
        $bulan = $request->query('b', date('m'));  // Bulan, default bulan saat ini
        $tahun = $request->query('y', date('Y'));  // Tahun, default tahun saat ini

        // Karena kita menganggap semua user sebagai admin, kita ambil semua data berdasarkan bulan, tahun, dan nama pegawai
        $query = JadwalPegawai::with('pegawai')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereHas('pegawai', function ($q) use ($phrase) {
                // Filter nama pegawai berdasarkan kata kunci pencarian
                $q->where('nama', 'like', '%' . $phrase . '%');
            });

        // Paginate hasil query
        $jadwalPegawai = $query->paginate($perPage);

        // Mengirim data ke view
        return view('presensi.jadwal_pegawai', compact('jadwalPegawai', 'bulan', 'tahun', 'phrase'));
    }
    public function edit($id, $bulan, $tahun)
    {
        // Ambil jadwal pegawai berdasarkan id, bulan, dan tahun
        $jadwalPegawai = JadwalPegawai::where('id', $id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->firstOrFail(); // Jika tidak ditemukan, munculkan 404
    
        // Kirim data ke view
        return view('presensi.edit_jadwal', compact('jadwalPegawai', 'bulan', 'tahun'));
    }
    
    public function update(Request $request, $id, $bulan, $tahun)
    {
        // Validasi data yang masuk
        $request->validate([
            'h1' => 'nullable|string',
            'h2' => 'nullable|string',
            // Tambahkan validasi untuk setiap hari sesuai kebutuhan (h3, h4, ..., h31)
        ]);
    
        // Ambil jadwal pegawai berdasarkan id, bulan, dan tahun
        $jadwalPegawai = JadwalPegawai::where('id', $id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->firstOrFail(); // Jika tidak ditemukan, munculkan 404
    
        // Update data berdasarkan input form
        $jadwalPegawai->update($request->all());
    
        // Redirect ke halaman jadwal dengan pesan sukses
        return redirect()->route('jadwal.index', ['b' => $bulan, 'y' => $tahun])
            ->with('success', 'Jadwal berhasil diperbarui');
    }

}