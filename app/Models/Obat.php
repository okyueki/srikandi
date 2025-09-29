<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';
    public $incrementing = true; // karena id_obat bukan auto-increment (bisa disesuaikan)
    protected $keyType = 'int';

    protected $fillable = [
        'id_obat',
        'no_rawat',
        'nama_obat',
        'dosis',
        'cara_pakai',
        'frekuensi',
        'fungsi_obat',
        'dosis_terakhir',
        'keterangan',
    ];
}