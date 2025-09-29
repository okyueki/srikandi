<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\KamarInap;
use App\Models\Dokter;
use App\Models\AsuhanPascaRanap;
use App\Models\Tindakan;
use App\Models\Obat;

class DischargeNoteController extends Controller
{
    public function formatNoRawat($no_rawat)
    {
        $year = substr($no_rawat, 0, 4);
        $month = substr($no_rawat, 4, 2);
        $day = substr($no_rawat, 6, 2);
        $id = substr($no_rawat, 8);

        $formatted_no_rawat = $year . '/' . $month . '/' . $day . '/' . $id;

        return $formatted_no_rawat;
    }
    
    public function index(Request $request, $no_rawat)
    {
        $formatted_no_rawat = $this->formatNoRawat($no_rawat);
        $title = "Discharge Note";
        $pageTitle = "Form ";
        
        $kamarInap = KamarInap::where('no_rawat', $formatted_no_rawat)->with(['regPeriksa.pasien'])->first();
        $dokter = Dokter::where('status','1')->get();
        $tindakan = Tindakan::where('no_rawat', $formatted_no_rawat)->get();
        $obat = Obat::where('no_rawat', $formatted_no_rawat)->get();
        $asuhan = AsuhanPascaRanap::where('no_rawat', $formatted_no_rawat)->with(['regPeriksa.pasien', 'pegawai'])->first();
        
        return view('pages.discharge-note', [
            'no_rawat' => $no_rawat,
            'kamarinap' => $kamarInap,
            'dokter' => $dokter,
            'obat' => $obat,
            'tindakan' => $tindakan, // tambahkan ini
            'title' => $title,
            'asuhan' => $asuhan,
            'pageTitle' => $pageTitle
        ]);
    }
    
