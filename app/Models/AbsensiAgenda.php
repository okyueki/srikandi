<?php
// App\Models\AbsensiAgenda.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiAgenda extends Model
{
    use HasFactory;

    protected $table = 'absensi_agenda';

    protected $fillable = [
        'nik',
        'agenda_id',
        'waktu_kehadiran',
        'token',
    ];
    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }

    // Relasi ke model Agenda
    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id');
    }
}
