<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEP extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'bridging_sep';

    protected $fillable = [
        'no_sep', 'no_rawat', 'tglsep', 'tglrujukan', 'no_rujukan', 'kdppkrujukan', 'nmppkrujukan', 
        'kdppkpelayanan', 'nmppkpelayanan', 'jnspelayanan', 'catatan', 'diagawal', 'nmdiagnosaawal', 
        'kdpolitujuan', 'nmpolitujuan', 'klsrawat', 'klsnaik', 'pembiayaan', 'pjnaikkelas', 'lakalantas', 
        'user', 'nomr', 'nama_pasien', 'tanggal_lahir', 'peserta', 'jkel', 'no_kartu', 'tglpulang', 
        'asal_rujukan', 'eksekutif', 'cob', 'notelep', 'katarak', 'tglkkl', 'keterangankkl', 'suplesi', 
        'no_sep_suplesi', 'kdprop', 'nmprop', 'kdkab', 'nmkab', 'kdkec', 'nmkec', 'noskdp', 'kddpjp', 
        'nmdpdjp', 'tujuankunjungan', 'flagprosedur', 'penunjang', 'asesmenpelayanan', 'kddpjplayanan', 
        'nmdpjplayanan'
    ];
    
    public function suratkontrol()
    {
        return $this->belongsTo(BridgingSuratKontrolBPJS::class, 'no_sep', 'no_sep');
    }
    
    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
}
