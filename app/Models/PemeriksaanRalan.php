<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanRalan extends Model
{
    use HasFactory;
    protected $connection = 'server_74';

    protected $table = 'pemeriksaan_ralan';

    protected $fillable = [
        'no_rawat', 'tgl_perawatan', 'jam_rawat', 'suhu_tubuh', 'tensi', 'nadi', 'respirasi', 'tinggi', 'berat', 'spo2', 'gcs', 'kesadaran', 'keluhan', 'pemeriksaan', 'alergi', 'lingkar_perut', 'rtl', 'penilaian', 'instruksi', 'evaluasi', 'nip',
    ];
}
