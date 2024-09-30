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
use App\Http\Controllers\Kepegawaian\PresensiController;
use App\Http\Controllers\Kepegawaian\PegawaiController;
use App\Http\Controllers\Kepegawaian\AbsensiController;
use App\Http\Controllers\Kepegawaian\BirthdayController;
use App\Http\Controllers\Kepegawaian\PenilaianController;
use App\Http\Controllers\Kepegawaian\ItemPenilaianController;
use App\Http\Controllers\Inventaris\InventarisBarangController;
use App\Http\Controllers\Inventaris\InventarisController;
use App\Http\Controllers\Inventaris\PermintaanPerbaikanInventarisController;
use App\Http\Controllers\Inventaris\PerbaikanInventarisController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\SuratKeluarController;


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
Route::get('/presensi/verifikasi/{id}', [PresensiController::class, 'verifikasiPresensi'])->name('presensi.verifikasi');

Route::get('/absensi', [AbsensiController::class, 'showPresensiForm'])->name('absensi.show');
Route::post('/absensi', [AbsensiController::class, 'handlePresensi'])->name('absensi.handle');
Route::post('/presensi', [App\Http\Controllers\Kepegawaian\AbsensiController::class, 'handlePresensi'])->name('presensi.handle');
Route::get('/pegawai', [PegawaiController::class, 'index'])->middleware(['auth'])->name('pegawai.index');

Route::middleware(['auth'])->group(function () {
    Route::resource('inventaris-barang', InventarisBarangController::class)->names([
        'index' => 'inventaris-barang.index',
        'create' => 'inventaris-barang.create',
        'store' => 'inventaris-barang.store',
        'show' => 'inventaris-barang.show',
        'edit' => 'inventaris-barang.edit',
        'update' => 'inventaris-barang.update',
        'destroy' => 'inventaris-barang.destroy'
    ]);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('inventaris', InventarisController::class)->names([
        'index' => 'inventaris.index',
        'create' => 'inventaris.create',
        'store' => 'inventaris.store',
        'show' => 'inventaris.show',
        'edit' => 'inventaris.edit',
        'update' => 'inventaris.update',
        'destroy' => 'inventaris.destroy'
    ]);
});

Route::get('/calendar', [FullCalendarController::class, 'index'])->name('calendar.index');
Route::get('/pegawai/birthday', [BirthdayController::class, 'index'])->name('pegawai.birthday');

Route::middleware(['auth'])->group(function () {
    Route::resource('penilaian', PenilaianController::class)->names([
        'index' => 'penilaian.index',
        'create' => 'penilaian.create',
        'store' => 'penilaian.store',
        'show' => 'penilaian.show',
        'edit' => 'penilaian.edit',
        'update' => 'penilaian.update',
        'destroy' => 'penilaian.destroy',
    ]);

    Route::resource('item_penilaian', ItemPenilaianController::class)->names([
        'index' => 'item_penilaian.index',
        'create' => 'item_penilaian.create',
        'store' => 'item_penilaian.store',
        'show' => 'item_penilaian.show',
        'edit' => 'item_penilaian.edit',
        'update' => 'item_penilaian.update',
        'destroy' => 'item_penilaian.destroy',
    ]);

    Route::get('/search-pegawai', [PenilaianController::class, 'searchPegawai'])
        ->name('penilaian.search_pegawai');
});

Route::post('/rekapitulasi-bulanan', [PenilaianController::class, 'rekapitulasiBulanan'])->name('rekapitulasi.bulanan');
Route::resource('surat_keluar', SuratKeluarController::class)->middleware('auth');