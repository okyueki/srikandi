<?php

namespace App\Providers;

use App\Models\Pegawai;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Tidak memaksa HTTPS di production jika tidak diperlukan
        // if (config('app.env') === 'production') {
        //     $this->app['request']->server->set('HTTPS', true);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Pastikan Laravel menggunakan timezone & locale yang benar
        Carbon::setLocale('id');

    //     // Paksa HTTPS jika dikonfigurasi
    //       if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    //     URL::forceScheme('https');
    // } else {
    //     URL::forceScheme('http');
    // }

        // Set variabel namaPegawai untuk semua view
        View::composer('*', function ($view) {
            $namaPegawai = 'Guest';

            if (Auth::check()) {
                $user = Auth::user();
                $pegawai = Pegawai::where('nik', $user->username ?? '')->first();
                $namaPegawai = $pegawai ? $pegawai->nama : 'Guest';
            }

            $view->with('namaPegawai', $namaPegawai);
        });
    }
}
