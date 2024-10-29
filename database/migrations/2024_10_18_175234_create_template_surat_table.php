<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_surat', function (Blueprint $table) {
            $table->bigIncrements('id_template_surat'); // Primary key
            $table->string('nama_template',100); // Nama template surat
            $table->text('deskripsi')->nullable(); // Deskripsi tentang template
            $table->string('file_template'); // Path ke file template surat (misalnya .docx)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_surat');
    }
}
