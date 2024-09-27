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
use Illuminate\Support\Facades\Log;

class IjinController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Ijin';
        $nik=Auth::user()->username;
        if ($request->ajax()) {
            $data = PengajuanLibur::with('pegawai')
            ->where('nik', $nik)
            ->where('jenis_pengajuan_libur', 'Ijin')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('action', function($row){
                    if ($row->status == 'Dikirim') {
                    $btn = '
                        <a href="'.route('ijin.edit', $row->id_pengajuan_libur).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                        <form action="'.route('ijin.destroy', $row->id_pengajuan_libur).'" method="POST" style="display:inline;">
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
    
        return view('ijin.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create Ijin';
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        return view('ijin.create', compact('title','pegawai'));
    }

    public function store(Request $request)
    {
    $request->merge(['nik' => Auth::user()->username]);

    $request->validate([
        'tanggal_awal' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        'keterangan' => 'required|string|max:255',
        'nik_atasan_langsung' => 'required',
        'file' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        'tanggal_dibuat' => 'nullable|date',
    ]);

    // Simpan file yang diunggah jika ada
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/ijin_files', $fileName, 'public');
    }

    // Simpan data form beserta path file
    PengajuanLibur::create([
        'jenis_pengajuan_libur' => 'Ijin',
        'nik' => Auth::user()->username,
        'tanggal_awal' => $request->tanggal_awal,
        'tanggal_akhir' => $request->tanggal_akhir,
        'jumlah_hari' => $request->jumlah_hari,
        'keterangan' => $request->keterangan,
        'nik_atasan_langsung' => $request->nik_atasan_langsung,
        'foto' => $filePath ?? null, // Path file
        'tanggal_dibuat' => Carbon::now(),
    ]);

    
        return redirect()->route('ijin.index')->with('success', 'Pengajuan Ijin berhasil disimpan.');
    }

    public function edit($id)
    {
        $title = 'Edit ijin';
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        $pengajuanLibur = PengajuanLibur::findOrFail($id);
        return view('ijin.edit', compact('pengajuanLibur', 'pegawai','title'));
    }

    public function update(Request $request, $id)
    {
         // Validasi input
    $request->validate([
        'tanggal_awal' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        'keterangan' => 'required|string|max:255',
        'nik_atasan_langsung' => 'required',
        'file' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048', // File validasi
    ]);

    // Temukan data pengajuan libur berdasarkan ID
    $pengajuanLibur = PengajuanLibur::findOrFail($id);

    // Simpan file yang baru diunggah (jika ada)
    if ($request->hasFile('file')) {
        // Hapus file lama jika ada
        if ($pengajuanLibur->foto && Storage::exists('public/' . $pengajuanLibur->foto)) {
            Storage::delete('public/' . $pengajuanLibur->foto);
        }

        // Simpan file baru
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/ijin_files', $fileName, 'public');
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $filePath = $pengajuanLibur->foto;
    }

    // Update data pengajuan libur
    $pengajuanLibur->update([
        'tanggal_awal' => $request->tanggal_awal,
        'tanggal_akhir' => $request->tanggal_akhir,
        'keterangan' => $request->keterangan,
        'nik_atasan_langsung' => $request->nik_atasan_langsung,
        'foto' => $filePath, // Gunakan file path yang baru atau lama
    ]);

    return redirect()->route('ijin.index')->with('success', 'Pengajuan Ijin berhasil diupdate.');    
    }

    public function destroy($id)
    {
        $pengajuanLibur = PengajuanLibur::findOrFail($id);

        // Hapus file yang terkait jika ada
        if ($pengajuanLibur->foto) {
            Storage::disk('public')->delete($pengajuanLibur->foto);
        }
    
        $pengajuanLibur->delete();
    
        return redirect()->route('ijin.index')->with('success', 'Pengajuan Ijin berhasil dihapus.');
    }
}
