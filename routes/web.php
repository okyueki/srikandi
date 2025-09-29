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
    AIController,
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
    RekapPresensiController,
    BudayaKerjaController
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
use App\Http\Controllers\KamarInap\{
    KamarInapController,PemeriksaanRanapController,
    SoapieController,AdimeGiziController};

use App\Http\Controllers\Grafik\GrafikralanController;
use App\Http\Controllers\TataNaskahController;
use App\Http\Controllers\JenisBerkasController;
use App\Http\Controllers\BerkasPegawaiController;
use App\Http\Controllers\Kpi\PenilaianIndividuController;
use App\Http\Controllers\AbsensiAgendaController;
use App\Http\Controllers\JadwalBudayaKerjaController;
use App\Http\Controllers\UbahPasswordController;
use App\Http\Controllers\PemakaianKamarController;
use App\Http\Controllers\PasienRawatInapController;
use App\Http\Controllers\PasienRawatJalanController;
use App\Http\Controllers\DischargeNoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\DischargeNotePublicController;
use App\Http\Controllers\DataDischargeNoteController;
use App\Http\Controllers\RanapDokterController;

Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');

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
Route::get('/struktur_organisasi/{id}', [StrukturOrganisasiController::class, 'show'])->name('struktur_organisasi.show')->middleware('auth');
Route::get('/struktur_organisasi/tree', [StrukturOrganisasiController::class, 'getTreeData'])->name('struktur_organisasi.tree')->middleware('auth');

Route::get('/verifikasi_pengajuan_libur', [VerifikasiPengajuanLiburController::class, 'index'])->name('verifikasi_pengajuan_libur.index')->middleware('auth');
Route::get('/verifikasi_pengajuan_libur/detail/{id}', [VerifikasiPengajuanLiburController::class, 'detail'])->name('verifikasi_pengajuan_libur.detail')->middleware('auth');
Route::put('/verifikasi_pengajuan_libur/update/{id}', [VerifikasiPengajuanLiburController::class, 'update'])->name('verifikasi_pengajuan_libur.update')->middleware('auth');
Route::delete('/verifikasi_pengajuan_libur/destroy/{id}', [VerifikasiPengajuanLiburController::class, 'destroy'])
    ->name('verifikasi_pengajuan_libur.destroy')
    ->middleware('auth');
Route::get('/pengajuan_libur/show/{kode_pengajuan_libur}', [PengajuanLiburController::class, 'show'])->name('pengajuan_libur.show')->middleware('auth');
Route::get('/pengajuan_libur/cuti/pdf/{kode_pengajuan_libur}', [PengajuanLiburController::class, 'generateCutiPDF'])->name('pengajuan-libur-cuti.pdf')->middleware('auth');
Route::get('/pengajuan_libur/ijin/pdf/{kode_pengajuan_libur}', [PengajuanLiburController::class, 'generateIjinPDF'])->name('pengajuan-libur-ijin.pdf')->middleware('auth');
Route::get('/rekap-libur', [PengajuanLiburController::class, 'rekapLibur'])->name('pengajuan_libur.rekap-libur')->middleware('auth');

Route::resource('pengajuan_lembur', PengajuanLemburController::class)->middleware('auth');
Route::get('/verifikasi_pengajuan_lembur', [VerifikasiPengajuanLemburController::class, 'index'])->name('verifikasi_pengajuan_lembur.index')->middleware('auth');
Route::get('/verifikasi_pengajuan_lembur/detail/{id}', [VerifikasiPengajuanLemburController::class, 'detail'])->name('verifikasi_pengajuan_lembur.detail')->middleware('auth');
Route::put('/verifikasi_pengajuan_lembur/update/{id}', [VerifikasiPengajuanLemburController::class, 'update'])->name('verifikasi_pengajuan_lembur.update')->middleware('auth');

