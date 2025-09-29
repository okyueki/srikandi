<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BridgingSEP extends Model
{
    protected $connection = 'server_74';
    protected $table = 'bridging_sep';
    protected $fillabel = ['no_sep', 'no_rawat', 'tglsep', 'tglrujukan', 'no_rujukan', 'kdppkrujukan', 'nmppkrujukan', 'kdppkpelayanan', 'nmppkpelayanan', 'jnspelayanan', 'catatan', 'diagawal', 'nmdiagnosaawal', 'kdpolitujuan', 'nmpolitujuan', 'klsrawat', 'klsnaik', 'pembiayaan', 'pjnaikkelas', 'lakalantas', 'user', 'nomr', 'nama_pasien', 'tanggal_lahir', 'peserta', 'jkel', 'no_kartu', 'tglpulang', 'asal_rujukan', 'eksekutif', 'cob', 'notelep', 'katarak', 'tglkkl', 'keterangankkl', 'suplesi', 'no_sep_suplesi', 'kdprop', 'nmprop', 'kdkab', 'nmkab', 'kdkec', 'nmkec', 'noskdp', 'kddpjp', 'nmdpdjp', 'tujuankunjungan', 'flagprosedur', 'penunjang', 'asesmenpelayanan', 'kddpjplayanan', 'nmdpjplayanan' ];

    public function regperiksa()
    {
        return $this->hasOne(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    public function inacbgGroupingStage12()
    {
        return $this->hasOne(InacbgGroupingStage12::class, 'no_sep', 'no_sep');
    }
}