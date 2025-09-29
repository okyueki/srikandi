<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudayaKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('budaya_kerja', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('petugas'); // NIK petugas
            $table->string('nik_pegawai');
            $table->string('nama_pegawai');
            $table->string('departemen');
            $table->string('jabatan');
            $table->string('shift');
            // Item Penilaian
            $table->boolean('sepatu')->default(1);
            $table->boolean('sabuk')->default(1);
            $table->boolean('make_up')->default(1);
            $table->boolean('minyak_wangi')->default(1);
            $table->boolean('jilbab')->default(1);
            $table->boolean('kuku')->default(1);
            $table->boolean('baju')->default(1);
            $table->boolean('celana')->default(1);
            $table->boolean('name_tag')->default(1);
            $table->boolean('perhiasan')->default(1);
            $table->boolean('kaos_kaki')->default(1);
            $table->integer('total_nilai')->default(11); // Total default 11 karena semua item bernilai 1
            $table->timestamps(); // Untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budaya_kerja');
    }
}
