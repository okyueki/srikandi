<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLembur;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QRCode

class VerifikasiPengajuanLemburController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Verifikasi Pengajuan Lembur';
        $nik_atasan_langsung=Auth::user()->username;
        //echo $nik_atasan_langsung;
        if ($request->ajax()) {
            $data = PengajuanLembur::with('pegawai2')->where('nik_atasan_langsung', $nik_atasan_langsung)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('tanggal_lembur', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->tanggal_awal.' - '.$row->tanggal_akhir;
                })
                ->addColumn('action', function($row){
                    if ($row->status == 'Dikirim') {
                        $btn = '<a href="'.route('verifikasi_pengajuan_lembur.detail', $row->id_pengajuan_lembur).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>';
                    } else {
                        $btn = '<a href="'.route('pengajuan_lembur.show', encrypt($row->kode_pengajuan_lembur)).'" class="btn btn-primary waves-effect waves-light"><i class="fas fa-eye"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('verifikasi_pengajuan_lembur.index', compact('title'));
    }

    public function detail($id)
    {
        $title = 'Detail Verifikasi Pengajuan Lembur';
        $pengajuanlembur = PengajuanLembur::with(['pegawai', 'pegawai2'])->findOrFail($id);        
        $pdfUrl = route('pengajuan-lembur.pdf', ['kode_pengajuan_lembur' => encrypt($pengajuanlembur->kode_pengajuan_lembur)]);
        return view('verifikasi_pengajuan_lembur.detail', compact('pengajuanlembur','title','pdfUrl'));
    }

    public function update(Request $request,$id)
    {
            // Validate the request data
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'catatan' => 'required',
            // Remove 'tanggal_verifikasi' from validation rules
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the record by ID
        $cuti = pengajuanlembur::findOrFail($id);

        // Update the record with request data
        $cuti->status = $request->input('status');
        $cuti->catatan = $request->input('catatan');
        $cuti->tanggal_verifikasi = Carbon::now(); // Set the current datetime

        // Save the updated record
        $cuti->save();

        return redirect()->route('verifikasi_pengajuan_lembur.index')->with('success', 'Cuti updated successfully.');
    }
}
