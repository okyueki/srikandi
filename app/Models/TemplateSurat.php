<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';
    protected $primaryKey = 'id_template_surat';

    protected $fillable = [
        'nama_template',
        'deskripsi',
        'file_template',
    ];
}
