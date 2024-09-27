<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiSurat extends Model
{
    use HasFactory;
    
    protected $table = 'klasifikasi_surat';
    // Tentukan primary key jika tidak menggunakan id (default)
    protected $primaryKey = 'id_klasifikasi_surat';

    protected $fillable = [
        'kode_klasifikasi_surat',
        'nama_klasifikasi_surat'
    ];
}
