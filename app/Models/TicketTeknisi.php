<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTeknisi extends Model
{
    use HasFactory;

    protected $table = 'ticket_teknisi';

    protected $fillable = [
        'ticket_id',
        'teknisi_id',
    ];

    // Relasi ke tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relasi ke pengguna (Pegawai)
    public function pengguna()
    {
        return $this->belongsTo(Pegawai::class, 'teknisi_id', 'nik');
    }
}
