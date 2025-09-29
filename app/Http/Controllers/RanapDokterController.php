<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RanapDokter;

class RanapDokterController extends Controller
{
    public function index(Request $request)
{
    $startDate = $request->input('start');
    $endDate   = $request->input('end');

    if (!$startDate) {
        $startDate = now()->startOfMonth()->format('Y-m-d H:i:s');
    } else {
        $startDate = \Carbon\Carbon::parse($startDate)->format('Y-m-d H:i:s');
    }

    if (!$endDate) {
        $endDate = now()->endOfMonth()->format('Y-m-d H:i:s');
    } else {
        $endDate = \Carbon\Carbon::parse($endDate)->format('Y-m-d H:i:s');
    }

    [$dokterList, $pivot] = RanapDokter::getPivotData($startDate, $endDate);

    return view('ranap_dokter.index', compact('pivot', 'startDate', 'endDate'));
}
}
