<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLibur extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_libur';
    protected $primaryKey = 'id_pengajuan_libur';

    protected $fillable = [
        'kode_pengajuan_libur',
        'jenis_pengajuan_libur',
        'nik',
        'alamat',
        'keterangan',
        'tanggal_awal',
        'tanggal_akhir',
        'jumlah_hari',
        'nik_atasan_langsung',
        'status',
        'catatan',
        'foto',
        'tanggal_dibuat',
        'tanggal_diverifikasi',
    ];
    
    public function pegawai()
{
    return $this->belongsTo(Pegawai::class, 'nik', 'nik');
}

    public function pegawai2()
    {
        return $this->belongsTo(Pegawai::class, 'nik_atasan_langsung', 'nik');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class,  'nik','nip'); // Assuming the field name in PengajuanLibur
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate a unique kode_pengajuan_libur
            $model->kode_pengajuan_libur = 'PL-' . str_pad(PengajuanLibur::max('id_pengajuan_libur') + 1, 6, '0', STR_PAD_LEFT);
        });
    }
}
