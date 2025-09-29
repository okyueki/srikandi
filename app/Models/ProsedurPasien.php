<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsedurPasien extends Model
{
    use HasFactory;
    
    protected $connection = 'server_74';
    protected $table = 'prosedur_pasien';
    protected $fillable = [
        'no_rawat', 'kode', 'status', 'prioritas',
    ];
    
    // Relasi ke model Penyakit
    public function icd9()
{
    return $this->belongsTo(Icd9::class, 'kode', 'kode');
}

    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
}
