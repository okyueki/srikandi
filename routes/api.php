<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Pegawai;
use App\Models\Agenda;
use App\Http\Controllers\Api\BookingOperasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/pegawai/{nik}', function($nik) {
    // Cari pegawai berdasarkan NIK
    $pegawai = Pegawai::where('nik', $nik)->firstOrFail();
    
    // Kembalikan data pegawai sebagai JSON
    return response()->json([
        'nama' => $pegawai->nama,
        'departemen' => $pegawai->departemen,
        'jabatan' => $pegawai->jbtn
    ]);
});
Route::get('/agenda/{id}', function($id) {
    // Cari agenda berdasarkan ID
    $agenda = Agenda::findOrFail($id);
    
    // Kembalikan data tanggal mulai
    return response()->json([
        'mulai' => $agenda->mulai,
    ]);
});

Route::get('/pegawai/{nik}', function ($nik) {
    $pegawai = Pegawai::where('nik', $nik)->first();

    if ($pegawai) {
        return response()->json([
            'nama' => $pegawai->nama,
            'departemen' => $pegawai->departemen,
            'jabatan' => $pegawai->jbtn
        ]);
    }

    return response()->json(['message' => 'Pegawai tidak ditemukan!'], 404);
});

Route::get('/booking-operasi', [BookingOperasiController::class, 'index']);