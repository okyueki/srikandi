<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsuhanPascaRanap extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'asuhan_pasca_ranap';
    
    protected $fillable = [
        'no_rawat',
        'tgl_masuk',
        'tgl_keluar',
        'kondisi_pulang',
        'kd_dokter',
        'diagnosa_awal',
        'diagnosa_akhir',
        'total_waktu_tidur',
        'kualitas_tidur',
        'kalori_makan',
        'waktu_luang',
        'aktifitas_luang',
        'catatan_khusus',
        'nutrisi_makan',
        'nutrisi_minum',
        'duduk',
        'berdiri',
        'bergerak',
        'bak',
        'bab',
        'luka_operasi',
        'deskripsi_perawatan',
        'keluarga',
        'batuan_dibutuhkan',
        'bayi_menyusui',
        'tali_pusat_bayi',
        'bab_bayi',
        'bak_bayi',
        'kesehatan_umum',
        'tensi',
        'rr',
        'spo2',
        'temp',
        'anak_kondsi',
        'bayi_kondisi',
        'tinggi_fundus_uteri',
        'kontraksi_rahim',
        'pengeluaran_pravagina',
        'lochea',
        'luka_opera_bersalin',
        'luka_perineum',
        'catatan_tambahan',
        'nik',
    ];

    protected $casts = [
        'aktifitas_luang' => 'array',
        'luka_operasi' => 'array',
        'keluarga' => 'array',
        'batuan_dibutuhkan' => 'array',
        'tali_pusat_bayi' => 'array',
        'luka_opera_bersalin' => 'array',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
    
    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nik');
    }
    
    public function tindakan()
    {
        return $this->hasMany(Tindakan::class, 'no_rawat', 'no_rawat');
    }
    
     public function kamarInap()
    {
         return $this->hasOne(KamarInap::class, 'no_rawat', 'no_rawat');

    }
    public function obat()
    {
        return $this->hasMany(Obat::class, 'no_rawat', 'no_rawat');
    }
}
