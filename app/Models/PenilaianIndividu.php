<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIndividu extends Model
{
    use HasFactory;

    protected $table = 'penilaian_individu';

    protected $fillable = [
        'tanggal',
        'penilaian_bulan',
        'nik_atasan',
        'nama_atasan',
        'nik_bawahan',
        'nama_bawahan',
        'departemen',
        'kepatuhan',
        'kepatuhan_persentase',
        'keaktifan',
        'keaktifan_persentase',
        'budaya_kerja',
        'budaya_kerja_persentase',
        'kajian',
        'kajian_persentase',
        'kegiatan_rs',
        'kegiatan_rs_persentase',
        'iht',
        'iht_persentase',
        'total_nilai',
        'total_persentase',
    ];

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'nik_atasan', 'nik');
    }

    public function bawahan()
    {
        return $this->belongsTo(Pegawai::class, 'nik_bawahan', 'nik');
    }
}