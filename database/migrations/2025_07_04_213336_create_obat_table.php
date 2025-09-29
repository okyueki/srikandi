<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id('id_obat'); // Pakai sebagai primary key
            $table->string('no_rawat');
            $table->string('nama_obat')->nullable();
            $table->string('dosis')->nullable();
            $table->string('cara_pakai')->nullable();
            $table->string('frekuensi')->nullable();
            $table->string('fungsi_obat')->nullable();
            $table->string('dosis_terakhir')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obat');
    }
};
