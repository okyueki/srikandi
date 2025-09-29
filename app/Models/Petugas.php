<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'petugas'; // Assuming your table name is 'petugas'

    protected $fillable = [
        'nip', 'nama', 'jk', 'tmp_lahir', 'tgl_lahir', 'gol_darah',
        'agama', 'stts_nikah', 'alamat', 'kd_jbtn', 'no_telp', 'status'
    ];

    // Define the relationship to Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nik'); // Assuming 'nip' is the foreign key and 'nik' is the primary key in Pegawai
    }
    public function jadwalBudayaKerja()
    {
        return $this->hasMany(JadwalBudayaKerja::class, 'nik', 'nip');
    }
}