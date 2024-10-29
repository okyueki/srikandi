<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTeknisiTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_teknisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade'); // Relasi ke tiket
            $table->string('teknisi_id'); // Relasi ke teknisi
            $table->timestamps(); // Waktu teknisi mulai menangani tiket
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_teknisi');
    }
}