<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SifatSuratController;
use App\Http\Controllers\KlasifikasiSuratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\IjinController;
use App\Http\Controllers\PengajuanLiburController;
use App\Http\Controllers\PengajuanLemburController;
use App\Http\Controllers\VerifikasiPengajuanLiburController;
use App\Http\Controllers\VerifikasiPengajuanLemburController;
use App\Http\Controllers\StrukturOrganisasiController;
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => true]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::resource('sifat_surat', SifatSuratController::class)->middleware('auth');
Route::resource('klasifikasi_surat', KlasifikasiSuratController::class)->middleware('auth');
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('cuti', CutiController::class)->middleware('auth');
Route::resource('ijin', IjinController::class)->middleware('auth');
Route::resource('struktur_organisasi', StrukturOrganisasiController::class)->middleware('auth');
Route::get('/struktur_organisasi/{id}', [StrukturOrganisasiController::class, 'show'])->name('struktur_organisasi.show');
Route::get('/struktur_organisasi/tree', [StrukturOrganisasiController::class, 'getTreeData'])->name('struktur_organisasi.tree');

Route::get('/verifikasi_pengajuan_libur', [VerifikasiPengajuanLiburController::class, 'index'])->name('verifikasi_pengajuan_libur.index')->middleware('auth');
Route::get('/verifikasi_pengajuan_libur/detail/{id}', [VerifikasiPengajuanLiburController::class, 'detail'])->name('verifikasi_pengajuan_libur.detail')->middleware('auth');
Route::put('/verifikasi_pengajuan_libur/update/{id}', [VerifikasiPengajuanLiburController::class, 'update'])->name('verifikasi_pengajuan_libur.update')->middleware('auth');
Route::get('/pengajuan_libur/show/{kode_pengajuan_libur}', [PengajuanLiburController::class, 'show'])->name('pengajuan_libur.show');
Route::get('/pengajuan_libur/cuti/pdf/{kode_pengajuan_libur}', [PengajuanLiburController::class, 'generateCutiPDF'])->name('pengajuan-libur-cuti.pdf');
Route::get('/pengajuan_libur/ijin/pdf/{kode_pengajuan_libur}', [PengajuanLiburController::class, 'generateIjinPDF'])->name('pengajuan-libur-ijin.pdf');

Route::resource('pengajuan_lembur', PengajuanLemburController::class)->middleware('auth');
Route::get('/verifikasi_pengajuan_lembur', [VerifikasiPengajuanLemburController::class, 'index'])->name('verifikasi_pengajuan_lembur.index')->middleware('auth');
Route::get('/verifikasi_pengajuan_lembur/detail/{id}', [VerifikasiPengajuanLemburController::class, 'detail'])->name('verifikasi_pengajuan_lembur.detail')->middleware('auth');
Route::put('/verifikasi_pengajuan_lembur/update/{id}', [VerifikasiPengajuanLemburController::class, 'update'])->name('verifikasi_pengajuan_lembur.update')->middleware('auth');
Route::get('/pengajuan_lembur/show/{kode_pengajuan_lembur}', [PengajuanLemburController::class, 'show'])->name('pengajuan_lembur.show');
Route::get('/pengajuan_lembur/pdf/{kode_pengajuan_lembur}', [PengajuanLemburController::class, 'generateLemburPDF'])->name('pengajuan-lembur.pdf');

Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
Route::put('/presensi/{id}/datang', [PresensiController::class, 'updateJamDatang'])->name('presensi.updateJamDatang');
Route::put('/presensi/{id}/pulang', [PresensiController::class, 'updateJamPulang'])->name('presensi.updateJamPulang');