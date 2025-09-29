<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamMasuk extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'jam_masuk';
    protected $fillable = [
        'shift', 'jam_masuk', 'jam_pulang','h1', 'h2', 'h3','h4','h5','h6','h7','h8','h9','h10','h11','h12','h13','h14','h15','h16','h17','h18','h19','h20','h21','h22','h23','h24','h25','h26','h27','h28','h29','h30','h31'
    ];
}