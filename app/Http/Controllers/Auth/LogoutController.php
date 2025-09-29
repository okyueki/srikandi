<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        Auth::logout();  // Mengeluarkan user

        // Redirect ke halaman login atau halaman lain yang diinginkan
        return redirect('/login')->with('message', 'You have been logged out successfully!');
    }
}