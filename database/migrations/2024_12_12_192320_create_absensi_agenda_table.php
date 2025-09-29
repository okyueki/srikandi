<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_agenda', function (Blueprint $table) {
            $table->bigIncrements('id_absensi_agenda',5);
            $table->string('nik'); // Foreign key for employee
            $table->unsignedBigInteger('agenda_id');  // Foreign key for agenda
            $table->timestamp('waktu_kehadiran')->nullable(); // Time of attendance
            $table->string('token')->unique();
            $table->timestamps();

            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_agenda');
    }
}
