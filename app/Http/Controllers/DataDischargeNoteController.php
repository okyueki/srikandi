<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsuhanPascaRanap;
use App\Models\Tindakan;
use App\Models\KamarInap;
use App\Models\Obat;
use Yajra\DataTables\DataTables;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class DataDischargeNoteController extends Controller
{
        public function index(Request $request)
        {
            $title = 'Data Discharge Note';
            if ($request->ajax()) {
                $data = AsuhanPascaRanap::with(['regPeriksa.pasien', 'dokter', 'kamarInap.kamar.bangsal'])->select('asuhan_pasca_ranap.*');
    
                return DataTables::of($data)
                    ->addColumn('nama_pasien', function ($row) {
                    return optional(optional($row->regPeriksa)->pasien)->nm_pasien ?? '-';
                })
                ->addColumn('nm_bangsal', function ($row) {
                    return optional(optional(optional($row->kamarInap)->kamar)->bangsal)->nm_bangsal ?? '-';
                })
               
                    ->addColumn('action', function ($row) {
                        return '<a href="' . route('datadischargenote.show', $row->id) . '" class="btn btn-sm btn-primary">Lihat</a>
                        <a href="' . route('datadischargenote.pdf', $row->id) . '" class="btn btn-sm btn-success">PDF</a>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
    
            return view('pages.datadischargenote', compact('title'));
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
        
        public function generatePDF($id)
        {
            $asuhan = AsuhanPascaRanap::with([
                'regPeriksa.pasien',
                'dokter',
                'tindakan',
                'obat'
            ])->findOrFail($id);
        
            $kamarinap = KamarInap::with('kamar.bangsal')
                ->where('no_rawat', $asuhan->no_rawat)
                ->first();
        
            // load view Blade
            $pdf = PDF::loadView('pages.dischargenote-show', compact('asuhan','kamarinap'))
                ->setOption('enable-javascript', true)       // biar JS jalan
                ->setOption('no-stop-slow-scripts', true)   // cegah error script
                ->setOption('encoding', 'utf-8')
                ->setOption('margin-top', 10)
                ->setOption('margin-bottom', 10)
                ->setOption('margin-left', 10)
                ->setOption('margin-right', 10);
        
            // tampil di browser (stream)
            return $pdf->inline("Discharge_Note_{$asuhan->no_rawat}.pdf");
            
            // kalau mau langsung download:
            // return $pdf->download("Discharge_Note_{$asuhan->no_rawat}.pdf");
        }
}
