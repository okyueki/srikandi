<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bangsal extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'bangsal';
 
     protected $fillable = [
        'kd_bangsal',
        'nm_bangsal',
        'status',
    ];
    
   
}
