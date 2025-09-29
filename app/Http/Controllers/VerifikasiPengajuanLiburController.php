<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLibur;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QRCode

class VerifikasiPengajuanLiburController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Verifikasi Pengajuan Libur';
        $nik_atasan_langsung=Auth::user()->username;
        //echo $nik_atasan_langsung;
        if ($request->ajax()) {
            $data = PengajuanLibur::with('pegawai2')->where('nik_atasan_langsung', $nik_atasan_langsung)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('action', function($row){
                    if ($row->status == 'Dikirim') {
                        $btn = '<a href="'.route('verifikasi_pengajuan_libur.detail', $row->id_pengajuan_libur).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                             <form action="'.route('verifikasi_pengajuan_libur.destroy', $row->id_pengajuan_libur).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger waves-effect waves-light delete-confirm"><i class="far fa-trash-alt"></i></button>
                        </form>';
                    } else {
                        $btn = '<a href="'.route('pengajuan_libur.show', encrypt($row->kode_pengajuan_libur)).'" class="btn btn-primary waves-effect waves-light"><i class="fas fa-eye"></i></a>
                        <form action="'.route('verifikasi_pengajuan_libur.destroy', $row->id_pengajuan_libur).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger waves-effect waves-light delete-confirm"><i class="far fa-trash-alt"></i></button>
                        </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('verifikasi_pengajuan_libur.index', compact('title'));
    }

    public function detail($id)
    {
        $title = 'Detail Verifikasi Pengajuan Libur';
        $pengajuanlibur = PengajuanLibur::with(['pegawai', 'pegawai2'])->findOrFail($id);

        if ($pengajuanlibur->jenis_pengajuan_libur == 'Ijin'){
            $pdfUrl = route('pengajuan-libur-ijin.pdf', ['kode_pengajuan_libur' => encrypt($pengajuanlibur->kode_pengajuan_libur)]);
        }else{
            $pdfUrl = route('pengajuan-libur-cuti.pdf', ['kode_pengajuan_libur' => encrypt($pengajuanlibur->kode_pengajuan_libur)]);
        }
        return view('verifikasi_pengajuan_libur.detail', compact('pengajuanlibur','title','pdfUrl'));
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
        $cuti = PengajuanLibur::findOrFail($id);

        // Update the record with request data
        $cuti->status = $request->input('status');
        $cuti->catatan = $request->input('catatan');
        $cuti->tanggal_verifikasi = Carbon::now(); // Set the current datetime

        // Save the updated record
        $cuti->save();

        return redirect()->route('verifikasi_pengajuan_libur.index')->with('success', 'Cuti updated successfully.');
    }
    
    public function destroy($id)
    {
        PengajuanLibur::findOrFail($id)->delete();
        return redirect()->route('verifikasi_pengajuan_libur.index')->with('success', 'Cuti deleted successfully.');
    }
}
