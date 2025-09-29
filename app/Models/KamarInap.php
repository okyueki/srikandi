<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarInap extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'kamar_inap';

    protected $fillable = [
        'no_rawat',
        'kd_kamar',
        'trf_kamar',
        'diagnosa_awal',
        'diagnosa_akhir',
        'tgl_masuk',
        'jam_masuk',
        'tgl_keluar',
        'jam_keluar',
        'lama',
        'ttl_biaya',
        'stts_pulang'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }

    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kd_kamar', 'kd_kamar');
    }

     public function detailPemberianObat()
    {
        return $this->hasMany(DetailPemberianObat::class, 'no_rawat', 'no_rawat');
    }

    public function biayaSekali()
    {
        return $this->hasMany(BiayaSekali::class, 'kd_kamar', 'kd_kamar');
    }

    public function biayaHarian()
    {
        return $this->hasMany(BiayaHarian::class, 'kd_kamar', 'kd_kamar');
    }

    public function rawatInapDrPr()
    {
        return $this->hasMany(RawatInapDrPr::class, 'no_rawat', 'no_rawat');
    }

    public function rawatInapPr()
    {
        return $this->hasMany(RawatInapPr::class, 'no_rawat', 'no_rawat');
    }

    public function rawatInapDr()
    {
        return $this->hasMany(RawatInapDr::class, 'no_rawat', 'no_rawat');
    }

    public function periksaLab()
    {
        return $this->hasMany(PeriksaLab::class, 'no_rawat', 'no_rawat');
    }

    public function periksaRadiologi()
    {
        return $this->hasMany(PeriksaRadiologi::class, 'no_rawat', 'no_rawat');
    }

    public function plafonInacbg()
    {
        return $this->hasMany(PlafonInacbg::class, 'kd_penyakit', 'diagnosa_awal');
    }

    public function getTotalKeseluruhanAttribute()
    {
        return $this->total_obat + $this->total_biaya_kamar + $this->total_biaya_tindakan + $this->total_biaya_lab + $this->total_biaya_radiologi;
    }

    // Menambahkan relasi dengan PemeriksaanRalan
    public function pemeriksaanRalan()
    {
        return $this->hasMany(PemeriksaanRalan::class, 'no_rawat', 'no_rawat');
    }
}
