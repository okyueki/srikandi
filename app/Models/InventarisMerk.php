<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisMerk extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'inventaris_merk';
    protected $fillable = [
        'id_merk','nama_merk'
    ];
}
