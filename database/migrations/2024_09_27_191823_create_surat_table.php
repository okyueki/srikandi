<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->bigIncrements('id_surat');
            $table->string('kode_surat')->unique();
            $table->string('nomor_surat')->nullable();
            $table->unsignedBigInteger('id_klasifikasi_surat')->nullable();
            $table->unsignedBigInteger('id_sifat_surat')->nullable();
            $table->string('nik_pengirim', 20)->nullable();
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->string('lampiran', 20);
            $table->string('file_surat')->nullable();  // Path file surat yang diupload
            $table->string('file_lampiran')->nullable();  // Path file surat yang diupload
            $table->timestamps();
            
            $table->foreign('id_klasifikasi_surat')
                  ->references('id_klasifikasi_surat')->on('klasifikasi_surat')
                  ->onDelete('set null');

            $table->foreign('id_sifat_surat')
                  ->references('id_sifat_surat')->on('sifat_surat')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat');
    }
}
