<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanLiburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_libur', function (Blueprint $table) {
            $table->bigIncrements('id_pengajuan_libur',5);
            $table->string('kode_pengajuan_libur', 11);
            $table->enum('jenis_pengajuan_libur', ['Ijin', 'Tahunan', 'Melahirkan','Ambil Libur', 'Menikah'])->default('Ijin');
            $table->string('nik', 20);
            $table->text('alamat')->nullable();
            $table->text('keterangan');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('jumlah_hari')->unsigned();
            $table->string('nik_atasan_langsung', 20);
            $table->enum('status', ['Dikirim', 'Disetujui', 'Ditolak'])->default('Dikirim');
            $table->text('catatan')->nullable();
            $table->string('foto', 200)->nullable();
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
        Schema::dropIfExists('pengajuan_libur');
    }
}
