<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponKerja extends Model
{
    use HasFactory;

    protected $table = 'respon_kerja'; // Nama tabel

    protected $fillable = [
        'ticket_id',
        'teknisi_id',
        'foto_hasil',
        'deskripsi_hasil',
        'status_akhir',
        'biaya',
        'tingkat_kesulitan',
        'petunjuk_penyelesaian'
    ];

    // Relasi ke tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relasi ke teknisi (Pegawai)
    public function teknisi()
    {
        return $this->belongsTo(Pegawai::class, 'teknisi_id', 'nik'); // Hubungkan teknisi_id dengan nik di tabel pegawai
    }
}