<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        $pegawai = Pegawai::where('nik', Auth::user()->username)->first();

        if (!$pegawai) {
            abort(404, 'Pegawai tidak ditemukan');
        }

        return view('profil.show', compact('pegawai'));
    }
}
