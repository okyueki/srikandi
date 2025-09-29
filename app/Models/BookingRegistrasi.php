<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRegistrasi extends Model
{
    protected $connection = 'server_74';
    protected $table = 'booking_registrasi';

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

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'kd_dokter', 'kd_dokter');
    }
}
