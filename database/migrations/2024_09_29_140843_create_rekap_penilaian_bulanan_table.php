<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPenilaianBulananTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('rekap_penilaian_bulanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id'); // Relasi ke tabel pegawai di koneksi kedua
            $table->string('bulan', 7); // Bulan penilaian dalam format 'YYYY-MM'
            $table->integer('total_nilai_bulanan')->nullable(); // Total nilai bulanan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekap_penilaian_bulanan');
    }
}