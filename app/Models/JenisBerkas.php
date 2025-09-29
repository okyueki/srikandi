<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBerkas extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jenis_berkas';
    protected $fillable = [
        'jenis_berkas',
        'bidang',
        'masa_berlaku',
    ];
}
