<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanPakai extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'aturan_pakai';

    protected $fillable = ['tgl_perawatan', 'jam', 'no_rawat', 'kode_brng', 'aturan'];
    
}
