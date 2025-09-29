<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd9 extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'icd9';
    protected $fillable = [
        'kode', 'deskripsi_panjang', 'deskripsi_pendek',
    ];
}
