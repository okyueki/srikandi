<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTandaTanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanda_tangan', function (Blueprint $table) {
            $table->id('id_tanda_tangan'); // ID tanda tangan
            $table->unsignedBigInteger('id_surat'); // Foreign key ke tabel surat
            $table->string('nik_penandatangan'); // NIK penandatangan
            $table->string('status_ttd'); // Status penandatangan (Utama/Tambahan)
            $table->timestamps();

            // Menambahkan foreign key
            $table->foreign('id_surat')->references('id_surat')->on('surat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanda_tangan');
    }
}
