<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateLaboratorium extends Model
{
    protected $connection = 'server_74';
    protected $table = 'template_laboratorium';

    protected $primaryKey = 'id_template';

    // Tambahkan atribut fillable sesuai dengan kolom yang dapat diisi secara massal
    protected $fillable = [
        'kd_jenis_prw',
        'id_template',
        'Pemeriksaan',
        'satuan',
        'nilai_rujukan_ld',
        'nilai_rujukan_la',
        'nilai_rujukan_pd',
        'nilai_rujukan_pa',
        'bagian_rs',
        'bhp',
        'bagian_perujuk',
        'bagian_dokter',
        'bagian_laborat',
        'kso',
        'menejemen',
        'biaya_item',
        'urut',
    ];
}
