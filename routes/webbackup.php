<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    SifatSuratController,
    KlasifikasiSuratController,
    DashboardController,
    UserController,
    CutiController,
    IjinController,
    PengajuanLiburController,
    PengajuanLemburController,
    VerifikasiPengajuanLiburController,
    VerifikasiPengajuanLemburController,
    StrukturOrganisasiController,
    SuratKeluarController,
    SuratMasukController,
    SuratController,
    TemplateSuratController,
    FullCalendarController,
    AgendaController,
    AbsensiEventController,
    TicketController,
    Profil\ProfilController,
    Auth\LogoutController
};
use App\Http\Controllers\Kepegawaian\{
    PresensiController,
    PegawaiController,
    AbsensiController,
    BirthdayController,
    PenilaianController,
    ItemPenilaianController,
    JadwalController,
    RekapPresensiController
};
use App\Http\Controllers\Inventaris\{
    InventarisBarangController,
    InventarisController,
    PermintaanPerbaikanInventarisController,
    PerbaikanInventarisController
};
use App\Http\Controllers\Helpdesk\{
    HelpdeskController,
    ResponKerjaController,
    KomentarController,
    TicketTeknisiController
};

use App\Http\Controllers\Grafik\GrafikralanController;
use App\Http\Controllers\Kpi\IndikatorController;
use App\Http\Controllers\Kpi\PenilaianKpiController;
use App\Http\Controllers\TataNaskahController;
use App\Http\Controllers\JenisBerkasController;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Auth::routes(['register' => true]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::group(['middleware' => ['auth', 'checkLevel:Kabag']], function () {
Route::resource('sifat_surat', SifatSuratController::class);
Route::resource('klasifikasi_surat', KlasifikasiSuratController::class);
});

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

Route::get('/kepegawaian/rekap-presensi', [RekapPresensiController::class, 'index'])->name('kepegawaian.rekap_presensi.index')->middleware('auth');
Route::get('/kepegawaian/rekap-presensi/data', [RekapPresensiController::class, 'getData'])->name('kepegawaian.rekap_presensi.data')->middleware('auth');

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
Route::get('/surat_keluar/show/{encryptedKodeSurat}', [SuratKeluarController::class, 'show'])->name('surat_keluar.show');
Route::get('/surat_keluar/detail/{encryptedKodeSurat}', [SuratKeluarController::class, 'detail'])->name('surat_keluar.detail')->middleware('auth');
Route::get('/surat_keluar/kirimsurat/{encryptedKodeSurat}', [SuratKeluarController::class, 'kirimsurat'])->name('surat_keluar.kirimsurat')->middleware('auth');
Route::post('/surat_keluar/kirimsuratproses', [SuratKeluarController::class, 'kirimSuratProses'])->name('surat_keluar.kirimSuratProses')->middleware('auth');

Route::resource('surat_masuk', SuratMasukController::class)->middleware('auth')->middleware('auth');
Route::get('/surat_masuk/verifikasi/{encryptedKodeSurat}', [SuratMasukController::class, 'verifikasi'])->name('surat_masuk.verifikasi')->middleware('auth');
Route::put('/surat_masuk/verifikasiproses/{id}', [SuratMasukController::class, 'verifikasiProses'])->name('surat_masuk.verifikasiProses')->middleware('auth');
Route::get('/surat_masuk/detail/{encryptedKodeSurat}', [SuratMasukController::class, 'detail'])->name('surat_masuk.detail')->middleware('auth');
Route::get('/surat_masuk/disposisi/{encryptedKodeSurat}', [SuratMasukController::class, 'disposisi'])->name('surat_masuk.disposisi')->middleware('auth');;
Route::put('/surat_masuk/disposisiProses/{id}', [SuratMasukController::class, 'disposisiProses'])->name('surat_masuk.disposisiProses')->middleware('auth');
Route::get('/surat_masuk/verifikasidisposisi/{encryptedKodeSurat}', [SuratMasukController::class, 'verifikasidisposisi'])->name('surat_masuk.verifikasidisposisi')->middleware('auth');;
Route::put('/surat_masuk/verifikasidisposisiProses/{id}', [SuratMasukController::class, 'verifikasidisposisiProses'])->name('surat_masuk.verifikasidisposisiProses')->middleware('auth');
Route::get('/surasurat_masuk/tindaklanjut/{encryptedKodeSurat}', [SuratMasukController::class, 'tindaklanjut'])->name('surat_masuk.tindaklanjut')->middleware('auth');
Route::post('/surat_masuk/tindaklanjut/proses/{id_surat}', [SuratMasukController::class, 'tindaklanjutProses'])->name('surat_masuk.tindaklanjutProses')->middleware('auth');

Route::resource('tickets', TicketController::class);
Route::put('/ticket/{id}/status', [ResponKerjaController::class, 'updateStatus'])->name('ticket.updateStatus');

Route::get('/get-no-hp', [TicketController::class, 'getNoHp'])->name('get.nohp');

Route::get('/helpdesk/dashboard', [HelpdeskController::class, 'index'])->name('helpdesk.dashboard');
Route::get('/helpdesk/ticket/{id}', [HelpdeskController::class, 'show'])->name('helpdesk.ticket.show');
Route::get('/helpdesk/ticket/{id}/respon/create', [ResponKerjaController::class, 'create'])->name('responKerja.create');
Route::post('/helpdesk/ticket/{id}/respon', [ResponKerjaController::class, 'store'])->name('responKerja.store');
Route::put('/helpdesk/ticket/respon/{id}', [ResponKerjaController::class, 'update'])->name('responKerja.update');
Route::post('/helpdesk/ticket/{ticket}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
Route::post('/helpdesk/ticket/{ticket}/teknisi', [TicketTeknisiController::class, 'store'])->name('teknisi.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('jadwal/{id}/edit/{bulan}/{tahun}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('jadwal/{id}/update/{bulan}/{tahun}', [JadwalController::class, 'update'])->name('jadwal.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/agenda', [AgendaController::class, 'index'])->name('acara_index');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('acara_store');
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('acara_create');
    Route::get('/agenda/{id}/edit', [AgendaController::class, 'edit'])->name('acara_edit');
    Route::put('/agenda/{id}', [AgendaController::class, 'update'])->name('acara_update');
    Route::delete('/agenda/{id}', [AgendaController::class, 'destroy'])->name('acara_destroy');
    Route::get('/agenda/show/{id}', [AgendaController::class, 'show'])->name('acara_show'); 
    Route::get('/backend-acara', [AgendaController::class, 'backendAcara'])->name('backend_acara');
});

Route::get('absensi_event/create', [AbsensiEventController::class, 'create'])->name('absensi_event.create');
Route::post('absensi_event', [AbsensiEventController::class, 'store'])->name('absensi_event.store');

Route::get('/surat/show/{encryptedKodeSurat}', [SuratController::class, 'show'])->name('surat.show');
Route::resource('template_surat', TemplateSuratController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    
});
Route::get('/grafik-ralan', [GrafikralanController::class, 'index'])->name('grafikralan.index');

