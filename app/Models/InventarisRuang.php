<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisRuang extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'inventaris_ruang';
    protected $fillable = [
        'id_ruang','nama_ruang'
    ];
}
