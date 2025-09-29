<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RanapDokter extends Model
{
    use HasFactory;

    protected $connection = 'server_74';
    protected $table = 'rawat_inap_dr';
    public $timestamps = false;

    public static function getPivotData($startDate, $endDate)
{
    $data = self::query()
        ->from('rawat_inap_dr as r')
        ->join('reg_periksa as rp', 'rp.no_rawat', '=', 'r.no_rawat')
        ->join('pasien as p', 'p.no_rkm_medis', '=', 'rp.no_rkm_medis')
        ->join('dokter as d', 'd.kd_dokter', '=', 'r.kd_dokter')
        ->join('jns_perawatan_inap as jpi', 'jpi.kd_jenis_prw', '=', 'r.kd_jenis_prw')
        ->join('penjab', 'penjab.kd_pj', '=', 'rp.kd_pj') // JOIN cara bayar
        ->select(
            'r.no_rawat',
            'rp.no_rkm_medis',
            'p.nm_pasien',
            'd.nm_dokter',
            'jpi.nm_perawatan',
            'r.biaya_rawat',
            'penjab.png_jawab as cara_bayar', // Ambil nama cara bayar
            \DB::raw("
                IFNULL(
                    (SELECT bangsal.nm_bangsal 
                     FROM kamar_inap 
                     INNER JOIN kamar ON kamar_inap.kd_kamar = kamar.kd_kamar 
                     INNER JOIN bangsal ON kamar.kd_bangsal = bangsal.kd_bangsal 
                     WHERE kamar_inap.no_rawat = r.no_rawat 
                     LIMIT 1), 
                    'Ruang Terhapus'
                ) as ruangan
            ")
        )
        ->whereBetween(\DB::raw("concat(r.tgl_perawatan,' ',r.jam_rawat)"), [$startDate, $endDate])
        ->get();

    if ($data->isEmpty()) {
        return [[], []];
    }

    // Group by no_rawat → satu baris per pasien
    $pivot = $data->groupBy('no_rawat')->map(function ($rows) {
        $first = $rows->first();

        // Ambil cara bayar & ruangan dari baris pertama (karena sama per no_rawat)
        $caraBayar = $first->cara_bayar;
        $ruangan   = $first->ruangan;

        // Group by dokter
        $dokterData = $rows->groupBy('nm_dokter')->map(function ($dr) {
            return [
                'dokter'   => $dr->first()->nm_dokter,
                'tindakan' => $dr->pluck('nm_perawatan')->unique()->implode(', '),
                'biaya'    => $dr->sum('biaya_rawat'),
            ];
        })->values()->toArray();

        // Siapkan slot dokter 1-7
        $slot = [];
        for ($i = 0; $i < 7; $i++) {
            $dokterRow = $dokterData[$i] ?? ['dokter' => null, 'tindakan' => null, 'biaya' => 0];
            $slot["dokter".($i+1)]   = $dokterRow['dokter'];
            $slot["tindakan".($i+1)] = $dokterRow['tindakan'];
            $slot["biaya".($i+1)]    = $dokterRow['biaya'];
        }

        // Gabungkan semua data
        return array_merge([
            'no_rawat'     => $first->no_rawat,
            'no_rkm_medis' => $first->no_rkm_medis,
            'nm_pasien'    => $first->nm_pasien,
            'cara_bayar'   => $caraBayar,   // <-- TAMBAHAN
            'ruangan'      => $ruangan,     // <-- TAMBAHAN
        ], $slot);
    })->values()->toArray();

    return [$data, $pivot];
}

}
