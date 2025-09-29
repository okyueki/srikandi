<?php

namespace App\Http\Controllers;

use App\Models\AbsensiEvent;
use App\Models\Pegawai;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiEventController extends Controller
{
    public function create()
    {
        // Ambil data pegawai dan agenda dari database
        $pegawai = Pegawai::all();
        $agendas = Agenda::all();
    
        // Kirimkan data pegawai dan agenda ke view
        return view('absensi_event.create', compact('pegawai', 'agendas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mulai' => 'required|date',
            'akhir' => 'nullable|date|after_or_equal:mulai',
            'tempat' => 'nullable|string',
            'pimpinan_rapat' => 'nullable|string',
            'notulen' => 'nullable|string',
            'yang_terundang' => 'nullable|array',
            'yang_terundang.*' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'materi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ]);
        
        // Generate nomor_agenda otomatis
        $year = Carbon::now()->year;
        $latestAgenda = Agenda::whereYear('created_at', $year)->latest()->first();
        $nextNumber = $latestAgenda ? (int)substr($latestAgenda->nomor_agenda, -3) + 1 : 1;
        $nomorAgenda = 'AGD-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $validatedData['nomor_agenda'] = $nomorAgenda;
    
        // ✅ Handle "all" dengan BENAR — dan HANYA sekali
        if (is_array($request->yang_terundang) && in_array('all', $request->yang_terundang)) {
            $semuaNik = Pegawai::where('stts_aktif', 'AKTIF')->pluck('nik')->toArray();
            $validatedData['yang_terundang'] = json_encode($semuaNik);
        } else {
            $validatedData['yang_terundang'] = json_encode($request->yang_terundang ?? []);
        }
    
        // Upload file
        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('agenda_fotos', 'public');
        }
        if ($request->hasFile('materi')) {
            $validatedData['materi'] = $request->file('materi')->store('agenda_materis', 'public');
        }
    
        // ✅ JANGAN ASSIGN LAGI DI SINI!
        Agenda::create($validatedData);
    
        return redirect()->route('acara_index')->with('success', 'Agenda berhasil ditambahkan');
    }

    // Fungsi untuk menghitung jarak antara dua titik koordinat
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        // Implementasikan rumus Haversine atau gunakan package geolokasi untuk ini
    }
}