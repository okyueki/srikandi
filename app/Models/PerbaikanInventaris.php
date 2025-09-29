<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanInventaris extends Model
{
    use HasFactory;

    protected $connection = 'sik3';  // Gunakan koneksi sik3
    protected $table = 'perbaikan_inventaris';
    public $timestamps = true;

    protected $primaryKey = 'no_permintaan';  // Menggunakan 'no_permintaan' sebagai primary key
    public $incrementing = false;  // Non-incrementing karena primary key bukan integer
    protected $keyType = 'string';  // Jika primary key adalah string

    protected $fillable = [
        'no_permintaan',
        'tanggal',
        'uraian_kegiatan',
        'nip',
        'pelaksana',
        'biaya',
        'keterangan',
        'status',
        'waktu_mulai',
        'waktu_selesai',
        'prioritas',
    ];
    
    protected $dates = ['waktu_mulai', 'waktu_selesai', 'created_at', 'updated_at'];
    // Relasi ke tabel permintaan_perbaikan_inventaris
    public function permintaanPerbaikan()
    {
        return $this->belongsTo(PermintaanPerbaikanInventaris::class, 'no_permintaan', 'no_permintaan');
    }

    // Relasi ke tabel petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'nip', 'nip');
    }
}
