<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsPenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::connection('mysql')->create('items_penilaian', function (Blueprint $table) {
        $table->id();
        $table->string('nama_item');
        $table->integer('bobot_nilai');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('items_penilaian');
    }
}