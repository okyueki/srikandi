<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\TemporaryPresensi;
use App\Models\RekapPresensi;
use App\Models\JamJaga;
use App\Models\Barcode;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan formulir presensi
    public function showPresensiForm()
    {
        $jamJaga = JamJaga::all();
        return view('presensi.form', compact('jamJaga'));
    }

public function handlePresensi(Request $request)
{
    $request->validate([
        'jam_masuk' => 'required',
        'barcode' => 'required',
        'image' => 'required',
    ]);

    $barcode = $request->barcode;
    $pegawai = Barcode::where('barcode', $barcode)->first()->pegawai;

    if (!$pegawai) {
        return back()->withErrors(['error' => 'Pegawai tidak ditemukan!']);
    }

    // Cek apakah pegawai sudah melakukan presensi hari ini
    $rekapPresensi = RekapPresensi::where('id', $pegawai->id)
        ->whereDate('jam_datang', Carbon::today())
        ->first();

    if ($rekapPresensi) {
        return back()->withErrors(['error' => 'Anda sudah melakukan presensi hari ini.']);
    }

    // Cek juga di TemporaryPresensi apakah pegawai sudah presensi masuk
    $existingPresensi = TemporaryPresensi::where('id', $pegawai->id)
        ->whereDate('jam_datang', Carbon::today())
        ->first();

    if ($existingPresensi) {
        // Proses presensi pulang
        $jamDatang = Carbon::parse($existingPresensi->jam_datang);
        $jamPulang = Carbon::now();
        $durasi = $jamPulang->diff($jamDatang)->format('%H:%I:%S');

        // Hitung keterlambatan
        $toleransi = 1; // Misal toleransi keterlambatan 10 menit
        $keterlambatan = $jamDatang->diffInMinutes($jamPulang) > $toleransi ? 'Terlambat I' : 'Tepat Waktu';

        $existingPresensi->update([
            'jam_pulang' => $jamPulang,
            'status' => $keterlambatan,  // Gunakan nilai keterlambatan yang valid
            'durasi' => $durasi,
        ]);

        RekapPresensi::create([
            'id' => $pegawai->id,
            'shift' => $existingPresensi->shift,
            'jam_datang' => $existingPresensi->jam_datang,
            'jam_pulang' => $jamPulang,
            'status' => $keterlambatan,  // Simpan status yang sesuai
            'keterlambatan' => $keterlambatan,  // Simpan keterlambatan yang sesuai
            'durasi' => $durasi,
            'photo' => $fileName,
            'keterangan' => '',  // Pastikan kolom keterangan diisi, misal kosong
        ]);

        $existingPresensi->delete();

        return back()->with('success', 'Presensi pulang berhasil dicatat.');
    } else {
        // Proses presensi datang
        TemporaryPresensi::create([
            'id' => $pegawai->id,
            'shift' => $jamJaga->shift,
            'jam_datang' => Carbon::now(),
            'status' => 'Tepat Waktu',
            'keterlambatan' => '00:00:00', // Default value
            'photo' => $fileName,
        ]);

        return back()->with('success', 'Presensi datang berhasil dicatat.');
    }
}

}
