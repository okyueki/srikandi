<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Model
{
    use HasFactory, HasApiTokens;

    protected $connection = 'server_74';
    protected $table = 'pegawai';

    protected $fillable = [
        'id', 'nik', 'nama', 'jk', 'jbtn', 'jnj_jabatan', 'kode_kelompok', 'kode_resiko',
        'kode_emergency', 'departemen', 'bidang', 'stts_wp', 'stts_kerja', 'npwp', 
        'pendidikan', 'gapok', 'tmp_lahir', 'tgl_lahir', 'alamat', 'kota', 'mulai_kerja',
        'ms_kerja', 'indexins', 'bpd', 'rekening', 'stts_aktif', 'wajibmasuk', 'pengurang',
        'indek', 'mulai_kontrak', 'cuti_diambil', 'dankes', 'photo', 'no_ktp'
    ];

    public function departemen_unit()
    {
        return $this->belongsTo(Departemen::class, 'departemen', 'dep_id');
    }
    public function temporarypresensi()
    {
        return $this->belongsTo(TemporaryPresensi::class, 'id', 'id');
    }
    // Define the inverse relationship
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'nip', 'nik'); // Assuming 'nip' in Petugas corresponds to 'nik' in Pegawai
    }
}
