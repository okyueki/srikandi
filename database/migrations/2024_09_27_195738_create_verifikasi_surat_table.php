<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifikasiSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifikasi_surat', function (Blueprint $table) {
            $table->bigIncrements('id_verifikasi_surat');
            $table->unsignedBigInteger('id_surat');
            $table->string('nik_verifikator');  // NIK pegawai yang melakukan verifikasi
            $table->enum('status_surat', ['Dikirim', 'Dibaca','Disetujui', 'Ditolak'])->default('dikirim');
            $table->timestamp('tanggal_verifikasi')->nullable();  // Tanggal verifikasi dilakukan
            $table->text('catatan')->nullable();  // Catatan dari verifikator
            $table->timestamps();

            // Foreign key ke tabel surat
            $table->foreign('id_surat')
                  ->references('id_surat')->on('surat')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifikasi_surat');
    }
}
