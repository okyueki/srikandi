<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiSurat extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_surat';
    protected $primaryKey = 'id_verifikasi_surat';
    protected $fillable = [
        'id_surat',
        'nik_verifikator',
        'status_surat',
        'tanggal_verifikasi',
        'catatan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik_verifikator', 'nik');
    }
    public function surat()
{
    return $this->belongsTo(Surat::class, 'id_surat', 'id_surat');
}
}
