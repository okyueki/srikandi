<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBudayaKerja extends Model
{
    use HasFactory;
     protected $table = 'jadwal_budaya_kerja';
    protected $primaryKey = 'id_jadwal_budaya_kerja';
    protected $fillable = [
        'nik', 'tanggal_bertugas', 'shift', 'hari'
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'nik', 'nip'); // Relasi ke tabel Petugas
    }
}