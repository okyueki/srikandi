<?php

namespace App\Models;
use App\Models\KamarInap;
use App\Models\PemeriksaanRalan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemberianObat extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'detail_pemberian_obat';
    protected $fillable = [
        'tgl_perawatan',
        'jam',
        'no_rawat',
        'kode_brng',
        'h_beli',
        'biaya_obat',
        'jml',
        'embalase',
        'tuslah',
        'total',
        'status',
        'kd_bangsal',
        'no_batch',
        'no_faktur'
    ];

    public function kamarInap()
    {
        return $this->hasMany(KamarInap::class, 'no_rawat', 'no_rawat');
    }

    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'kode_brng', 'kode_brng');
    }
    
}