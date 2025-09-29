<?php

// app/Http/Controllers/Api/BookingOperasiController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingOperasi;

class BookingOperasiController extends Controller
{
    public function index()
    {
        $data = BookingOperasi::all();
        return response()->json([
            'success' => true,
            'message' => 'List Booking Operasi',
            'data' => $data,
        ]);
    }
}