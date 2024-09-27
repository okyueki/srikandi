<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'barcode';
    protected $fillable = [
        'id',
        'barcode'
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id', 'id'); // Sesuaikan foreign key dan local key jika perlu
    }
}
