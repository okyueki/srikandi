<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryPresensi;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashboard';
          // Mengambil semua data presensi
        $presensi = TemporaryPresensi::all();
        return view('dashboard.index', compact('title','presensi'));
    }


    public function updateJamPulang($id)
    {
        $today = Carbon::today();

        // Temukan entri dengan ID dan tanggal hari ini
        $temporaryPresensi = TemporaryPresensi::where('id', $id)
            ->whereDate('jam_datang', $today)
            ->first();

        if ($temporaryPresensi) {
            // Perbarui jam pulang
            $temporaryPresensi->jam_pulang = Carbon::now();
            $temporaryPresensi->save();

            $jamDatang = Carbon::parse($temporaryPresensi->jam_datang);
            $jamPulang = Carbon::parse($temporaryPresensi->jam_pulang);
            $durasi = $jamDatang->diffInMinutes($jamPulang);

            // Tentukan status
            $shiftTime = $this->getShiftStartTime($temporaryPresensi->shift);
            $status = $this->getStatus($jamDatang, $jamPulang, $shiftTime);

            // Simpan ke rekap_presensi
            RekapPresensi::updateOrCreate(
                ['id' => $id, 'jam_datang' => $jamDatang],
                [
                    'shift' => $temporaryPresensi->shift,
                    'jam_pulang' => $jamPulang,
                    'status' => $status,
                    'keterlambatan' => 0,
                    'durasi' => $durasi
                ]
            );

            // Hapus entri dari temporary_presensi
            $temporaryPresensi->delete();

            return redirect()->back()->with('success', 'Jam pulang berhasil diperbarui dan rekapan presensi telah diperbarui.');
        }

        return redirect()->back()->with('error', 'Data presensi untuk hari ini tidak ditemukan.');
    }

    private function getShiftStartTime($shift)
    {
        // Implementasi menentukan waktu mulai shift berdasarkan nama shift
        // Contoh: Pagi = 06:00, Siang = 13:00, Malam = 21:00
        $shiftTimes = [
            'Pagi' => '06:00:00',
            'Siang' => '13:00:00',
            'Malam' => '21:00:00'
            // Tambahkan shift lainnya sesuai kebutuhan
        ];

        return Carbon::parse($shiftTimes[$shift] ?? '00:00:00');
    }

    private function getStatus($jamDatang, $jamPulang, $shiftTime)
    {
        // Implementasi penentuan status berdasarkan jam datang dan shift
        $toleransi = 1; // dalam menit

        if ($jamDatang->gt($shiftTime->addMinutes($toleransi))) {
            return 'Terlambat Toleransi';
        }

        return 'Tepat Waktu'; // Status default jika tepat waktu
    }
}
