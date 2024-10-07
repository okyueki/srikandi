<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamJaga extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'jam_jaga';
    protected $fillable = [
        'no_id', 'shift', 'jam_masuk', 'jam_pulang'
    ];
}
