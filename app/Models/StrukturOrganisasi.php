<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id_struktur_organisasi';
    protected $fillable = [
        'nik',
        'nik_atasan_langsung',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'nik_atasan_langsung', 'nik');
    }
}
