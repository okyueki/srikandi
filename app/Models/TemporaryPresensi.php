<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryPresensi extends Model
{
    use HasFactory;
    protected $connection = 'server_74';
    protected $table = 'temporary_presensi';

    protected $fillable = [
        'id','shift','jam_datang','jam_pulang','status','keterlambatan','durasi','photo'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id', 'id');
    }
}
