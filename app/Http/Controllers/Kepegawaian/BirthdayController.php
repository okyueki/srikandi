<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;

class BirthdayController extends Controller
{
    public function index()
    {
        // Mengambil data pegawai dengan status aktif saja dan memilih data yang dibutuhkan
        $pegawai = Pegawai::where('stts_aktif', 'aktif')
                          ->select('nik', 'nama', 'jk', 'jbtn', 'tgl_lahir')
                          ->get();

        // Format data untuk FullCalendar (Ulang Tahun Pegawai)
        $events = $pegawai->map(function ($item) {
            return [
                'title' => $item->nama,
                'start' => date('Y') . '-' . date('m-d', strtotime($item->tgl_lahir)),
                'allDay' => true,
                'backgroundColor' => '#28a745', // Hijau untuk ulang tahun
                'borderColor' => '#28a745',
                'extendedProps' => [
                    'nik' => $item->nik,
                    'jk' => $item->jk,
                    'jbtn' => $item->jbtn,
                ],
            ];
        })->toArray();

        // Tambahkan hari libur nasional (contoh hardcoded)
        $holidays = [
            [
                'title' => 'Tahun Baru',
                'start' => date('Y') . '-01-01',
                'allDay' => true,
                'backgroundColor' => '#ff6666', // Merah untuk hari libur
                'borderColor' => '#ff6666',
            ],
            [
                'title' => 'Hari Raya Nyepi',
                'start' => date('Y') . '-03-22',
                'allDay' => true,
                'backgroundColor' => '#ff6666',
                'borderColor' => '#ff6666',
            ],
            [
                'title' => 'Hari Kemerdekaan',
                'start' => date('Y') . '-08-17',
                'allDay' => true,
                'backgroundColor' => '#ff6666',
                'borderColor' => '#ff6666',
            ],
            // Tambahkan lebih banyak hari libur jika diperlukan
        ];

        // Menggabungkan data ulang tahun pegawai dengan hari libur
        $events = array_merge($events, $holidays);

        // Definisikan $title untuk halaman ini
        $title = 'Kalender Ulang Tahun Pegawai Aktif';

        return view('presensi.birthday', [
            'events' => $events,
            'title' => $title
        ]);
    }
}
