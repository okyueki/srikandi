<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\KamarInap;
use App\Models\Kamar;
use App\Models\Bangsal;
use Illuminate\Http\Request;

class PemakaianKamarController extends Controller
{
    public function index(Request $request)
    {
        $title = "Pemakaian Kamar";
    
        if ($request->ajax()) {
            $query = KamarInap::with('kamar.bangsal')
                ->whereHas('kamar', function ($q) {
                    $q->where('statusdata', 1);
                });
    
            // Jika user belum isi tanggal, tampilkan data bulan ini
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('tgl_masuk', [$request->start_date, $request->end_date]);
            } else {
                $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
                $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
                $query->whereBetween('tgl_masuk', [$startOfMonth, $endOfMonth]);
            }
    
            $data = $query->get()
                ->filter(function ($item) {
                    return $item->kamar && $item->kamar->bangsal;
                })
                ->groupBy(function ($item) {
                    return $item->kamar->bangsal->nm_bangsal;
                })
                ->map(function ($group, $bangsal) {
                    return [
                        'nm_bangsal' => $bangsal,
                        'jumlah_pasien' => $group->count(),
                    ];
                })
                ->sortByDesc('jumlah_pasien')
                ->values();
    
            return datatables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }
    
        return view('manajemen.pemakaiankamar', compact('title'));
    }
}
