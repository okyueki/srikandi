<?php
namespace App\Http\Controllers;

use App\Models\PengajuanLibur;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Cuti';
        $nik=Auth::user()->username;
        if ($request->ajax()) {
            $data = PengajuanLibur::with('pegawai')->where('nik', $nik)->where('jenis_pengajuan_libur', '!=', 'Ijin')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('action', function($row){
                    if ($row->status == 'Dikirim') {
                    $btn = '
                        <a href="'.route('cuti.edit', $row->id_pengajuan_libur).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                        <form action="'.route('cuti.destroy', $row->id_pengajuan_libur).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger waves-effect waves-light delete-confirm"><i class="far fa-trash-alt"></i></button>
                        </form>';
                    }else{
                        $btn = '<a href="'.route('pengajuan_libur.show', encrypt($row->kode_pengajuan_libur)).'" class="btn btn-primary waves-effect waves-light"><i class="fas fa-eye"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('cuti.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create Cuti';
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        return view('cuti.create', compact('title','pegawai'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_pengajuan_libur' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'jumlah_hari' => 'required|integer|min:1',
            'nik_atasan_langsung' => 'required',
            'keterangan' => 'required',
            'tanggal_dibuat' => Carbon::now(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            // Add `nik` as the username of the currently authenticated user
            $request->merge(['nik' => Auth::user()->username]);

        $pengajuanLibur = PengajuanLibur::create($request->all());

        return redirect()->route('cuti.index')->with('success', 'Cuti created successfully.');
    }

    public function edit($id)
    {
        $title = 'Edit Cuti';
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        $cuti = PengajuanLibur::findOrFail($id);
        return view('cuti.edit', compact('cuti','title','pegawai'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_pengajuan_libur' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'jumlah_hari' => 'required|integer|min:1',
            'nik_atasan_langsung' => 'required',
            'keterangan' => 'required',
        ]);

        $cuti = PengajuanLibur::findOrFail($id);
        $cuti->update($request->all());

        return redirect()->route('cuti.index')->with('success', 'Cuti updated successfully.');
    }

    public function destroy($id)
    {
        PengajuanLibur::findOrFail($id)->delete();
        return redirect()->route('cuti.index')->with('success', 'Cuti deleted successfully.');
    }
}
