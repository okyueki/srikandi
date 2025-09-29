<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianHarian extends Model
{
    use HasFactory;

    protected $table = 'penilaian_harian';

    protected $fillable = ['pegawai_id', 'tanggal_penilaian', 'waktu_penilaian', 'total_nilai'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');  // Relasi ke model Pegawai
    }

    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'penilaian_harian_id', 'id');
    }
    
    public function getTotalNilaiAttribute()
    {
        return $this->detailPenilaian->reduce(function ($carry, $detail) {
            return $carry + ($detail->nilai ? $detail->itemPenilaian->bobot_nilai : 0);
            }, 
        0);
    }
}