Route::get('/pengajuan_lembur/show/{kode_pengajuan_lembur}', [PengajuanLemburController::class, 'show'])->name('pengajuan_lembur.show');
Route::get('/pengajuan_lembur/pdf/{kode_pengajuan_lembur}', [PengajuanLemburController::class, 'generateLemburPDF'])->name('pengajuan-lembur.pdf');
Route::get('/rekap-lembur', [PengajuanLemburController::class, 'rekapLembur'])->name('rekap.lembur')->middleware('auth');

Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index')->middleware('auth');
Route::put('/presensi/{id}/datang', [PresensiController::class, 'updateJamDatang'])->name('presensi.updateJamDatang')->middleware('auth');
Route::put('/presensi/{id}/pulang', [PresensiController::class, 'updateJamPulang'])->name('presensi.updateJamPulang')->middleware('auth');
Route::get('/presensi/verifikasi/{id}', [PresensiController::class, 'verifikasiPresensi'])->name('presensi.verifikasi')->middleware('auth');

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
    Route::get('inventaris/{no_inventaris}/barcode', [InventarisController::class, 'generateBarcode'])->name('inventaris.barcode');
});

    Route::get('inventaris/{no_inventaris}/detail', [InventarisController::class, 'detail'])->name('inventaris.detail');

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
Route::get('/surat_keluar/show/{filename}', [SuratKeluarController::class, 'show'])->name('surat_keluar.show');
Route::get('/surat_keluar/detail/{encryptedKodeSurat}', [SuratKeluarController::class, 'detail'])->name('surat_keluar.detail')->middleware('auth');
Route::get('/surat_keluar/kirimsurat/{encryptedKodeSurat}', [SuratKeluarController::class, 'kirimsurat'])->name('surat_keluar.kirimsurat')->middleware('auth');
Route::post('/surat_keluar/kirimsuratproses', [SuratKeluarController::class, 'kirimSuratProses'])->name('surat_keluar.kirimSuratProses')->middleware('auth');

Route::resource('surat_masuk', SuratMasukController::class)->middleware('auth')->middleware('auth')->except('show');;
Route::get('/surat_masuk/verifikasi/{encryptedKodeSurat}', [SuratMasukController::class, 'verifikasi'])->name('surat_masuk.verifikasi')->middleware('auth');
Route::put('/surat_masuk/verifikasiproses/{id}', [SuratMasukController::class, 'verifikasiProses'])->name('surat_masuk.verifikasiProses')->middleware('auth');
Route::get('/surat_masuk/detail/{encryptedKodeSurat}', [SuratMasukController::class, 'detail'])->name('surat_masuk.detail')->middleware('auth');
Route::get('/surat_masuk/disposisi/{encryptedKodeSurat}', [SuratMasukController::class, 'disposisi'])->name('surat_masuk.disposisi')->middleware('auth');;
Route::put('/surat_masuk/disposisiProses/{id}', [SuratMasukController::class, 'disposisiProses'])->name('surat_masuk.disposisiProses')->middleware('auth');
Route::get('/surat_masuk/verifikasidisposisi/{encryptedKodeSurat}', [SuratMasukController::class, 'verifikasidisposisi'])->name('surat_masuk.verifikasidisposisi')->middleware('auth');;
Route::put('/surat_masuk/verifikasidisposisiProses/{id}', [SuratMasukController::class, 'verifikasidisposisiProses'])->name('surat_masuk.verifikasidisposisiProses')->middleware('auth');
Route::get('/surat_masuk/tindaklanjut/{encryptedKodeSurat}', [SuratMasukController::class, 'tindaklanjut'])->name('surat_masuk.tindaklanjut')->middleware('auth');
Route::post('/surat_masuk/tindaklanjut/proses/{id_surat}', [SuratMasukController::class, 'tindaklanjutProses'])->name('surat_masuk.tindaklanjutProses')->middleware('auth');
Route::get('/surat_masuk/show/{filename}', [SuratMasukController::class, 'show'])->name('surat_masuk.show');

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
    Route::get('/agenda/{id}/generate-qr', [AgendaController::class, 'generateQrCode'])->name('generate-qr');
    Route::get('/agenda/{agendaId}/qr-code', [AgendaController::class, 'showQRCodePage'])->name('agenda.qr_code');
    Route::get('/generate-qrcode', [AgendaController::class, 'generateQRCode'])->name('generate-qrcode');
    // Route untuk generate QR Code
    //Route::get('/agenda/{agendaId}/qr-code', [AgendaController::class, 'generateQRCodeBaru'])->name('agenda.qr_code');

    // Route untuk mengirim pesan melalui WAHA
    Route::get('/agenda/{agendaId}/send-message', [AgendaController::class, 'sendMessage'])->name('agenda.send_message');
    
    Route::get('/scan-barcode', [AbsensiAgendaController::class, 'scanBarcode'])->name('absensi.scan');
    Route::post('/proses-scan', [AbsensiAgendaController::class, 'scanAttendance'])->name('absensi.proses_scan'); 
    Route::get('/check-token-status', [AgendaController::class, 'checkTokenStatus'])->name('check.token.status');

});

