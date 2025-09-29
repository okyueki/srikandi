<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_pegawai', function (Blueprint $table) {
            $table->bigIncrements('id_berkas_pegawai',5);
            $table->string('nik_pegawai', 30);
            $table->unsignedBigInteger('id_jenis_berkas'); 
            $table->string('nomor_berkas', 50)->nullable();
            $table->string('file', 255)->nullable();
            $table->enum('status_berkas', ['Masih Berlaku','Tidak Berlaku','Proses Pengajuan'])->default('Masih Berlaku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berkas_pegawai');
    }
}
