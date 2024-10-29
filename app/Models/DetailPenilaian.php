<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    protected $table = 'detail_penilaian';

    protected $fillable = ['penilaian_harian_id', 'item_penilaian_id', 'nilai'];

    public function penilaianHarian()
    {
        return $this->belongsTo(PenilaianHarian::class, 'penilaian_harian_id', 'id');
    }

    public function itemPenilaian()
    {
        return $this->belongsTo(ItemPenilaian::class, 'item_penilaian_id', 'id');
    }
}
