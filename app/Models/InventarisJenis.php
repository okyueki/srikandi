<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisJenis extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'inventaris_jenis';
    protected $fillable = [
        'id_jenis','nama_jenis'
    ];
}
