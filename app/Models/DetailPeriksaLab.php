<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeriksaLab extends Model
{
    protected $connection = 'server_74';
    protected $table = 'detail_periksa_lab';

    protected $fillable = [
        'no_rawat',
        'kd_jenis_prw',
        'tgl_periksa',
        'jam',
        'id_template',
        'nilai',
        'nilai_rujukan',
        'keterangan',
        // tambahkan kolom lainnya sesuai dengan kebutuhan
    ];

    public function templateLaboratorium()
{
    return $this->belongsTo(TemplateLaboratorium::class, 'id_template');
}
    // tambahkan relasi atau metode lainnya jika diperlukan
}
