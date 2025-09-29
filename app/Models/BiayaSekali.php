<?php

namespace App\Models;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaSekali extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'biaya_sekali';
    protected $fillable = [
        'no_rawat',
        'total',
        'status'
    ];

    public function kamarInap()
    {
        return $this->hasMany(KamarInap::class, 'no_rawat', 'no_rawat');
    }
}