    public function store(Request $request)
{
    $nik = Auth::user()->username;

    $validated = $request->validate([
        'no_rawat' => 'required|string',
        'tgl_masuk' => 'nullable|date',
        'tgl_keluar' => 'nullable|date',
        'kondisi_pulang' => 'nullable|string',
        'kd_dokter' => 'nullable|string',
        'diagnosa_awal' => 'nullable|string',
        'diagnosa_akhir' => 'nullable|string',
        'total_waktu_tidur' => 'nullable|string',
        'kualitas_tidur' => 'nullable|in:Nyenyak,Kurang nyeyak,Tidak nyenyak',
        'kalori_makan' => 'nullable|string',
        'waktu_luang' => 'nullable|in:Tidak Ada,Sangat Sedikit,Cukup',
        'catatan_khusus' => 'nullable|string',
        'nutrisi_makan' => 'nullable|string',
        'nutrisi_minum' => 'nullable|string',
        'duduk' => 'nullable|in:Mandiri,Sebagian,Total',
        'berdiri' => 'nullable|in:Mandiri,Sebagian,Total',
        'bergerak' => 'nullable|in:Mandiri,Sebagian,Total',
        'bak' => 'nullable|string',
        'bab' => 'nullable|string',
        'deskripsi_perawatan' => 'nullable|string',
        'bayi_menyusui' => 'nullable|in:Sangat baik,Cukup baik,Kesulitan menetek,Rewel,Malas',
        'bab_bayi' => 'nullable|in:Sangat sering,Sering,Jarang,Tidak,Lainnya',
        'bak_bayi' => 'nullable|in:Sangat sering,Sering,Jarang,Tidak,Lainnya',
        'kesehatan_umum' => 'nullable|in:Baik,Sedang,Buruk',
        'tensi' => 'nullable|string',
        'rr' => 'nullable|string',
        'spo2' => 'nullable|string',
        'temp' => 'nullable|string',
        'anak_kondsi' => 'nullable|in:Baik,Sedang,Buruk',
        'bayi_kondisi' => 'nullable|in:Baik,Sedang,Buruk',
        'tinggi_fundus_uteri' => 'nullable|string',
        'kontraksi_rahim' => 'nullable|string',
        'pengeluaran_pravagina' => 'nullable|string',
        'lochea' => 'nullable|string',
        'luka_perineum' => 'nullable|in:Bersih,Kotor,Bengkak,Berdarah,Terbuka',
        'catatan_tambahan' => 'nullable|string',
    ]);

    // Encode input bertipe array (checkbox/multiple)
    $validated['aktifitas_luang'] = $request->aktifitas_luang ? json_encode($request->aktifitas_luang) : null;
    $validated['luka_operasi'] = $request->luka_operasi ? json_encode($request->luka_operasi) : null;
    $validated['keluarga'] = $request->keluarga ? json_encode($request->keluarga) : null;
    $validated['batuan_dibutuhkan'] = $request->batuan_dibutuhkan ? json_encode($request->batuan_dibutuhkan) : null;
    $validated['tali_pusat_bayi'] = $request->tali_pusat_bayi ? json_encode($request->tali_pusat_bayi) : null;
    $validated['luka_opera_bersalin'] = $request->luka_opera_bersalin ? json_encode($request->luka_opera_bersalin) : null;

    // Tambahkan nik dari user login
    $validated['nik'] = $nik;
    
    // Simpan ke database
      // Cek apakah no_rawat sudah ada
    $asuhan = AsuhanPascaRanap::where('no_rawat', $validated['no_rawat'])->first();

    if ($asuhan) {
        $asuhan->update($validated);
        $message = 'Data asuhan pasca rawat inap berhasil diperbarui.';
    } else {
        AsuhanPascaRanap::create($validated);
        $message = 'Data asuhan pasca rawat inap berhasil disimpan.';
    }

    //dd($validated);
    return redirect()->back()->with('success', 'Data asuhan pasca rawat inap berhasil disimpan.');
}

public function edit($no_rawat)
{
    $formatted_no_rawat = $this->formatNoRawat($no_rawat);
    $title = "Discharge Note";
    
    $kamarInap = KamarInap::where('no_rawat', $formatted_no_rawat)
        ->with(['regPeriksa.pasien'])
        ->first();

    $asuhan = AsuhanPascaRanap::where('no_rawat', $formatted_no_rawat)
        ->with(['regPeriksa.pasien', 'pegawai'])
        ->first();

    $dokter = Dokter::where('status','1')->get();
    $tindakan = Tindakan::where('no_rawat', $formatted_no_rawat)->get();
    $obat = Obat::where('no_rawat', $formatted_no_rawat)->get();

    // Decode data checkbox (array JSON) supaya bisa digunakan untuk checked
    $aktifitas_luang = $asuhan && $asuhan->aktifitas_luang ? json_decode($asuhan->aktifitas_luang, true) : [];
    $luka_operasi = $asuhan && $asuhan->luka_operasi ? json_decode($asuhan->luka_operasi, true) : [];
    $keluarga = $asuhan && $asuhan->keluarga ? json_decode($asuhan->keluarga, true) : [];
    $bantuan_dibutuhkan = $asuhan && $asuhan->batuan_dibutuhkan ? json_decode($asuhan->batuan_dibutuhkan, true) : [];
    $tali_pusat_bayi = $asuhan && $asuhan->tali_pusat_bayi ? json_decode($asuhan->tali_pusat_bayi, true) : [];
    $luka_opera_bersalin = $asuhan && $asuhan->luka_opera_bersalin ? json_decode($asuhan->luka_opera_bersalin, true) : [];

    return view('pages.discharge-note', [
        'no_rawat' => $no_rawat,
        'kamarinap' => $kamarInap,
        'dokter' => $dokter,
        'obat' => $obat,
        'tindakan' => $tindakan,
        'title' => $title,
        'asuhan' => $asuhan,
        'aktifitas_luang' => $aktifitas_luang,
        'luka_operasi' => $luka_operasi,
        'keluarga' => $keluarga,
        'bantuan_dibutuhkan' => $bantuan_dibutuhkan,
        'tali_pusat_bayi' => $tali_pusat_bayi,
        'luka_opera_bersalin' => $luka_opera_bersalin,
    ]);
}

public function destroy($no_rawat)
{
    $formatted_no_rawat = $this->formatNoRawat($no_rawat);
    $asuhan = AsuhanPascaRanap::where('no_rawat', $formatted_no_rawat)->firstOrFail();
    $asuhan->delete();
    
    $tindakan = Tindakan::where('no_rawat', $formatted_no_rawat)->firstOrFail();
    $tindakan->delete();
    
    $obat = Obat::where('no_rawat', $formatted_no_rawat)->firstOrFail();
    $obat->delete();

    return redirect()->back()->with('success', 'Data asuhan pasca rawat inap berhasil dihapus.');
}
public function show($id)
    {
        
        $asuhan = AsuhanPascaRanap::with([
            'regPeriksa.pasien',
            'dokter',
            'obat' => function ($q) {
                $q->orderBy('id_obat');
            },
            'tindakan'
        ])->findOrFail($id);
        $kamarinap = KamarInap::where('stts_pulang', '-')->where('no_rawat', $asuhan->no_rawat)->with(['kamar.bangsal'])->first();
        return view('pages.dischargenote-show', compact('asuhan','kamarinap'));
    }  
}