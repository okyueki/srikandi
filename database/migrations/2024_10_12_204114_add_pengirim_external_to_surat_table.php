<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPengirimExternalToSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat', function (Blueprint $table) {
            //
            $table->string('pengirim_external', 100)->after('nik_pengirim')->nullable(); // Menambahkan kolom instansi setelah file_lampiran
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat', function (Blueprint $table) {
            //
            $table->dropColumn('instansi'); // Menghapus kolom instansi jika migration di-rollback
        });
    }
}
