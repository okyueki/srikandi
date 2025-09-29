<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pegawai;
use App\Models\TemporaryPresensi;
use App\Models\RekapPresensi;
use App\Models\JamJaga;
use App\Models\SetKeterlambatan;
use App\Models\Barcode;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index(Request $request)
{
    // Ambil filter dari request
    $jabatan = $request->input('jabatan');
    $departemen = $request->input('departemen');
    $search = $request->input('search');

    // Query dasar
    $query = TemporaryPresensi::with('pegawai');

    // Filter berdasarkan jabatan jika ada
    if ($jabatan) {
        $query->whereHas('pegawai', function($q) use ($jabatan) {
            $q->where('jbtn', $jabatan);
        });
    }

    // Filter berdasarkan departemen jika ada
    if ($departemen) {
        $query->whereHas('pegawai', function($q) use ($departemen) {
            $q->where('departemen', $departemen);
        });
    }

    // Pencarian berdasarkan nama pegawai
    if ($search) {
        $query->whereHas('pegawai', function($q) use ($search) {
            $q->where('nama', 'LIKE', '%' . $search . '%');
        });
    }

    // Dapatkan hasil paginated
    $presensi = $query->paginate(20);

    // Ambil semua jabatan dan departemen untuk filter
    $allJabatan = Pegawai::distinct()->pluck('jbtn');
    $allDepartemen = Pegawai::distinct()->pluck('departemen');

    return view('presensi.index', compact('presensi', 'allJabatan', 'allDepartemen'));
}

    public function datang()
    {
    // Ambil data jam jaga untuk dropdown
    $jam_jaga = JamJaga::all();
    return view('presensi.datang', compact('jam_jaga'));
    }
    
    public function verifikasiPresensi($id)
    {
        $presensi = TemporaryPresensi::findOrFail($id);

        // Hitung durasi kerja
        $jamDatang = new \DateTime($presensi->jam_datang);
        $jamPulang = new \DateTime();
        $durasi = $jamPulang->diff($jamDatang)->format('%H:%I:%S');

        // Simpan data ke tabel rekap_presensi
        RekapPresensi::create([
            'id' => $presensi->id,
            'shift' => $presensi->shift,
            'jam_datang' => $presensi->jam_datang,
            'jam_pulang' => now(),
            'status' => $presensi->status,
            'keterlambatan' => $presensi->keterlambatan,
            'durasi' => $durasi,
            'keterangan' => '-',
            'photo' => $presensi->photo,
        ]);

        // Hapus data dari tabel temporary_presensi
        $presensi->delete();

        return redirect()->route('presensi.index')->with('success', 'Presensi pulang telah diverifikasi dan disimpan.');
    }
    
public function store(Request $request)
{
    // Validasi input form
    $request->validate([
        'jam_masuk' => 'required',
        'barcode' => 'required',
        'image' => 'required',
    ]);

    // Cari pegawai berdasarkan barcode
    $barcode = $request->barcode;
    $pegawai = Barcode::where('barcode', $barcode)->first()->pegawai;

    if (!$pegawai) {
        return back()->withErrors(['error' => 'Pegawai tidak ditemukan!']);
    }

    // Cari shift kerja berdasarkan jam masuk
    $jamJaga = JamJaga::where('jam_masuk', $request->jam_masuk)
        ->where('dep_id', $pegawai->indexinsDepartemen->dep_id)
        ->first();

    if (!$jamJaga) {
        return back()->withErrors(['error' => 'Shift tidak ditemukan!']);
    }

    // Cek apakah pegawai sudah melakukan presensi datang hari ini
    $presensi = TemporaryPresensi::where('id', $pegawai->id)
        ->whereDate('jam_datang', Carbon::today())
        ->first();

    if ($presensi) {
        // Jika sudah ada presensi datang, catat presensi pulang
        $presensi->update([
            'jam_pulang' => now(),
            'status' => 'Selesai',
            'durasi' => now()->diff($presensi->jam_datang)->format('%H:%I:%S'),
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil dicatat.');
    } else {
        // Jika belum ada presensi datang, catat presensi datang

        // Proses gambar dari kamera
        $imageData = $request->image;
        $fileName = now()->format('YmdHis') . $pegawai->id . '.jpeg';
        $filePath = public_path('presensi/' . $fileName);

        list(, $imageData) = explode(';base64,', $imageData);
        $imageData = base64_decode($imageData);
        file_put_contents($filePath, $imageData);

        // Hitung keterlambatan (asumsi sederhana: hitung berdasarkan jam_masuk shift)
        $now = Carbon::now();
        $jamMasukShift = Carbon::parse($jamJaga->jam_masuk);
        $keterlambatan = $now->greaterThan($jamMasukShift) ? $now->diff($jamMasukShift)->format('%H:%I:%S') : '00:00:00';

        // Simpan ke temporary presensi
        TemporaryPresensi::create([
            'id' => $pegawai->id,
            'shift' => $jamJaga->shift,
            'jam_datang' => now(),
            'status' => $keterlambatan === '00:00:00' ? 'Tepat Waktu' : 'Terlambat',
            'keterlambatan' => $keterlambatan,
            'photo' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Presensi datang berhasil dicatat.');
    }
}


public function presensiDatang(Request $request)
{
    // Validasi input form
    $request->validate([
        'jam_masuk' => 'required',
        'barcode' => 'required',
    ]);
    
    // Cari pegawai berdasarkan barcode
    $barcode = $request->barcode;
    $pegawai = Barcode::where('barcode', $barcode)->first();
    
    // Jika barcode tidak cocok atau tidak ditemukan
    if (!$pegawai) {
        return back()->withErrors(['error' => 'Pegawai tidak ditemukan!']);
    }
    
    // Cari shift kerja berdasarkan jam masuk yang dipilih
    $jamJaga = JamJaga::where('jam_masuk', $request->jam_masuk)->first();
    
    // Jika jam shift tidak cocok atau tidak ditemukan
    if (!$jamJaga) {
        return back()->withErrors(['error' => 'Shift tidak ditemukan!']);
    }
    
    // Cek apakah pegawai sudah melakukan presensi datang hari ini
    $presensi = TemporaryPresensi::where('id', $pegawai->id)
        ->whereDate('jam_datang', Carbon::today())
        ->first();

    if ($presensi) {
        // Jika sudah ada, ini berarti pegawai sedang melakukan presensi pulang
        $presensi->update([
            'jam_pulang' => now(),
            'status' => 'Selesai',
            'durasi' => now()->diff($presensi->jam_datang)->format('%H:%I:%S'),
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil dicatat.');
    } else {
        // Jika belum ada, maka catat presensi datang
        TemporaryPresensi::create([
            'id' => $pegawai->id,
            'shift' => $jamJaga->shift,
            'jam_datang' => now(),
            'status' => 'Tepat Waktu',
            'keterlambatan' => '00:00:00', // Set default keterlambatan ke '00:00:00'
            'photo' => $request->photo ?? 'default.jpg', // Set nilai default photo jika null
        ]);

        return redirect()->back()->with('success', 'Presensi datang berhasil dicatat.');
    }
}

}