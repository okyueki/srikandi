<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'penyakit';
    protected $fillable = [
        'kd_penyakit', 'nm_penyakit', 'ciri_ciri', 'keterangan', 'kd_ktg', 'status',
    ];
}