Route::get('absensi_event/create', [AbsensiEventController::class, 'create'])->name('absensi_event.create');
Route::post('absensi_event', [AbsensiEventController::class, 'store'])->name('absensi_event.store');

Route::get('/surat/show/{encryptedKodeSurat}', [SuratController::class, 'show'])->name('surat.show');
Route::get('/surat/tampillampiran/{filename}', [SuratController::class, 'tampillampiran'])->name('surat_masuk.tampillampiran');
Route::resource('template_surat', TemplateSuratController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    
});
Route::get('/grafik-ralan', [GrafikralanController::class, 'index'])->name('grafikralan.index');

Route::get('/tata_naskah', [TataNaskahController::class, 'index'])->name('tata_naskah.index');
Route::resource('jenis_berkas', JenisBerkasController::class)->middleware('auth');
Route::resource('berkas_pegawai', BerkasPegawaiController::class)->middleware('auth');

Route::prefix('kpi')->group(function () {
    Route::get('/penilaian-individu/create', [PenilaianIndividuController::class, 'create'])->name('penilaian_individu.create');
    Route::post('/penilaian-individu', [PenilaianIndividuController::class, 'store'])->name('penilaian_individu.store');
    Route::get('/penilaian-individu', [PenilaianIndividuController::class, 'index'])->name('penilaian_individu.index');
});

Route::get('/kpi/penilaian/{id}', [PenilaianIndividuController::class, 'show'])->name('kpi.penilaian.show');
Route::get('/kpi/penilaian/{id}/edit', [PenilaianIndividuController::class, 'edit'])->name('kpi.penilaian.edit');
Route::put('/kpi/penilaian/{id}', [PenilaianIndividuController::class, 'update'])->name('kpi.penilaian.update');
Route::delete('/kpi/penilaian/{id}', [PenilaianIndividuController::class, 'destroy'])->name('kpi.penilaian.destroy');
Route::get('/presensi/show', [PenilaianIndividuController::class, 'showPresensi'])->name('presensi.show');
Route::post('/penilaian/kepatuhan', [PenilaianIndividuController::class, 'getKepatuhan']);

Route::get('/budayakerja/create', [BudayaKerjaController::class, 'create'])->name('budayakerja.create');
Route::post('/budayakerja/store', [BudayaKerjaController::class, 'store'])->name('budayakerja.store');
Route::get('/databudayakerja', [BudayaKerjaController::class, 'getData'])->name('budayakerja.getData');
Route::resource('budayakerja', BudayaKerjaController::class);

Route::get('/absensi_agenda', [AbsensiAgendaController::class, 'index'])->name('absensi_agenda.index');

Route::get('/scan-qr', [AbsensiAgendaController::class, 'showScanQRCodePage'])->name('absensi_agenda.scan_qr_page');
Route::post('/scan-attendance', [AbsensiAgendaController::class, 'scanAttendance'])->name('absensi_agenda.scan');
Route::get('/rekap-absensi', [AbsensiAgendaController::class, 'rekapAbsensi'])->name('rekap-absensi');

Route::resource('jadwalbudayakerja', JadwalBudayaKerjaController::class)->except('show')->middleware('auth');
Route::get('jadwalbudayakerja/kirimotomatis', [JadwalBudayaKerjaController::class,'kirimOtomatis'])->name('jadwalbudayakerja.kirimotomatis');
Route::get('/jadwalbudayakerja/kalender', [JadwalBudayaKerjaController::class, 'kalender'])->name('jadwalbudayakerja.kalender');
Route::get('/jadwalbudayakerja/events', [JadwalBudayaKerjaController::class, 'getEvents'])->name('jadwalbudayakerja.events');
Route::get('/jadwalbudayakerja/kirimhariini', [JadwalBudayaKerjaController::class, 'kirimHariIni']);

Route::middleware(['auth'])->group(function () {
    Route::get('/ubahpassword', [UbahPasswordController::class, 'index'])->name('ubahpassword.index');
    Route::post('/ubahpassword', [UbahPasswordController::class, 'update'])->name('ubahpassword.update'); // Ubah sesuai nama di form
});

Route::get('/pemakaiankamar', [PemakaianKamarController::class, 'index'])->name('pemakaiankamar.index')->middleware('auth');
Route::get('/laporanrawatinap', [PasienRawatInapController::class, 'index'])->name('pasienrawatinap.index')->middleware('auth');
Route::get('/laporanrawatjalan', [PasienRawatJalanController::class, 'index'])->name('pasienrawatjalan.index')->middleware('auth');

