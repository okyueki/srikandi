<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdimeGizi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'server_74';
    protected $table = 'catatan_adime_gizi';
    
    
     // Tentukan primary key yang benar
    protected $primaryKey = ['no_rawat', 'tanggal'];

    // Jika primary key bukan auto-increment, tambahkan properti ini
    public $incrementing = false;

    // Jika primary key bukan tipe integer, tambahkan properti ini
    protected $keyType = 'string';

    protected $fillable = [
        'no_rawat',
        'tanggal',
        'asesmen',
        'diagnosis',
        'intervensi',
        'monitoring',
        'evaluasi',
        'instruksi',
        'nip',
    ];

    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nik');
    }
    
     protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }
    
     public function getFormattedTanggalAttribute()
    {
        return Carbon::parse($this->attributes['tanggal'])->format('Y-m-d');
    }
}
