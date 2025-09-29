<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asuhan_pasca_ranap', function (Blueprint $table) {
            $table->id();
            $table->string('no_rawat');
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->string('kondisi_pulang')->nullable();
            $table->string('kd_dokter')->nullable();
            $table->string('diagnosa_awal')->nullable();
            $table->string('diagnosa_akhir')->nullable();
            $table->string('total_waktu_tidur')->nullable();
            $table->enum('kualitas_tidur', ['Nyenyak', 'Kurang nyeyak', 'Tidak nyenyak'])->nullable();
            $table->string('kalori_makan')->nullable();
            $table->enum('waktu_luang', ['Tidak Ada', 'Sangat Sedikit', 'Cukup'])->nullable();
            $table->json('aktifitas_luang')->nullable();
            $table->text('catatan_khusus')->nullable();
            $table->text('nutrisi_makan')->nullable();
            $table->text('nutrisi_minum')->nullable();
            $table->enum('duduk', ['Mandiri','Sebagian','Total'])->nullable();
            $table->enum('berdiri', ['Mandiri','Sebagian','Total'])->nullable();
            $table->enum('bergerak', ['Mandiri','Sebagian','Total'])->nullable();
            $table->string('bak')->nullable();
            $table->string('bab')->nullable();
            $table->json('luka_operasi')->nullable();
            $table->string('deskripsi_perawatan')->nullable();
            $table->json('keluarga')->nullable();
            $table->json('batuan_dibutuhkan')->nullable();
            $table->enum('bayi_menyusui', ['Sangat baik', 'Cukup baik', 'Kesulitan menetek', 'Rewel', 'Malas'])->nullable();
            $table->json('tali_pusat_bayi')->nullable();
            $table->enum('bab_bayi', ['Sangat sering', 'Sering', 'Jarang', 'Tidak', 'Lainnya'])->nullable();
            $table->enum('bak_bayi', ['Sangat sering', 'Sering', 'Jarang', 'Tidak', 'Lainnya'])->nullable();
            $table->enum('kesehatan_umum', ['Baik', 'Sedang', 'Buruk'])->nullable();
            $table->string('tensi')->nullable();
            $table->string('rr')->nullable();
            $table->string('spo2')->nullable();
            $table->string('temp')->nullable();
            $table->enum('anak_kondsi', ['Baik', 'Sedang', 'Buruk'])->nullable();
            $table->enum('bayi_kondisi', ['Baik', 'Sedang', 'Buruk'])->nullable();
            $table->string('tinggi_fundus_uteri')->nullable();
            $table->string('kontraksi_rahim')->nullable();
            $table->string('pengeluaran_pravagina')->nullable();
            $table->string('lochea')->nullable();
            $table->json('luka_opera_bersalin')->nullable();
            $table->enum('luka_perineum', ['Bersih','Kotor','Bengkak', 'Berdarah', 'Terbuka'])->nullable();
            $table->text('catatan_tambahan')->nullable();
            $table->string('nik')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asuhan_pasca_ranap');
    }
};
