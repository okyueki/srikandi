<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'databarang';

    // Tentukan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'kode_brng', 'nama_brng', 'kode_satbesar', 'kode_sat', 'letak_barang', 'dasar', 
        'h_beli', 'ralan', 'kelas1', 'kelas2', 'kelas3', 'utama', 'vip', 'vvip', 
        'beliluar', 'jualbebas', 'karyawan', 'stokminimal', 'kdjns', 'isi', 'kapasitas', 
        'expire', 'status', 'kode_industri', 'kode_kategori', 'kode_golongan'
    ];

}
