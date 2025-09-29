<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatJlDr extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'rawat_jl_dr';
    protected $fillabel = ['no_rawat', 'kd_jenis_prw', 'kd_dokter', 'tgl_perawatan', 'jam_rawat', 'material', 'bhp', 'tarif_tindakandr', 'kso', 'menejemen', 'biaya_rawat', 'stts_bayar'];
    
    public function jnsPerawatan()
{
    return $this->belongsTo(JnsPerawatan::class, 'kd_jenis_prw', 'kd_jenis_prw');
}
    public function dokter()
{
    return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
}
    
}
