<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use App\Models\BerkasPegawai;
use App\Models\JenisBerkas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BerkasPegawaiController extends Controller
{
   public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::select('id', 'nik', 'nama', 'jbtn', 'bidang')->where('stts_aktif','AKTIF')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('berkas_pegawai.edit', $row->nik).'" class="edit btn btn-primary btn-sm"><i class="far fa-edit"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
         $title = 'Berkas Pegawai';
        return view('berkas_pegawai.index', compact('title')); // Ganti dengan nama view Anda
    }
    
    public function edit($nik)
    {
        $title = 'Edit Berkas Pegawai';
        $Pegawai = Pegawai::where('nik', $nik)->firstOrFail();
        $berkasPegawai = BerkasPegawai::where('nik_pegawai', $nik)->get();
        $jenisBerkas = JenisBerkas::where('bidang', 'LIKE', '%' . $Pegawai->bidang . '%')->get();
        
        return view('berkas_pegawai.edit', compact('berkasPegawai', 'jenisBerkas','title', 'Pegawai'));
    }
    
    public function update(Request $request, $nik)
    {
        $pegawai = Pegawai::where('nik', $nik)->firstOrFail();
        $files = $request->file('file');
    
        foreach ($request->input('nomor_berkas', []) as $jenisId => $nomorBerkas) {
            $berkas = BerkasPegawai::firstOrNew([
                'nik_pegawai' => $nik,
                'id_jenis_berkas' => $jenisId,
            ]);
    
            $berkas->nomor_berkas = $nomorBerkas;
            $berkas->status_berkas = $request->input("status_berkas.$jenisId");
    
            if (isset($files[$jenisId])) {
                // Menentukan nama file baru
                $originalName = $files[$jenisId]->getClientOriginalName();
                $extension = $files[$jenisId]->getClientOriginalExtension();
                $newFileName = $nik . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
    
                // Menyimpan file dengan nama baru
                $path = $files[$jenisId]->storeAs('berkas_pegawai', $newFileName, 'public/uploads');
                $berkas->file = $path;
            }
    
            $berkas->save();
        }
    
        return redirect()->route('berkas_pegawai.index')->with('success', 'Berkas berhasil diperbarui.');
    }
    
}
