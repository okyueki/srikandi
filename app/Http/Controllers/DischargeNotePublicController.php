<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsuhanPascaRanap;
use App\Models\Tindakan;
use App\Models\KamarInap;
use App\Models\Obat;
use Yajra\DataTables\DataTables;

class DischargeNotePublicController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AsuhanPascaRanap::with(['regPeriksa.pasien', 'dokter'])->select('asuhan_pasca_ranap.*');

            return DataTables::of($data)
                ->addColumn('nama_pasien', function ($row) {
    return optional(optional($row->regPeriksa)->pasien)->nm_pasien ?? '-';
})
                ->addColumn('dokter', function ($row) {
                    return optional($row->dokter)->nm_dokter;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('dischargenotepublic.show', $row->id) . '" class="btn btn-sm btn-primary">Lihat</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.dischargenotepublic');
    }
    
    public function show($id)
    {
        
        $asuhan = AsuhanPascaRanap::with([
            'regPeriksa.pasien',
            'dokter',
            'obat' => function ($q) {
                $q->orderBy('id_obat');
            },
            'tindakan'
        ])->findOrFail($id);
        $kamarinap = KamarInap::where('stts_pulang', '-')->where('no_rawat', $asuhan->no_rawat)->with(['kamar.bangsal'])->first();
        return view('pages.dischargenote-show', compact('asuhan','kamarinap'));
    }
}
