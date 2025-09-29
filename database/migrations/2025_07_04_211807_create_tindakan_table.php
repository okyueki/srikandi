<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tindakan', function (Blueprint $table) {
            $table->id('id_tindakan'); // Pakai sebagai primary key
            $table->string('no_rawat');
            $table->text('tindakan')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tindakan');
    }
};
