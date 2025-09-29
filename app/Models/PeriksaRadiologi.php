<?php

namespace App\Models;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriksaRadiologi extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'periksa_radiologi'; 
    protected $fillable = [
        'no_rawat',
        'nip',
        'kd_jenis_prw',
        'tgl_periksa',
        'jam',
        'dokter_perujuk',
        'bagian_rs',
        'bhp',
        'tarif_perujuk',
        'tarif_tindakan_dokter',
        'tarif_tindakan_petugas',
        'kso',
        'menejemen',
        'biaya',
        'kd_dokter',
        'status',
        'proyeksi',
        'kV',
        'mAS',
        'FFD',
        'BSF',
        'inak',
        'jml_penyinaran',
        'dosis',
    ];
    
    public function kamarInap()
    {
        return $this->hasMany(KamarInap::class, 'no_rawat', 'no_rawat');
    }
    
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rawat', 'no_rawat');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function jnsPerawatanRadiologi()
    {
        return $this->belongsTo(JnsPerawatanRadiologi::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'nip', 'nip');
    }
}
