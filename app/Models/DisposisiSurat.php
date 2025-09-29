<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiSurat extends Model
{
    use HasFactory;

    protected $table = 'disposisi_surat';
    protected $primaryKey = 'id_disposisi_surat';
    protected $fillable = [
        'id_surat',
        'nik_disposisi',
        'nik_penerima',
        'status_disposisi',
        'tanggal_disposisi',
        'catatan_disposisi',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik_disposisi', 'nik');
    }
    public function pegawai2()
    {
        return $this->belongsTo(Pegawai::class, 'nik_penerima', 'nik');
    }
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}