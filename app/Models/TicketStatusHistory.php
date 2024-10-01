<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'ticket_status_history'; // Nama tabel

    protected $fillable = [
        'ticket_id',
        'status',
        'changed_at',
    ];

    // Relasi ke tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
