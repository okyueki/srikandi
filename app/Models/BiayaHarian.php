<?php

namespace App\Models;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaHarian extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'biaya_harian';

    public function kamarInap()
    {
        return $this->hasMany(KamarInap::class, 'kd_kamar', 'kd_kamar');
    }
}