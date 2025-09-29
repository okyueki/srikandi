<?php

namespace App\Http\Controllers\KamarInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemeriksaanRanap;
use App\Models\PemeriksaanRalan;
use App\Models\DetailPemberianObat;
use App\Models\DetailPeriksaLab;
use App\Models\JnsPerawatanLab;
use App\Models\TemplateLaboratorium;
use App\Models\HasilRadiologi;
use App\Models\RawatInapDr;
use App\Models\RawatInapPr;
use App\Models\DiagnosaPasien;
use App\Models\AturanPakai;
use App\Models\PeriksaRadiologi;
use App\Models\ProsedurPasien;
use App\Models\RegPeriksa; // Tambahkan ini
use App\Models\Pasien; // Tambahkan ini


class PemeriksaanRanapController extends Controller
{
    public function show($no_rawat)
    {
        $no_rawat_formatted = substr($no_rawat, 0, 4) . '/' . substr($no_rawat, 4, 2) . '/' . substr($no_rawat, 6, 2) . '/' . substr($no_rawat, 8);
        
        // Dapatkan data registrasi
        $regPeriksa = RegPeriksa::where('no_rawat', $no_rawat_formatted)->first();
        
        // Dapatkan data pasien menggunakan no_rkm_medis
        $pasien = $regPeriksa ? Pasien::where('no_rkm_medis', $regPeriksa->no_rkm_medis)->first() : null;
        
        
        return view('kamar_inap.riwayatpasien', [
            'no_rawat' => $no_rawat_formatted,
            'data' => PemeriksaanRanap::where('no_rawat', $no_rawat_formatted)->get(),
            'soapralan' => PemeriksaanRalan::where('no_rawat', $no_rawat_formatted)->get(),
            'obat' => DetailPemberianObat::with('barang')->where('no_rawat', $no_rawat_formatted)->orderBy('tgl_perawatan', 'desc')->get(),
            'aturanPakai' => AturanPakai::where('no_rawat', $no_rawat_formatted)->get(),
            'pemeriksaan_lab' => DetailPeriksaLab::where('no_rawat', $no_rawat_formatted)->get(),
            'nama_perawatan' => JnsPerawatanLab::pluck('nm_perawatan', 'kd_jenis_prw'),
            'pemeriksaan_template' => TemplateLaboratorium::pluck('Pemeriksaan', 'id_template'),
            'hasilRadiologi' => HasilRadiologi::where('no_rawat', $no_rawat_formatted)->get(),
            'periksaRadiologi' => Periksaradiologi::where('no_rawat', $no_rawat_formatted)->with('jnsPerawatanRadiologi','petugas')->get(),
            'tindakan' => RawatInapDr::with('jenisPerawatan', 'dokter')->where('no_rawat', $no_rawat_formatted)->orderBy('tgl_perawatan', 'desc')->get(),
            'tindakanpr' => RawatInapPr::with('jenisPerawatan', 'petugas')->where('no_rawat', $no_rawat_formatted)->orderBy('tgl_perawatan', 'desc')->get(),
            'diagnosa' => DiagnosaPasien::with('penyakit')->where('no_rawat', $no_rawat_formatted)->get(),
            'prosedurPasien' => ProsedurPasien::with('icd9')->where('no_rawat', $no_rawat_formatted)->get(),
            'pasien' => $pasien, // Kirim data pasien ke view
            'regPeriksa' => $regPeriksa // Kirim data registrasi ke view
        ]);
    }
}

