<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPenilaianBulanan extends Model
{
    use HasFactory;

    protected $table = 'rekap_penilaian_bulanan';

    protected $fillable = ['pegawai_id', 'bulan', 'total_nilai_bulanan'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}