Route::prefix('indikator')->name('indikator.')->middleware('auth')->group(function () {
    Route::get('/', [IndikatorController::class, 'index'])->name('index');
    Route::get('/create', [IndikatorController::class, 'create'])->name('create');
    Route::post('/', [IndikatorController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [IndikatorController::class, 'edit'])->name('edit');
    Route::put('/{id}', [IndikatorController::class, 'update'])->name('update');
    Route::delete('/{id}', [IndikatorController::class, 'destroy'])->name('destroy');
});

Route::prefix('kpipenilaian')->name('penilaian.kpi.')->middleware('auth')->group(function () {
    Route::get('/', [PenilaianKpiController::class, 'index'])->name('index'); // List all KPI assessments
    Route::get('/create', [PenilaianKpiController::class, 'create'])->name('penilaian.kpi.create');

    Route::post('/', [PenilaianKpiController::class, 'store'])->name('store'); // Store new KPI assessment
    Route::get('/{id}/edit', [PenilaianKpiController::class, 'edit'])->name('edit'); // Edit form for existing KPI assessment
    Route::put('/{id}', [PenilaianKpiController::class, 'update'])->name('update'); // Update existing KPI assessment
    Route::delete('/{id}', [PenilaianKpiController::class, 'destroy'])->name('destroy'); // Delete KPI assessment
});

Route::get('/tata_naskah', [TataNaskahController::class, 'index'])->name('tata_naskah.index');
Route::resource('jenis_berkas', JenisBerkasController::class)->middleware('auth');;
