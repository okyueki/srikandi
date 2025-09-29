<?php

namespace App\Http\Controllers\KamarInap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KamarInap;
use App\Models\Kamar;
use Carbon\Carbon;

class KamarInapController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = Carbon::today();
        $search = $request->input('search');
        $filter = $request->input('filter');

        $query = KamarInap::query()->with([
            'kamar.bangsal', 'regPeriksa.penjab', 'regPeriksa.dokter',
            'detailPemberianObat', 'biayaSekali', 'biayaHarian',
            'rawatInapDrPr', 'rawatInapPr', 'rawatInapDr',
            'periksaLab', 'periksaRadiologi'
        ]);

        // Apply filter - default to 'belum' if no filter specified
        if ($filter === 'belum' || !$filter) {
            $query->where('stts_pulang', '-');
        } elseif ($filter === 'masuk') {
            $query->whereBetween('tgl_masuk', [
                $request->input('tgl_masuk_awal'),
                $request->input('tgl_masuk_akhir')
            ]);
        } elseif ($filter === 'pulang') {
            $query->whereBetween('tgl_keluar', [
                $request->input('tgl_keluar_awal'),
                $request->input('tgl_keluar_akhir')
            ]);
        }

        // Search
        if ($search) {
            $query->whereHas('regPeriksa.pasien', function ($q) use ($search) {
                $q->where('nm_pasien', 'like', "%{$search}%")
                  ->orWhere('no_rkm_medis', 'like', "%{$search}%")
                  ->orWhere('no_rawat', 'like', "%{$search}%");
            });
        }

        $dataKamarInap = $query->orderBy('tgl_masuk', 'desc')
            ->paginate(10)
            ->appends($request->all());

        // Hitung jumlah kamar aktif dan terisi (opsional, bisa dihapus jika tidak digunakan)
        $jumlahKamarAktif = Kamar::where('statusdata', 2)->count();
        $jumlahKamarTerisi = KamarInap::whereDate('tgl_masuk', $tanggal)->where('stts_pulang', '-')->count();

        // Transformasi data total biaya
        foreach ($dataKamarInap as $kamar) {
            $kamar->total_obat = $kamar->detailPemberianObat->sum('total');

            $biayaKamar = $kamar->trf_kamar * $kamar->lama;
            $biayaHarian = $kamar->biayaHarian->sum(function ($b) use ($kamar) {
                return $b->besar_biaya * $kamar->lama;
            });
            $biayaSekali = $kamar->biayaSekali->sum('besar_biaya');
            $kamar->total_biaya_kamar = $biayaKamar + $biayaHarian + $biayaSekali;

            $biayaTindakan = $kamar->rawatInapDrPr->sum('biaya_rawat') +
                             $kamar->rawatInapDr->sum('biaya_rawat') +
                             $kamar->rawatInapPr->sum('biaya_rawat');
            $kamar->total_biaya_tindakan = $biayaTindakan;

            $kamar->total_biaya_lab = $kamar->periksaLab->sum('biaya');
            $kamar->total_biaya_radiologi = $kamar->periksaRadiologi->sum('biaya');

            $kamar->total_keseluruhan = $kamar->total_obat + $kamar->total_biaya_kamar +
                $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi;

            // Cek plafon
            $kelas = $kamar->kelas;
            $diagnosa = $kamar->diagnosa_awal;
            $plafonInacbg = $kamar->plafonInacbg()->where('kelas', $kelas)->where('kd_penyakit', $diagnosa)->first();
            $kamar->exceedPlafon = $plafonInacbg && $kamar->total_keseluruhan > $plafonInacbg->tarif_plafon;
        }

        return view('kamar_inap.index', compact('dataKamarInap', 'search', 'filter'));
    }
}
