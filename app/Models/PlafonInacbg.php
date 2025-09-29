<?php

namespace App\Models;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlafonInacbg extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'plafon_inacbg';

    public function kamarInap()
    {
        return $this->hasMany(KamarInap::class, 'kd_penyakit', 'diagnosa_awal');
    }
}