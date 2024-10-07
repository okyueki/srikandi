<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisBarang extends Model
{
    use HasFactory;

    protected $connection = 'server_74';
    protected $table = 'inventaris_barang';

    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    // Nonaktifkan timestamps
    public $timestamps = false;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jml_barang',
        'kode_produsen',
        'id_merk',
        'thn_produksi',
        'isbn',
        'id_kategori',
        'id_jenis'
    ];

    // Relasi dengan tabel lain
    public function produsen()
    {
        return $this->belongsTo(InventarisProdusen::class, 'kode_produsen', 'kode_produsen');
    }

    public function merk()
    {
        return $this->belongsTo(InventarisMerk::class, 'id_merk', 'id_merk');
    }

    public function kategori()
    {
        return $this->belongsTo(InventarisKategori::class, 'id_kategori', 'id_kategori');
    }

    public function jenis()
    {
        return $this->belongsTo(InventarisJenis::class, 'id_jenis', 'id_jenis');
    }
}
