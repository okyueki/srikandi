<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetKeterlambatan extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'set_keterlambatan';
    protected $fillabel = ['toleransi', 'terlambat1', 'terlambat2'];
}

