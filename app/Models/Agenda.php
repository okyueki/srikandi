<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';

    // Definisikan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'nomor_agenda',
        'judul',
        'deskripsi',
        'mulai',
        'akhir',
        'tempat',
        'pimpinan_rapat',
        'notulen',
        'yang_terundang',
        'foto',
        'materi',
        'keterangan',
    ];

    // Relasi ke model Pegawai untuk pimpinan rapat
    public function pimpinan()
    {
        return $this->belongsTo(Pegawai::class, 'pimpinan_rapat', 'nik');
    }

    // Relasi ke model Pegawai untuk notulen
    public function notulenPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'notulen', 'nik');
    }

    // Relasi untuk yang terundang, karena menggunakan JSON kita perlu memprosesnya berbeda
    public function getYangTerundangAttribute($value)
    {
        // Mengembalikan array NIK yang terundang
        return json_decode($value, true);
    }

    // Method untuk mengambil data pegawai yang terundang
    public function terundang()
    {
        return $this->hasMany(Pegawai::class, 'nik', 'yang_terundang');
    }
        public function absensi()
    {
        return $this->hasMany(AbsensiAgenda::class, 'agenda_id', 'id');
    }
}
