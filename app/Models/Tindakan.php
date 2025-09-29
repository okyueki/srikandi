<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = 'tindakan';
    protected $primaryKey = 'id_tindakan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_tindakan',
        'no_rawat',
        'tindakan',
        'tanggal',
    ];
}
