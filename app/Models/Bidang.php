<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $connection = 'server_74';
    protected $table = 'bidang';
    protected $primaryKey = 'nama'; // Pastikan primary key di set ke 'dep_id'
    public $incrementing = false; // Jika dep_id bukan auto increment, tambahkan ini
    protected $keyType = 'string'; // Jika dep_id adalah char atau varchar

    protected $fillable = ['nama']; // sesuaikan dengan kolom yang ada di tabel departemen
    // app/Models/Departemen.php
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'bidang', 'nama');
    }
    
}

