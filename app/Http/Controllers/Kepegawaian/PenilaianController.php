<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\PenilaianHarian;
use App\Models\DetailPenilaian;
use App\Models\ItemPenilaian;
use App\Models\Pegawai;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Exports\PenilaianExport;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = PenilaianHarian::with(['detailPenilaian.itemPenilaian', 'pegawai']); // Tambahkan relasi ke pegawai

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_penilaian', [$request->start_date, $request->end_date]);
        }

        // Kembalikan data dalam format DataTables
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nama', function($row) {
                return $row->pegawai->nama ?? 'Tidak diketahui';
            })
            ->addColumn('departemen', function($row) {
                return $row->pegawai->departemen ?? 'Tidak diketahui';
            })
            ->addColumn('detail_penilaian', function($row) {
                return $row->detailPenilaian->map(function($detail) {
                    return $detail->nilai ? 'Ya' : 'Tidak';
                })->implode(', ');
            })
            ->addColumn('total_nilai', function($row) {
                return $row->total_nilai;
            })
            ->addColumn('action', function($row) {
                return '<a href="'.route('penilaian.show', $row->id).'" class="btn btn-info btn-sm">Lihat</a>';
            })
            ->rawColumns(['action']) // Agar kolom action bisa memuat HTML
            ->make(true);
    }

    return view('budayakerja.penilaian_index')->with('pageTitle', 'Penilaian Harian');
}

    public function create()
    {
        // Mengambil data pegawai dari koneksi sik3
        $pegawai = Pegawai::all(); // Pegawai sudah diatur dengan koneksi sik3 di model
        $items = ItemPenilaian::all();
        return view('budayakerja.penilaian_create', compact('pegawai', 'items'));
    }

    public function store(Request $request)
{
    $request->validate([
        'pegawai_id' => 'required|exists:server_74.pegawai,id',
        'tanggal_penilaian' => 'required|date',
        'waktu_penilaian' => 'required|in:pagi,sore',
        'item_penilaian' => 'required|array',
        'item_penilaian.*' => 'in:0,1',
    ]);

    // Check if the pegawai has already been evaluated on the same date
    $existingPenilaian = PenilaianHarian::where('pegawai_id', $request->pegawai_id)
        ->where('tanggal_penilaian', $request->tanggal_penilaian)
        ->first();

    if ($existingPenilaian) {
        return redirect()->back()->withErrors(['pegawai_id' => 'Pegawai sudah dinilai pada tanggal tersebut.']);
    }

    // Proceed to create the penilaian if no existing record is found
    $penilaian = PenilaianHarian::create([
        'pegawai_id' => $request->pegawai_id,
        'tanggal_penilaian' => $request->tanggal_penilaian,
        'waktu_penilaian' => $request->waktu_penilaian,
    ]);

    $totalNilai = 0;

    foreach ($request->item_penilaian as $itemId => $nilai) {
        $item = ItemPenilaian::find($itemId);
        if ($item) {
            $totalNilai += $nilai * ($item->bobot_nilai ?? 0);
        }

        DetailPenilaian::create([
            'penilaian_harian_id' => $penilaian->id,
            'item_penilaian_id' => $itemId,
            'nilai' => $nilai,
        ]);
    }

    // Update the total_nilai in PenilaianHarian table
    $penilaian->update(['total_nilai' => $totalNilai]);

    return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan.');
}


    public function show($id)
{
    // Mengambil penilaian harian beserta detail penilaiannya
    $penilaian = PenilaianHarian::with('detailPenilaian.itemPenilaian')->findOrFail($id);

    // Menghitung total nilai
    $totalNilai = $penilaian->detailPenilaian->reduce(function ($carry, $detail) {
    return $carry + ($detail->nilai && $detail->itemPenilaian ? $detail->itemPenilaian->bobot_nilai : 0);
}, 0);

    return view('budayakerja.penilaian_show', compact('penilaian', 'totalNilai'));
}

public function searchPegawai(Request $request)
{
    $query = $request->input('query');
    // Fetch only active employees
    $pegawai = Pegawai::where('stts_aktif', 'AKTIF')
                      ->where('nama', 'LIKE', "%{$query}%")
                      ->get(['id', 'nama', 'departemen', 'jbtn']); // tambahkan departemen dan jbtn
    
    return response()->json($pegawai);
}

public function rekapitulasiBulanan(Request $request)
{
    $penilaians = PenilaianHarian::whereMonth('tanggal_penilaian', '=', now()->subMonth()->month)
                                 ->whereYear('tanggal_penilaian', '=', now()->year)
                                 ->get();

    // Debugging: Tampilkan data penilaian di log atau langsung dengan dd()
    if ($penilaians->isEmpty()) {
        \Log::info('No data found for the previous month.');
        return redirect()->back()->with('error', 'Tidak ada data penilaian harian untuk bulan lalu.');
    }

    foreach ($penilaians as $penilaian) {
        $totalNilai = $penilaian->detailPenilaian->sum('nilai');
        \Log::info('Found Penilaian: ' . $penilaian->id . ' - Total Nilai: ' . $totalNilai);

        RekapPenilaianBulanan::create([
            'pegawai_id' => $penilaian->pegawai_id,
            'bulan' => now()->subMonth()->format('Y-m'),
            'total_nilai' => $totalNilai,
        ]);
    }

    return redirect()->back()->with('success', 'Rekapitulasi bulanan berhasil dilakukan.');
}

public function export()
{

    return Excel::download(new PenilaianExport, 'penilaian.xlsx');
}
}