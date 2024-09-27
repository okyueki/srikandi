<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanLemburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_lembur', function (Blueprint $table) {
            $table->bigIncrements('id_pengajuan_lembur',5);
            $table->string('kode_pengajuan_lembur', 11);
            $table->string('nik', 20);
            $table->text('keterangan');
            $table->date('tanggal_lembur');
            $table->time('jam_awal');
            $table->time('jam_akhir');
            $table->string('nik_atasan_langsung', 20);
            $table->enum('status', ['Dikirim', 'Disetujui', 'Ditolak'])->default('Dikirim');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_dibuat')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('tanggal_verifikasi')->nullable();
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
        Schema::dropIfExists('pengajuan_lembur');
    }
}
