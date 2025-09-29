<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InacbgGroupingStage12 extends Model
{
    use HasFactory;
    protected $connection = 'server_74'; // Koneksi database sekunder
    protected $table = 'inacbg_grouping_stage12';

    protected $fillable = [
        'no_sep', 'code_cbg', 'deskripsi', 'tarif'
    ];
}
