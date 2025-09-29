<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $connection = 'server_74';
    protected $table = 'pasien';
    
    protected $fillable = [
        'no_rkm_medis', 'nm_pasien', 'no_ktp', 'jk', 'tmp_lahir', 'tgl_lahir', 
        'nm_ibu', 'alamat', 'gol_darah', 'pekerjaan', 'stts_nikah', 'agama', 
        'tgl_daftar', 'no_tlp', 'umur', 'pnd', 'keluarga', 'namakeluarga', 
        'kd_pj', 'no_peserta', 'kd_kel', 'kd_kec', 'kd_kab', 'pekerjaanpj', 
        'alamatpj', 'kelurahanpj', 'kecamatanpj', 'kabupatenpj', 
        'perusahaan_pasien', 'suku_bangsa', 'bahasa_pasien', 'cacat_fisik', 
        'email', 'nip', 'kd_prop', 'propinsipj'
    ];
    /**
     * Validate if the given phone number is valid.
     *
     * @param string $phoneNumber
     * @return bool
     */
    public function isValidPhoneNumber($phoneNumber)
    {
        // Example validation: Check if the phone number contains only digits
        // and has a length of 10 to 12 characters.
        return preg_match('/^[0-9]{10,12}$/', $phoneNumber);
    }
}
