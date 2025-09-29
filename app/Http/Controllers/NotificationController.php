<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VerifikasiSurat;
use App\Models\DisposisiSurat;
use App\Models\PengajuanLibur;

class NotificationController extends Controller
{
    public function getNotifications()
{
    $nik = Auth::user()->username;

    // Verifikasi Surat
    $verifikasiSurat = VerifikasiSurat::with('surat.pegawai')
        ->where('nik_verifikator', $nik)
        ->latest()
        ->take(5)
        ->get();

    // Disposisi Surat
    $disposisiSurat = DisposisiSurat::with('surat.pegawai')
        ->where('nik_penerima', $nik)
        ->latest()
        ->take(5)
        ->get();

    // Pengajuan Libur yang menunggu persetujuan atasan langsung
    $pengajuanLibur = PengajuanLibur::with('pegawai')
        ->where('nik_atasan_langsung', $nik)
        ->where('status', '!=', 'Disetujui')
        ->latest()
        ->take(5)
        ->get();

    // Gabung semua notifikasi ke dalam satu collection
    $notifications = collect()
        ->merge($verifikasiSurat)
        ->merge($disposisiSurat)
        ->merge($pengajuanLibur)
        ->sortByDesc(function ($item) {
            return $item->created_at ?? $item->tanggal_dibuat ?? now();
        })
        ->take(5);

    // Hitung unread
    $unreadCount =
        $verifikasiSurat->where('status_surat', '!=', 'Disetujui')->count() +
        $disposisiSurat->where('status_disposisi', '=', 'Dikirim')->count() +
        $pengajuanLibur->where('status', '!=', 'Disetujui')->count();

    return response()->json([
        'html' => view('layouts.notification-items', compact('notifications'))->render(),
        'count' => $unreadCount
    ]);
}
}
