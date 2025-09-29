<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AgendaToken extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'agenda_tokens';

    // Primary key
    protected $primaryKey = 'id_agenda_tokens';

    // Kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        'token',
        'agenda_id',
        'expiry',
    ];

    // Relasi ke model Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id');
    }

    // Cek apakah token sudah expired
    public function isExpired()
    {
        return Carbon::now()->greaterThan(Carbon::parse($this->expiry));
    }
}
