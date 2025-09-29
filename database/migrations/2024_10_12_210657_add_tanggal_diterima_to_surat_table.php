<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalDiterimaToSuratTable extends Migration
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
            $table->dateTime('tanggal_surat_diterima')->after('tanggal_surat')->nullable(); // Menambahkan kolom instansi setelah file_lampiran

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
            $table->dropColumn('tanggal_surat_diterima'); // Menghapus kolom instansi jika migration di-rollback
        });
    }
}
