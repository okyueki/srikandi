<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPegawai extends Model
{
    use HasFactory;

    protected $table = 'berkas_pegawai'; // Nama tabel
    protected $primaryKey = 'id_berkas_pegawai'; // Primary Key

    protected $fillable = [
        'nik_pegawai',
        'id_jenis_berkas',
        'nomor_berkas',
        'file',
        'status_berkas',
    ];

    /**
     * Relasi dengan model JenisBerkas
     */
    public function jenisBerkas()
    {
        return $this->belongsTo(JenisBerkas::class, 'id_jenis_berkas', 'id_jenis_berkas');
    }

    /**
     * Relasi dengan model Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik_pegawai', 'nik');
    }
}