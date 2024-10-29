<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryPresensi extends Model
{
    use HasFactory;

    protected $connection = 'server_74';
    protected $table = 'temporary_presensi';

    // Disable automatic timestamps
    public $timestamps = false;

    protected $fillable = [
        'id', 'shift', 'jam_datang', 'jam_pulang', 'status', 
        'keterlambatan', 'durasi', 'photo'
    ];
    protected $casts = [
        'jam_datang' => 'datetime',
        'jam_pulang' => 'datetime',  // Jika juga butuh jam_pulang
    ];

    
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id', 'id');
    }
}