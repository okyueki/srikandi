<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianHarianTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('penilaian_harian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id'); // Relasi ke tabel pegawai di koneksi kedua
            $table->date('tanggal_penilaian'); // Tanggal penilaian dilakukan
            $table->enum('waktu_penilaian', ['pagi', 'sore']); // Pagi atau sore
            $table->integer('total_nilai')->nullable(); // Total nilai dari penilaian pada waktu tersebut
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_harian');
    }
}