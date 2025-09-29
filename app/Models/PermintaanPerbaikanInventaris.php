<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanPerbaikanInventaris extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $connection = 'sik3';
    protected $table = 'permintaan_perbaikan_inventaris';
    
    protected $primaryKey = 'no_permintaan';  // Menggunakan 'no_permintaan' sebagai primary key
    public $incrementing = false;  // Non-incrementing karena primary key bukan integer
    protected $keyType = 'string';  // Jika primary key adalah string
    
    protected $fillable = ['no_permintaan', 'no_inventaris', 'nik', 'tanggal', 'deskripsi_kerusakan','status', 
        'prioritas'];

    public function perbaikan()
    {
        return $this->hasOne(PerbaikanInventaris::class, 'no_permintaan', 'no_permintaan');
    }
    
    public function inventaris()
    {
    return $this->belongsTo(Inventaris::class, 'no_inventaris', 'no_inventaris');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nik','nik');
    }
}
