<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPerawatan extends Model
{
    use HasFactory;
    protected $connection = 'server_74'; // Koneksi database sekunder
    protected $table = 'jns_perawatan';

    protected $fillable = ['kd_jenis_prw', 'nm_perawatan', 'kd_kategori', 'material', 'bhp', 'tarif_tindakandr', 'tarif_tindakanpr', 'kso', 'menejemen', 'total_byrdr', 'total_byrpr', 'total_byrdrpr', 'kd_pj', 'kd_poli', 'status'];
}
