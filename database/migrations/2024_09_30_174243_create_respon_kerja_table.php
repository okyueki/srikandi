<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponKerjaTable extends Migration
{
    public function up()
    {
        Schema::create('respon_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade'); // Relasi ke tabel tickets
            $table->string('teknisi_id'); 
            
            $table->string('foto_hasil')->nullable(); // Path untuk foto hasil kerja
            $table->text('deskripsi_hasil'); // Penjelasan hasil kerja teknisi
            $table->enum('status_akhir', ['selesai', 'minta bantuan pihak ketiga', 'lanjut ke teknisi lain']); // Status akhir pekerjaan
            $table->decimal('biaya', 15, 2)->nullable(); // Biaya tambahan, jika ada
            $table->enum('tingkat_kesulitan', ['mudah', 'sedang', 'sulit']); // Tingkat kesulitan pekerjaan
            $table->text('petunjuk_penyelesaian')->nullable(); // Petunjuk atau solusi yang diberikan teknisi

            $table->timestamps(); // Menyimpan created_at dan updated_at untuk mencatat waktu respon dan penyelesaian
        });
    }

    public function down()
    {
        Schema::dropIfExists('respon_kerja');
    }
}
