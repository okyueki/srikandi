<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLibur;
use Illuminate\Http\Request;

class FullCalendarController extends Controller
{
    public function index()
    {
        $pengajuanLibur = PengajuanLibur::select('jenis_pengajuan_libur', 'tanggal_awal', 'tanggal_akhir', 'keterangan')
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->jenis_pengajuan_libur,
                    'start' => $item->tanggal_awal,
                    'end' => $item->tanggal_akhir,
                    'description' => $item->keterangan,
                    'color' => 'blue'
                ];
            });

        // Pastikan data JSON dikirim ke view sebagai array
        return view('kalender.index', [
            'events' => $pengajuanLibur, // Mengirimkan array langsung, bukan JSON string
            'pageTitle' => 'Kalender Pengajuan Libur',
            'title' => 'Kalender Pengajuan'
        ]);
    }
}

