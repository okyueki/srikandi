<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_lembur';
    protected $primaryKey = 'id_pengajuan_lembur';

    protected $fillable = [
        'kode_pengajuan_lembur',
        'nik',
        'keterangan',
        'tanggal_lembur',
        'jam_awal',
        'jam_akhir',
        'nik_atasan_langsung',
        'status',
        'catatan',
        'tanggal_verifikasi'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }

    public function pegawai2()
    {
        return $this->belongsTo(Pegawai::class, 'nik_atasan_langsung', 'nik');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate a unique kode_pengajuan_libur
            $model->kode_pengajuan_lembur = 'LM-' . str_pad(PengajuanLembur::max('id_pengajuan_lembur') + 1, 6, '0', STR_PAD_LEFT);
        });
    }
}
