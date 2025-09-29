<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveHariFromJadwalBudayaKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('jadwal_budaya_kerja', function (Blueprint $table) {
            $table->dropColumn('hari');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jadwal_budaya_kerja', function (Blueprint $table) {
            $table->string('hari', 10)->nullable();
        });
    }
}
