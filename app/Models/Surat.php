<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $primaryKey = 'id_surat';
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'no_urut',
        'id_klasifikasi_surat',
        'id_sifat_surat',
        'nik_pengirim',
        'pengirim_external',
        'perihal',
        'tanggal_surat',
        'lampiran',
        'tanggal_surat_diterima',
        'file_surat',
        'file_lampiran',
    ];

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiSurat::class, 'id_surat');
    }
    public function disposisi()
    {
        return $this->hasOne(DisposisiSurat::class, 'id_surat');
    }
    public function klasifikasi_surat()
    {
        return $this->belongsTo(KlasifikasiSurat::class, 'id_klasifikasi_surat','id_klasifikasi_surat');
    }
    public function sifat_surat()
    {
        return $this->belongsTo(SifatSurat::class, 'id_sifat_surat');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik_pengirim', 'nik');
    }
}
