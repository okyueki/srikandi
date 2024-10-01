<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketStatusHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->enum('status', ['open', 'in progress', 'in review', 'close', 'pending', 'di jadwalkan']);
            $table->timestamp('changed_at')->useCurrent(); // Waktu status berubah
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_status_history');
    }
}