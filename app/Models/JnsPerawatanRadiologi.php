<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JnsPerawatanRadiologi extends Model
{
    
    protected $connection = 'server_74';
    protected $table = 'jns_perawatan_radiologi';
    
    protected $fillable = [
        'kd_jenis_prw', 'nm_perawatan', 'bagian_rs', 'bhp', 'tarif_perujuk', 'tarif_tindakan_dokter', 'tarif_tindakan_petugas', 'kso', 'menejemen', 'total_byr', 'kd_pj', 'status', 'kelas',
        // tambahkan kolom lainnya sesuai dengan kebutuhan
    ];
}
