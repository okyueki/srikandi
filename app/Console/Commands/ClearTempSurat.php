<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearTempSurat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:temp_surat:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus seluruh isi folder storage/app/public/temp_surat';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $directory = 'public/temp_surat'; // Storage Laravel menggunakan relative path untuk disk 'public'

        // Cek apakah direktori ada
        if (Storage::exists($directory)) {
            // Hapus semua file di dalam folder temp_surat
            Storage::deleteDirectory($directory);
            // Membuat kembali direktori agar tetap ada setelah dihapus
            Storage::makeDirectory($directory);

            $this->info('Semua file di folder storage/app/public/temp_surat telah dihapus.');
        } else {
            $this->error('Direktori temp_surat tidak ditemukan.');
        }

        return 0;
    }
}