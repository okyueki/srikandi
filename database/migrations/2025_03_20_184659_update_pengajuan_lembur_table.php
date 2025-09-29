<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePengajuanLemburTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuan_lembur', function (Blueprint $table) {
            // Tambahkan kolom tanggal_awal dan tanggal_akhir baru
            $table->date('tanggal_awal')->after('tanggal_lembur')->nullable();
            $table->date('tanggal_akhir')->after('tanggal_awal')->nullable();
        });

        // Pindahkan data dari tanggal_lembur ke tanggal_awal
        DB::statement('UPDATE pengajuan_lembur SET tanggal_awal = tanggal_lembur');

        // Hapus kolom tanggal_lembur setelah datanya dipindahkan
        Schema::table('pengajuan_lembur', function (Blueprint $table) {
            $table->dropColumn('tanggal_lembur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_lembur', function (Blueprint $table) {
            // Tambahkan kembali tanggal_lembur
            $table->date('tanggal_lembur')->after('tanggal_awal')->nullable();
        });

        // Pindahkan data dari tanggal_awal kembali ke tanggal_lembur
        DB::statement('UPDATE pengajuan_lembur SET tanggal_lembur = tanggal_awal');

        // Hapus tanggal_awal dan tanggal_akhir
        Schema::table('pengajuan_lembur', function (Blueprint $table) {
            $table->dropColumn('tanggal_awal');
            $table->dropColumn('tanggal_akhir');
        });
    }
}
