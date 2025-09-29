<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SifatSurat extends Model
{
    use HasFactory;
    
    protected $table = 'sifat_surat';
    // Tentukan primary key jika tidak menggunakan id (default)
    protected $primaryKey = 'id_sifat_surat';

    protected $fillable = [
        'nama_sifat_surat'
    ];
}
