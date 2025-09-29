<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianIndividuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('penilaian_individu', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(now()); // Otomatis terisi tanggal saat data dibuat
            $table->date('penilaian_bulan');

            $table->string('nik_atasan'); // Relasi ke NIK di tabel pegawai
            $table->string('nama_atasan'); 
            $table->string('nik_bawahan'); // Relasi ke NIK di tabel pegawai
            $table->string('nama_bawahan'); 
            $table->string('departemen');

            $table->integer('kepatuhan');
            $table->integer('kepatuhan_persentase')->nullable();
            $table->integer('keaktifan');
            $table->integer('keaktifan_persentase')->nullable();
            $table->integer('budaya_kerja');
            $table->integer('budaya_kerja_persentase')->nullable();
            $table->integer('kajian');
            $table->integer('kajian_persentase')->nullable();
            $table->integer('kegiatan_rs');
            $table->integer('kegiatan_rs_persentase')->nullable();
            $table->integer('iht');
            $table->integer('iht_persentase')->nullable();

            $table->integer('total_nilai')->nullable();
            $table->integer('total_persentase')->nullable();

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
        Schema::dropIfExists('penilaian_individu');
    }
}
