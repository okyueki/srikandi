<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisKategori extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'inventaris_kategori';
    protected $fillable = [
        'id_kategori','nama_kategori'
    ];
}
