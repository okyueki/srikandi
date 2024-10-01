<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPermintaan extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql';
    protected $table = 'jenis_permintaan';
    protected $fillable = [
        'id', 'nama_permintaan'
    ];
    
}