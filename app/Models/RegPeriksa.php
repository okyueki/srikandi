<?php

namespace App\Models;

use App\Models\Poliklinik;
use App\Models\Dokter;
use App\Models\Penjab;
use App\Models\Kamar;
use App\Models\ProsedurPasien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    protected $connection = 'server_74';
    protected $table = 'reg_periksa'; // Sesuaikan dengan nama tabel Anda
    // Tambahan properti lainnya jika diperlukan
    // Definisikan relasi dengan model Dokter
    protected $fillable = ['status_poli'];
    
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'kd_poli', 'kd_poli');
    }
    public function penjab()
    {
        return $this->belongsTo(Penjab::class, 'kd_pj', 'kd_pj');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kd_kamar', 'kd_kamar');
    }
     public function sep()
    {
        return $this->belongsTo(SEP::class, 'no_rawat', 'no_rawat');
    }
    // Definisikan relasi dengan model PemeriksaanRalan
    public function pemeriksaanRalan()
    {
        return $this->hasOne(PemeriksaanRalan::class, 'no_rawat', 'no_rawat');
    }
    
    public function resepObat()
    {
        return $this->belongsTo(ResepObat::class, 'no_rawat', 'no_rawat');
    }
    
    public function diagnosaPasien()
    {
        return $this->hasMany(DiagnosaPasien::class, 'no_rawat', 'no_rawat');
    }
     public function prosedurPasien() // Tambahkan ini
    {
        return $this->hasMany(ProsedurPasien::class, 'no_rawat', 'no_rawat');
    }
    
}
