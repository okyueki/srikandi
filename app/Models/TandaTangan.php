<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TandaTangan extends Model
{
    use HasFactory;

    protected $table = 'tanda_tangan'; // Nama tabel
    protected $primaryKey = 'id_tanda_tangan'; // Nama primary key
    protected $fillable = [
        'id_surat',
        'nik_penandatangan',
        'status_ttd',
    ];

    // Definisikan relasi dengan model Surat jika diperlukan
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    // Definisikan relasi dengan model Pegawai jika diperlukan
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik_penandatangan', 'nik');
    }
}
