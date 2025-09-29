<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanRanap extends Model
{
    protected $connection = 'server_74';
    protected $table = 'pemeriksaan_ranap';
    // protected $primaryKey = ['no_rawat', 'tgl_perawatan', 'jam_rawat']; // Dihapus karena Eloquent tidak mendukung composite key secara default
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_rawat', 'tgl_perawatan', 'jam_rawat', 'suhu_tubuh', 'tensi', 'nadi', 'respirasi', 
        'tinggi', 'berat', 'spo2', 'gcs', 'kesadaran', 'keluhan', 'pemeriksaan', 'alergi', 
        'penilaian', 'rtl', 'instruksi', 'evaluasi', 'nip'
    ];

    // Jika menggunakan composite primary key, kita tangani manual saat menyimpan atau query
    /* Dihapus sementara untuk mengatasi error, Eloquent menangani ini secara berbeda
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
