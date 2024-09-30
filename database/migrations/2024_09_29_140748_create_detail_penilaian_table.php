<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenilaianTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('detail_penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_harian_id'); // Relasi ke penilaian harian
            $table->unsignedBigInteger('item_penilaian_id'); // Relasi ke item penilaian
            $table->boolean('nilai')->default(0); // Nilai untuk item penilaian
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_penilaian');
    }
}
