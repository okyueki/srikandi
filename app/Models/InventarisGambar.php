<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisGambar extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    public $timestamps = false;
    protected $table = 'inventaris_gambar';
    protected $fillable = [
        'no_inventaris','photo'
    ];
}
