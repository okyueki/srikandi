<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilRadiologi extends Model
{
    protected $connection = 'server_74';
    protected $table = 'hasil_radiologi';

    protected $primaryKey = 'id'; // Ganti dengan primary key tabel jika berbeda

    protected $fillable = [
        'no_rawat',
        'tgl_periksa',
        'jam',
        'hasil',
    ];
}
