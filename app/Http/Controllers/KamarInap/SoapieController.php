<?php

namespace App\Http\Controllers\KamarInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemeriksaanRanap;
use App\Models\RegPeriksa;
use App\Models\Dokter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\PemeriksaanRalan;

class SoapieController extends Controller
{
    
    public function show($no_rawat)
    {
        $no_rawat_formatted = substr($no_rawat, 0, 4) . '/' . substr($no_rawat, 4, 2) . '/' . substr($no_rawat, 6, 2) . '/' . substr($no_rawat, 8);
        \Log::info("--- DEBUG RIWAYAT SOAPIE ---");
        \Log::info("Mencari riwayat untuk no_rawat: {$no_rawat_formatted}");
        
        // Mengambil riwayat dari Rawat Inap (ranap) dengan eager loading
        $ranapHistory = PemeriksaanRanap::with(['regPeriksa.pasien', 'pegawai'])
            ->where('no_rawat', $no_rawat_formatted)
            ->get();
        \Log::info("Riwayat Rawat Inap ditemukan: " . $ranapHistory->count());

        $ranapHistory = $ranapHistory->map(function ($item) {
                $item->location = 'Rawat Inap';
                $item->dokter = optional($item->pegawai)->nama ?? 'N/A'; // Akses relasi dengan aman
                return $item;
            });

        // Mengambil riwayat dari Rawat Jalan (ralan) dengan eager loading
        $ralanHistory = PemeriksaanRalan::with(['regPeriksa.pasien', 'pegawai'])
            ->where('no_rawat', $no_rawat_formatted)
            ->get();
        \Log::info("Riwayat Rawat Jalan ditemukan: " . $ralanHistory->count());

        $ralanHistory = $ralanHistory->map(function ($item) {
                $item->location = 'Rawat Jalan';
                $item->dokter = optional($item->pegawai)->nama ?? 'N/A'; // Akses relasi dengan aman
                return $item;
            });

        // Menggabungkan dan mengurutkan riwayat
        $soapie = $ranapHistory->concat($ralanHistory)->sortByDesc(function ($item) {
            return $item->tgl_perawatan . ' ' . $item->jam_rawat;
        });
        \Log::info("Total riwayat gabungan setelah diurutkan: " . $soapie->count());
        \Log::info("--- SELESAI DEBUG ---");

        $caripasien = RegPeriksa::with('pasien')->where('no_rawat', $no_rawat_formatted)->first();
        $dokter = Dokter::where('status','1')->get();
        return view('kamar_inap.soapie', compact('soapie','no_rawat_formatted','caripasien','dokter'));
    }
    public function store(Request $request)
    {
        try {
            $nik = Auth::user()->username;
            $validatedData = $request->validate([
                'no_rawat'      => 'required|string|max:17',
                'suhu_tubuh'    => 'nullable|string|max:5',
                'tensi'         => 'nullable|string|max:8',
                'nadi'          => 'nullable|string|max:3',
                'respirasi'     => 'nullable|string|max:3',
                'tinggi'        => 'nullable|string|max:5',
                'berat'         => 'nullable|string|max:5',
                'spo2'          => 'nullable|string|max:3',
                'gcs'           => 'nullable|string|max:10',
                'kesadaran'     => 'nullable|in:Compos Mentis,Somnolence,Sopor,Coma,Alert,Confusion,Voice,Pain,Unresponsive,Apatis,Delirium',
                'keluhan'       => 'nullable|string|max:2000',
                'pemeriksaan'   => 'nullable|string|max:2000',
                'alergi'        => 'nullable|string|max:50',
                'penilaian'     => 'nullable|string|max:2000',
                'rtl'           => 'nullable|string|max:2000',
                'instruksi'     => 'nullable|string|max:2000',
                'evaluasi'      => 'nullable|string|max:2000',
            ]);

            $now = Carbon::now();
            $tgl_perawatan = $now->format('Y-m-d');
            $jam_rawat = $now->format('H:i:s');

            // Pastikan field yang tidak boleh NULL diisi string kosong jika null
            $validatedData['tensi']      = $validatedData['tensi'] ?? '';
            $validatedData['spo2']       = $validatedData['spo2'] ?? '';
            $validatedData['kesadaran']  = $validatedData['kesadaran'] ?? '';
            $validatedData['penilaian']  = $validatedData['penilaian'] ?? '';
            $validatedData['rtl']        = $validatedData['rtl'] ?? '';
            $validatedData['instruksi']  = $validatedData['instruksi'] ?? '';
            $validatedData['evaluasi']   = $validatedData['evaluasi'] ?? '';

            $validatedData['tgl_perawatan'] = $tgl_perawatan;
            $validatedData['jam_rawat']     = $jam_rawat;
            $validatedData['nip']           = $nik;

            \Log::info('SOAPIE Save Attempt:', $validatedData);

            $pemeriksaan = PemeriksaanRanap::create($validatedData);

            if ($pemeriksaan) {
                \Log::info('SOAPIE Save Success for no_rawat: ' . $validatedData['no_rawat']);
                $no_rawat = $validatedData['no_rawat'];
                $no_rawat_formatted = substr($no_rawat, 0, 4) . substr($no_rawat, 5, 2) . substr($no_rawat, 8, 2) . substr($no_rawat, 11, 6);

                return redirect()->route('soapie.show', $no_rawat_formatted)
                    ->with('success', 'Data pemeriksaan SOAPIE berhasil disimpan!');
            } else {
                throw new \Exception('Gagal menyimpan data pemeriksaan');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('SOAPIE Validation Error:', $e->errors());
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali data yang dimasukkan.');
        } catch (\Exception $e) {
            \Log::error('SOAPIE Save Error: ' . $e->getMessage());
            \Log::error('SOAPIE Save Error Trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data pemeriksaan: ' . $e->getMessage());
        }
    }
}
