<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisPermintaanTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('jenis_permintaan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama_permintaan'); // Nama permintaan, misal: 'IT Support', 'Network Issue', dll.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mysql')->dropIfExists('jenis_permintaan');
    }
}