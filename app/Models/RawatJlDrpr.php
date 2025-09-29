<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatJlDrpr extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'rawat_jl_pr';
    protected $fillabel = ['no_rawat', 'kd_jenis_prw', 'kd_dokter', 'nip', 'tgl_perawatan', 'jam_rawat', 'material', 'bhp', 'tarif_tindakandr', 'tarif_tindakanpr', 'kso', 'menejemen', 'biaya_rawat', 'stts_bayar'];
    
    public function jnsPerawatan()
{
    return $this->belongsTo(JnsPerawatan::class, 'kd_jenis_prw', 'kd_jenis_prw');
}

}
