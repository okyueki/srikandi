<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BridgingSuratKontrolBPJS extends Model
{
    protected $connection = 'server_74';
    protected $table = 'bridging_surat_kontrol_bpjs';
    protected $fillable = [
        'no_sep', 'tgl_surat', 'no_surat', 'tgl_rencana',
        'kd_dokter_bpjs', 'nm_dokter_bpjs', 'kd_poli_bpjs', 'nm_poli_bpjs'
    ];
    
    public function sep()
    {
        return $this->belongsTo(SEP::class, 'no_sep', 'no_sep');
    }

    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }
}
