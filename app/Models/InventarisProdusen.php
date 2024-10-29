<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisProdusen extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'inventaris_produsen';
    protected $fillable = [
        'kode_produsen', 'nama_produsen', 'alamat_produsen', 'no_telp', 'email', 'website_produsen'
    ];
}
