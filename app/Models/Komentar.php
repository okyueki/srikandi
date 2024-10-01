<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';

    protected $fillable = [
        'ticket_id',
        'email',
        'komentar',
    ];

    // Relasi ke tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relasi ke pengguna (Pegawai atau teknisi)
    public function pengguna()
    {
        return $this->belongsTo(Pegawai::class, 'pengguna_id', 'nik');
    }
}
