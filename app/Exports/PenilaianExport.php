<?php

namespace App\Exports;

use App\Models\PenilaianHarian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenilaianExport implements FromView
{
    public function view(): View
    {
        // Ambil data yang sama seperti yang digunakan di view index()
        $penilaians = PenilaianHarian::with(['detailPenilaian.itemPenilaian', 'pegawai'])->get();

        return view('exports.penilaian', [
            'penilaians' => $penilaians
        ]);
    }
}
