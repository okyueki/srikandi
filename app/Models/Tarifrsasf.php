<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifrsasf extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'tarifrsasf';

    protected $fillable = [
        'kd_penyakit', 'kelas', 'nm_diagnosa', 'grouper', 'tarif'
    ];
}
