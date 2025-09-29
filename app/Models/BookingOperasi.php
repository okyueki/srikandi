<?php

// app/Models/BookingOperasi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingOperasi extends Model
{
    protected $connection = 'server_74';
    protected $table = 'booking_operasi';
    protected $primaryKey = ['no_rawat', 'kode_paket', 'jam_mulai']; // Composite keys (handled manually)

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_rawat',
        'kode_paket',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'kd_dokter',
        'kd_ruang_ok',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i:s',
        'jam_selesai' => 'datetime:H:i:s',
    ];
}
