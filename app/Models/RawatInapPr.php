<?php

namespace App\Models;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatInapPr extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'rawat_inap_pr';

    public function kamarInap()
    {
        return $this->hasMany(KamarInap::class, 'no_rawat', 'no_rawat');
    }
    public function jenisPerawatan()
    {
        return $this->belongsTo(JnsPerawatanInap::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'nip', 'nip');
    }
}