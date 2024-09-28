<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $connection = 'server_74';
    protected $table = 'inventaris';
    protected $primaryKey = 'no_inventaris';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'no_inventaris',
        'kode_barang',
        'asal_barang',
        'tgl_pengadaan',
        'harga',
        'status_barang',
        'id_ruang',
        'no_rak',
        'no_box'
    ];
    
    
    public function barang()
    {
        return $this->belongsTo(InventarisBarang::class, 'kode_barang', 'kode_barang');
    }
    
    public function ruang()
    {
    return $this->belongsTo(InventarisRuang::class, 'id_ruang', 'id_ruang');
    }
    
    public function gambar()
    {
        return $this->hasMany(InventarisGambar::class, 'no_inventaris', 'no_inventaris');
    }
    
}