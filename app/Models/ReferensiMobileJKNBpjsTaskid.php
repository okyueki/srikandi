<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiMobileJKNBpjsTaskid extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'referensi_mobilejkn_bpjs_taskid';
    protected $fillable = ['no_rawat', 'taskid', 'waktu'];

    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat')
            ->select('no_rawat', 'kd_dokter', 'no_rkm_medis', 'kd_poli')
            ->with('pasien','dokter','poliklinik');
    }
}

