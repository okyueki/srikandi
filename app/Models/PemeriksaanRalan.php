<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanRalan extends Model
{
    use HasFactory;
    protected $connection = 'server_74';

    protected $table = 'pemeriksaan_ralan';
    // protected $primaryKey = ['no_rawat', 'tgl_perawatan', 'jam_rawat']; // Dihapus
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_rawat', 'tgl_perawatan', 'jam_rawat', 'suhu_tubuh', 'tensi', 'nadi', 'respirasi', 'tinggi', 'berat', 'spo2', 'gcs', 'kesadaran', 'keluhan', 'pemeriksaan', 'alergi', 'lingkar_perut', 'rtl', 'penilaian', 'instruksi', 'evaluasi', 'nip',
    ];

    /* Dihapus sementara
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('no_rawat', $this->getAttribute('no_rawat'))
            ->where('tgl_perawatan', $this->getAttribute('tgl_perawatan'))
            ->where('jam_rawat', $this->getAttribute('jam_rawat'));
    }
    */

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nik');
    }
    
    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
}
