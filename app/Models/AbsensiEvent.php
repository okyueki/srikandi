<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiEvent extends Model
{
    use HasFactory;

    protected $table = 'absensi_event';

    protected $fillable = [
        'nik',
        'nama',
        'departemen',
        'agenda_id',
        'tanggal',
        'jam_checkin',
        'latitude',
        'longitude',
        'keterangan',
        'foto',
    ];

    // Relasi ke tabel pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }

    // Relasi ke tabel agendas
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
}