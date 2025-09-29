<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisiSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisi_surat', function (Blueprint $table) {
            $table->id('id_disposisi_surat');
            $table->unsignedBigInteger('id_surat');
            $table->string('nik_disposisi', 20); // NIK pegawai yang mendisposisi
            $table->string('nik_penerima', 20)->nullable(); // NIK pegawai yang menerima disposisi
            $table->enum('status_disposisi', ['Dikirim', 'Dibaca', 'Ditindaklanjuti', 'Selesai'])->default('Dikirim');
            $table->dateTime('tanggal_disposisi')->nullable();
            $table->text('catatan_disposisi')->nullable();
            $table->timestamps();

            // Foreign keys
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
        Schema::dropIfExists('disposisi_surat');
    }
}
