<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\KlasifikasiSurat;
use App\Models\VerifikasiSurat;
use App\Models\SifatSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor; // Tambahkan ini untuk menggunakan TemplateProcessor
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $title = 'Data Surat';
        $nik=Auth::user()->username;
        if (request()->ajax()) {
            $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
                ->where('nik_pengirim', $nik)
                ->get();
    
            return DataTables::of($surat)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function ($row) {
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('action', function ($row) {
                    return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_keluar.edit', $row->id_surat).'"><i class="far fa-edit"></i></a> ' .
                           '<form action="'.route('surat_keluar.destroy', $row->id_surat).'" method="POST" style="display:inline;">' .
                           '<input type="hidden" name="_token" value="'.csrf_token().'">' .
                           '<input type="hidden" name="_method" value="DELETE">' .
                           '<button type="submit" class="btn btn-danger waves-effect waves-light deletesurat"><i class="far fa-trash-alt"></i></button></form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('surat_keluar.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create Surat Keluar';
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        return view('surat_keluar.create', compact('title','klasifikasiSurat','sifatSurat','pegawai'));
    }

    public function store(Request $request)
    {
        $nik = Auth::user()->username;
    $request->validate([
        'id_klasifikasi_surat' => 'required',
        'id_sifat_surat' => 'required',
        'perihal' => 'required',
        'tanggal_surat' => 'required|date',
        'lampiran' => 'required|integer',
        'file_surat' => 'required|file|mimes:docx', // Mengharuskan upload file .docx
        'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
    ]);

    // Generate kode_surat dan nomor_surat
    $kodeSurat = 'SRT-' . date('Ymd') . '-' . strtoupper(Str::random(5));

    // Ambil surat terakhir dan hitung nomor surat berikutnya
    $lastSurat = Surat::orderBy('nomor_surat', 'desc')->first();
    $nomorSurat = $lastSurat ? intval($lastSurat->nomor_surat) + 1 : 1;

    // Ambil klasifikasi surat untuk mendapatkan kode klasifikasi
    $klasifikasi = KlasifikasiSurat::find($request->id_klasifikasi_surat);

    // Format nomor surat
    $tahun = date('Y', strtotime($request->tanggal_surat)); // Mengambil tahun dari tanggal_surat
    $fullNomorSurat = "RS'ASF/" . $nomorSurat . "/" . $klasifikasi->kode_klasifikasi_surat . "/" . $tahun;

    // Menyimpan data surat ke database
    $surat = Surat::create([
        'id_klasifikasi_surat' => $request->id_klasifikasi_surat,
        'id_sifat_surat' => $request->id_sifat_surat,
        'nik_pengirim' => $nik,
        'perihal' => $request->perihal,
        'tanggal_surat' => $request->tanggal_surat,
        'lampiran' => $request->lampiran,
        'kode_surat' => $kodeSurat,
        'nomor_surat' => $fullNomorSurat, // Nomor surat otomatis
    ]);

    // Menyimpan file_surat yang diupload ke direktori
    $fileSurat = $request->file('file_surat');
    $fileSuratPath = $fileSurat->store('uploads/surat', 'public'); // Menyimpan file di public/uploads/surat
    $surat->file_surat = $fileSuratPath;
    $surat->save();

    // Handle lampiran jika ada
    if ($request->hasFile('file_lampiran')) {
        $lampiranPath = $request->file('file_lampiran')->store('uploads/lampiran', 'public');
        $surat->file_lampiran = $lampiranPath;
        $surat->save();
    }

    // Insert data ke tabel verifikasi_surat
    VerifikasiSurat::create([
        'id_surat' => $surat->id_surat,
        'nik_verifikator' => $request->nik_atasan_langsung, // Mengambil nik atasan langsung dari form
        'status_surat' => 'Dikirim', // Status awal
        'tanggal_verifikasi' => null, // Verifikasi belum dilakukan
        'catatan' => null, // Catatan kosong pada awalnya
    ]);

    return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Surat Keluar';
        $surat = Surat::findOrFail($id); // Mengambil data surat berdasarkan ID
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $verifikasiSurat = VerifikasiSurat::where('id_surat', $id)->first();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        return view('surat_keluar.edit', compact('title', 'surat', 'klasifikasiSurat', 'sifatSurat', 'pegawai','verifikasiSurat'));
    }

    public function update(Request $request, $id)
    {
        $nik = Auth::user()->username;
        $request->validate([
            'id_klasifikasi_surat' => 'required',
            'id_sifat_surat' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'lampiran' => 'required|integer',
            'file_surat' => 'nullable|file|mimes:docx', // Bisa nullable karena mungkin tidak ingin mengubah file surat
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
    
        // Cari surat berdasarkan id yang diterima
        $surat = Surat::findOrFail($id);
    
        // Ambil klasifikasi surat untuk mendapatkan kode klasifikasi
        $klasifikasi = KlasifikasiSurat::find($request->id_klasifikasi_surat);
    
        // Update nomor surat jika diperlukan (misalnya klasifikasi atau tanggal berubah)
        $nomorSurat = $surat->nomor_surat;
        if ($request->id_klasifikasi_surat != $surat->id_klasifikasi_surat || $request->tanggal_surat != $surat->tanggal_surat) {
            $tahun = date('Y', strtotime($request->tanggal_surat)); // Ambil tahun dari tanggal_surat
            $nomorSurat = "RS'ASF/" . $surat->nomor_surat . "/" . $klasifikasi->kode_klasifikasi_surat . "/" . $tahun;
        }
    
        // Update data surat
        $surat->update([
            'id_klasifikasi_surat' => $request->id_klasifikasi_surat,
            'id_sifat_surat' => $request->id_sifat_surat,
            'nik_pengirim' => $nik,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran' => $request->lampiran,
            'nomor_surat' => $nomorSurat, // Update nomor surat jika berubah
        ]);
    
        // Jika file_surat di-upload, simpan file baru dan hapus file lama
        if ($request->hasFile('file_surat')) {
            // Hapus file surat lama jika ada
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }
    
            // Simpan file surat baru
            $fileSurat = $request->file('file_surat');
            $fileSuratPath = $fileSurat->store('uploads/surat', 'public'); // Simpan file di public/uploads/surat
            $surat->file_surat = $fileSuratPath;
            $surat->save();
        }
    
        // Jika file_lampiran di-upload, simpan file baru dan hapus file lama
        if ($request->hasFile('file_lampiran')) {
            // Hapus file lampiran lama jika ada
            if ($surat->file_lampiran) {
                Storage::disk('public')->delete($surat->file_lampiran);
            }
    
            // Simpan file lampiran baru
            $fileLampiran = $request->file('file_lampiran');
            $lampiranPath = $fileLampiran->store('uploads/lampiran', 'public');
            $surat->file_lampiran = $lampiranPath;
            $surat->save();
        }
    
        // Update status di tabel verifikasi_surat jika diperlukan
        $verifikasiSurat = VerifikasiSurat::where('id_surat', $surat->id_surat)->first();
        if ($verifikasiSurat) {
            $verifikasiSurat->update([
                'nik_verifikator' => $request->nik_atasan_langsung, // Perbarui nik verifikator jika ada perubahan
                'status_surat' => 'Diperbarui', // Atur status menjadi 'Diperbarui'
                'catatan' => $request->catatan, // Tambahkan catatan jika ada
            ]);
        }
    
        return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari surat berdasarkan id yang diterima
    $surat = Surat::findOrFail($id);

    // Hapus file surat dari storage jika ada
    if ($surat->file_surat) {
        Storage::disk('public')->delete($surat->file_surat);
    }

    // Hapus file lampiran dari storage jika ada
    if ($surat->file_lampiran) {
        Storage::disk('public')->delete($surat->file_lampiran);
    }

    // Hapus verifikasi surat terkait
    VerifikasiSurat::where('id_surat', $surat->id_surat)->delete();

    // Hapus surat dari database
    $surat->delete();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('surat_keluar.index')->with('success', 'Surat berhasil dihapus.');
    }
}
