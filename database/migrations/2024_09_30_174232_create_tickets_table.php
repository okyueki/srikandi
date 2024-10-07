<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket')->unique(); // Nomor tiket nanti akan di generate di model
            $table->string('nik');
            $table->string('no_inventaris')->nullable(); // Relasi ke inventaris
            $table->dateTime('tanggal');
            $table->unsignedBigInteger('jenis_permintaan');
            $table->enum('prioritas', ['low', 'medium', 'high']);
            $table->enum('status', ['open', 'in progress', 'in review', 'close', 'pending', 'di jadwalkan']);
            $table->dateTime('deadline')->nullable();
            $table->text('judul');
            $table->longText('deskripsi');
            $table->string('upload')->nullable();
            $table->string('departemen');
            $table->string('nik_teknisi')->nullable();
            $table->string('no_hp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mysql')->dropIfExists('tickets');
    }
}