<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DiagnosaPasien extends Model
{
    protected $connection = 'server_74';
    protected $table = 'diagnosa_pasien';

    protected $fillable = [
        'no_rawat', 'kd_penyakit', 'status',
    ];

    // Relasi ke model Penyakit
    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'kd_penyakit', 'kd_penyakit');
    }

    // Fungsi untuk mengambil data penyakit terbanyak berdasarkan tanggal
    public static function getTopDiseases($startDate, $endDate)
    {
        return static::select('kd_penyakit', DB::raw('COUNT(*) as count'))
            ->join('reg_periksa', 'diagnosa_pasien.no_rawat', '=', 'reg_periksa.no_rawat')
            ->whereBetween('reg_periksa.tgl_registrasi', [$startDate, $endDate])
            ->groupBy('kd_penyakit')
            ->orderByRaw('COUNT(*) DESC')
            ->take(10)
            ->get();
    }
    
    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }

    public function tarif()
    {
        return $this->hasOne(Tarifrsasf::class, 'kd_penyakit', 'kd_penyakit');
    }
    
    public function sep()
{
    return $this->hasOne(BridgingSEP::class, 'no_rawat', 'no_rawat');
}

public function prosedurPasien()
{
    return $this->hasMany(ProsedurPasien::class, 'no_rawat', 'no_rawat');
}

    
}
