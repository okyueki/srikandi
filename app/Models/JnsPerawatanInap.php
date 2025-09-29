<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPerawatanInap extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'jns_perawatan_inap';
    
    protected $fillable = [
        'kd_jenis_prw', 'nm_perawatan', 'kd_kategori', 'material', 'bhp', 'tarif_tindakandr', 'tarif_tindakanpr', 'kso', 'menejemen', 'total_byrdr', 'total_byrpr', 'total_byrdrpr', 'kd_pj', 'kd_bangsal', 'status', 'kelas',
        // tambahkan kolom lainnya sesuai dengan kebutuhan
    ];
}