Route::get('/kamar_inap', [KamarInapController::class, 'index'])->middleware(['auth'])->name('kamar_inap.index');
Route::get('/kamar_inap/riwayat_pemeriksaan/{no_rawat}', [KamarInapController::class, 'riwayatPemeriksaan'])->name('kamar_inap.riwayat_pemeriksaan');
Route::get('/kamar_inap/{no_rawat}', [PemeriksaanRanapController::class, 'show'])->name('kamar_inap.show');

Route::middleware(['auth'])->group(function () {
    Route::get('kamar_inap/soapie/{no_rawat}', [SoapieController::class, 'show'])->name('soapie.show');
    Route::post('kamar_inap/soapie', [SoapieController::class, 'store'])->name('soapie.store');
});

Route::get('/adimegizi/{no_rawat}', [AdimeGiziController::class, 'index'])->middleware(['auth'])->name('adimegizi.index');
Route::get('/adimegizi/create/{no_rawat}', [AdimeGiziController::class, 'create'])->middleware(['auth'])->name('adimegizi.create');
Route::post('/destroy/{no_rawat}/{tanggal}', [AdimeGiziController::class, 'destroy'])->middleware(['auth'])->name('adimegizi.destroy');
Route::get('/adimegizi/{no_rawat}/{tanggal}/edit', [AdimeGiziController::class, 'edit'])->middleware(['auth'])->name('adimegizi.edit');
Route::post('/adimegizi/store', [AdimeGiziController::class, 'store'])->middleware(['auth'])->name('adimegizi.store');
Route::put('/adimegizi//update/{no_rawat}/{tanggal}', [AdimeGiziController::class, 'update'])->middleware(['auth'])->name('adimegizi.update');

Route::get('/discharge-note/{norawat}', [DischargeNoteController::class, 'index'])->name('discharge-note.index');
Route::post('/discharge-note/store', [DischargeNoteController::class, 'store'])->name('discharge-note.store');
Route::get('/discharge-note/{no_rawat}/edit', [DischargeNoteController::class, 'edit'])->name('discharge-note.edit');
Route::delete('/discharge-note/{no_rawat}', [DischargeNoteController::class, 'destroy'])->name('discharge-note.destroy');
Route::get('/dischargenote/{id}', [DischargeNoteController::class, 'show'])->name('discharge-note.show');
Route::get('/dischargenotepublic', [DischargeNotePublicController::class, 'index'])->name('dischargenotepublic.index');
Route::get('/dischargenotepublic/{id}', [DischargeNotePublicController::class, 'show'])->name('dischargenotepublic.show');

Route::get('/datadischargenote', [DataDischargeNoteController::class, 'index'])->name('datadischargenote.index');
Route::get('/datadischargenote/{id}', [DataDischargeNoteController::class, 'show'])->name('datadischargenote.show');
Route::get('/datadischargenote/{id}/pdf', [DataDischargeNoteController::class, 'generatePDF'])->name('datadischargenote.pdf');

// Route::get('/tindakan/{no_rawat}', [TindakanController::class, 'index'])->name('tindakan.index');
Route::post('/tindakan/{no_rawat}', [TindakanController::class, 'store'])->name('tindakan.store');
Route::put('/tindakan/{id}', [TindakanController::class, 'update'])->name('tindakan.update');
Route::delete('/tindakan/{id}', [TindakanController::class, 'destroy'])->name('tindakan.destroy');

Route::post('/obat/{no_rawat}', [ObatController::class, 'store'])->name('obat.store');
Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

// AI Integration Routes
Route::prefix('ai')->middleware('auth')->group(function () {
    Route::get('/', [AIController::class, 'index'])->name('ai.index');
    Route::post('/chat', [AIController::class, 'chat'])->name('ai.chat');
    Route::post('/analyze-medical', [AIController::class, 'analyzeMedical'])->name('ai.analyze-medical');
    Route::post('/generate-report', [AIController::class, 'generateReport'])->name('ai.generate-report');
    Route::get('/models', [AIController::class, 'getModels'])->name('ai.models');
    Route::get('/history', [AIController::class, 'getHistory'])->name('ai.history');
    Route::delete('/interaction/{id}', [AIController::class, 'deleteInteraction'])->name('ai.delete-interaction');
    Route::get('/test-connection', [AIController::class, 'testConnection'])->name('ai.test-connection');
});

Route::get('/ranap-dokter', [RanapDokterController::class, 'index'])->name('ranap_dokter.index');