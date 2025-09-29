<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_berkas', function (Blueprint $table) {
            $table->bigIncrements('id_jenis_berkas',5);
            $table->string('jenis_berkas', 100);
            $table->text('bidang')->nullable();
            $table->enum('masa_berlaku', ['Iya', 'Tidak'])->default('Iya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenis_berkas');
    }
}
