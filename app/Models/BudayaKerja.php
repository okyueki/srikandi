<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudayaKerja extends Model
{
    use HasFactory;

    protected $table = 'budaya_kerja';

    protected $fillable = [
        'tanggal', 
        'jam', 
        'petugas', 
        'nik_pegawai', 
        'nama_pegawai', 
        'departemen', 
        'jabatan', 
        'shift',
        'sepatu', 
        'sabuk', 
        'make_up', 
        'minyak_wangi', 
        'jilbab', 
        'kuku', 
        'baju', 
        'celana', 
        'name_tag', 
        'perhiasan', 
        'kaos_kaki', 
        'total_nilai',
    ];
    
    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'petugas', 'nik');
    }

    public function bawahan()
    {
        return $this->belongsTo(Pegawai::class, 'nik_pegawai', 'nik');
    }
}