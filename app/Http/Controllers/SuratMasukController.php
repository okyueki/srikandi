<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pegawai;
use App\Models\KlasifikasiSurat;
use App\Models\VerifikasiSurat;
use App\Models\SifatSurat;
use App\Models\StrukturOrganisasi;
use App\Models\DisposisiSurat;
use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QRCode

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Surat Masuk';
        $nik = Auth::user()->username;
        $level = Auth::user()->level; // Mendapatkan NIK user yang sedang login
        $strukturOrganisasi = StrukturOrganisasi::where('nik', $nik)->first();
    
        if ($request->ajax()) {
            // Mengambil data surat yang sesuai dengan verifikator (nik_verifikator) dan status 'Dikirim'
            $surat = Surat::with(['pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat', 'disposisi'])
                ->whereHas('verifikasi', function($query) use ($nik) {
                    $query->where('nik_verifikator', $nik);
                })
                ->orWhereHas('disposisi', function($query) use ($nik) {
                    $query->where('nik_penerima', $nik);
                })
                ->get();
        
            return DataTables::of($surat)
                ->addIndexColumn() // Menambahkan kolom index
                ->addColumn('nama_pegawai', function ($row) {
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('status_verifikasi', function ($row) {
                    $verifikasi = $row->verifikasi()->orderBy('id_verifikasi_surat', 'DESC')->first();
                    return $verifikasi ? $verifikasi->status_surat : '-';
                })
                ->addColumn('status_disposisi', function ($row) {
                    $disposisi = $row->disposisi()->orderBy('id_disposisi_surat', 'DESC')->first();
                    return $disposisi ? $disposisi->status_disposisi : '-';
                })
                ->addColumn('action', function ($row) use ($strukturOrganisasi, $nik, $level) {
                    // Tombol edit dan lihat surat
                    $verifikasi = $row->verifikasi()->orderBy('id_verifikasi_surat', 'DESC')->first();
                    if ($level != "Koordinator" || $level != "Pelaksana") {
                        // Jika user adalah direktur, tampilkan opsi untuk melakukan disposisi
                        if ($verifikasi && $verifikasi->status_surat == "Disetujui") {
                            return ' <a class="btn btn-primary waves-effect waves-light" href="'.route('surat_masuk.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                        }else{
                            return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_masuk.disposisi', encrypt($row->kode_surat)).'"><i class="far fa-edit"></i></a> '.
                               ' <a class="btn btn-primary waves-effect waves-light" href="'.route('surat_masuk.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                        }
                    } elseif ($row->disposisi && $row->disposisi->nik_penerima == $nik) {
                        // Jika user adalah penerima disposisi, tampilkan opsi untuk menindaklanjuti surat
                        if($row->disposisi && $row->disposisi->status_disposisi == "Ditindaklanjuti" || $row->disposisi && $row->disposisi->status_disposisi == "Selesai"){
                            return  '<a class="btn btn-primary waves-effect waves-light" href="'.route('surat_masuk.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                        }else{
                            return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_masuk.tindaklanjut', encrypt($row->kode_surat)).'"><i class="far fa-edit"></i></a> ' .
                               ' <a class="btn btn-primary waves-effect waves-light" href="'.route('surat_masuk.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                        }
                    } else {
                        // Jika bukan penerima disposisi, cek status verifikasi
                        if ($verifikasi && $verifikasi->status_surat == "Disetujui") {
                            // Jika sudah disetujui, hanya bisa melihat detail surat
                            return '<a class="btn btn-primary waves-effect waves-light" href="'.route('surat_masuk.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                        } else {
                            // Jika belum disetujui, bisa melakukan verifikasi
                            return '<a class="btn btn-info waves-effect waves-light edit" href="'.route('surat_masuk.verifikasi', encrypt($row->kode_surat)).'"><i class="far fa-edit"></i></a> ' .
                                   ' <a class="btn btn-primary waves-effect waves-light" href="'.route('surat_masuk.detail', encrypt($row->kode_surat)).'"><i class="far fa-eye"></i></a>';
                        }
                    }
                })
                ->rawColumns(['action']) // Mengizinkan HTML di kolom action
                ->make(true); // Mengirim response JSON ke DataTables
        }
    
        return view('surat_masuk.index', compact('title')); // Menampilkan view index
    }
    public function create()
    {
        $title = 'Create Surat Masuk';
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        
        return view('surat_masuk.create', compact('title', 'klasifikasiSurat', 'sifatSurat', 'pegawai'));
    }
    public function store(Request $request)
    {
        $nik = Auth::user()->username;
        $kodeSurat = 'SRT-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        $request->validate([
            'id_klasifikasi_surat' => 'required',
            'id_sifat_surat' => 'required',
            'perihal' => 'required',
            'nomor_surat' => 'required',
            'pengirim_external' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_surat_diterima' => 'required|date',
            'lampiran' => 'required',
            'file_surat' => 'required|file|mimes:pdf',
            'file_lampiran' => 'nullable|file|mimes:pdf',
        ]);

        $surat = Surat::create([
            'id_klasifikasi_surat' => $request->id_klasifikasi_surat,
            'id_sifat_surat' => $request->id_sifat_surat,
            'perihal' => $request->perihal,
            'nomor_surat' => $request->nomor_surat,
            'pengirim_external' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran' => $request->lampiran,
            'tanggal_surat_diterima' => $request->tanggal_surat_diterima,
            'kode_surat' => $kodeSurat,
        ]);

        $fileSurat = $request->file('file_surat');
        $fileSuratPath = $fileSurat->store('uploads/surat', 'public');
        $surat->file_surat = $fileSuratPath;
        $surat->save();

        if ($request->hasFile('file_lampiran')) {
            $lampiranPath = $request->file('file_lampiran')->store('uploads/lampiran', 'public');
            $surat->file_lampiran = $lampiranPath;
            $surat->save();
        }
    
        // Retrieve the current verifikasi record or create a new one
        $verifikasi = VerifikasiSurat::updateOrCreate(
            ['id_surat' => $surat->id_surat], // Unique identifier
            [
                'nik_verifikator' => $nik,
                'status_surat' => 'Dikirim', // or whatever the status should be
                'tanggal_verifikasi' => now(), // Current date/time
            ]);

        return redirect()->route('surat_masuk.verifikasi', ['encryptedKodeSurat' => encrypt($surat->kode_surat)])
        ->with('success', 'Surat berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $title = 'Edit Surat Masuk';
        $surat = Surat::findOrFail($id);
        $klasifikasiSurat = KlasifikasiSurat::all();
        $sifatSurat = SifatSurat::all();
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();

        return view('surat_masuk.edit', compact('title', 'surat', 'klasifikasiSurat', 'sifatSurat', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $nik = Auth::user()->username;
        $request->validate([
            'id_klasifikasi_surat' => 'required',
            'id_sifat_surat' => 'required',
            'perihal' => 'required',
            'nomor_surat' => 'required',
            'pengirim_external' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_surat_diterima' => 'required|date',
            'lampiran' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf',
            'file_lampiran' => 'nullable|file|mimes:pdf',
        ]);

        $surat = Surat::findOrFail($id);
        // Update data surat
        $surat->update([
            'id_klasifikasi_surat' => $request->id_klasifikasi_surat,
            'id_sifat_surat' => $request->id_sifat_surat,
            'pengirim_external' => $request->pengirim_external,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'lampiran' => $request->lampiran,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat_diterima' => $request->tanggal_surat_diterima,
            'tanggal_surat' => $request->tanggal_surat,
        ]);

        if ($request->hasFile('file_surat')) {
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            $fileSurat = $request->file('file_surat');
            $fileSuratPath = $fileSurat->store('uploads/surat', 'public');
            $surat->file_surat = $fileSuratPath;
            $surat->save();
        }

        if ($request->hasFile('file_lampiran')) {
            if ($surat->file_lampiran) {
                Storage::disk('public')->delete($surat->file_lampiran);
            }

            $fileLampiran = $request->file('file_lampiran');
            $lampiranPath = $fileLampiran->store('uploads/lampiran', 'public');
            $surat->file_lampiran = $lampiranPath;
            $surat->save();
        }

        return redirect()->route('surat_masuk.verifikasi', ['encryptedKodeSurat' => encrypt($surat->kode_surat)])
        ->with('success', 'Surat berhasil ditambahkan.');
    }
    public function destroy($id)
    {
        // Temukan surat berdasarkan ID
        $surat = Surat::findOrFail($id);
        // Hapus file surat jika ada
        if ($surat->file_surat) {
            Storage::disk('public')->delete($surat->file_surat);
        }
        // Hapus file lampiran jika ada
        if ($surat->file_lampiran) {
            Storage::disk('public')->delete($surat->file_lampiran);
        }

        VerifikasiSurat::where('id_surat', $surat->id_surat)->delete();
        $surat->delete();
        
        return redirect()->route('surat_masuk.index')->with('success', 'Surat berhasil dihapus.');
    }
    public function verifikasi($encryptedKodeSurat) 
    {
        Carbon::setLocale('id');
        $nik = Auth::user()->username; // Mendapatkan NIK user yang sedang login
        $title = 'Verifikasi Surat Masuk';
        $kode_surat = decrypt($encryptedKodeSurat);
    
        // Mengambil data surat berdasarkan kode surat
        $surat = Surat::with(['pegawai', 'klasifikasi_surat', 'sifat_surat'])
        ->where('kode_surat', $kode_surat)
        ->firstOrFail();
    
        // Ambil verifikasi terakhir setelah mendapatkan surat
        $verifikasiTerbaru = VerifikasiSurat::where('id_surat', $surat->id_surat)
        ->orderBy('id_verifikasi_surat', 'DESC')
        ->first();
        $surat->verifikasi = $verifikasiTerbaru; // Tambahkan verifikasi terbaru ke model surat
            
        $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
        
        if ($surat->nik_pengirim!=""){
        // Mengambil template DOCX dari storage
        $templatePath = storage_path('app/public/' . $surat->file_surat);
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }
    
        // Mengonversi DOCX ke PDF
        $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);
    
        // Cek apakah PDF berhasil dibuat
        if (!$pdfFilePath) {
            return response()->json(['error' => 'Konversi gagal.'], 500);
        }
        // URL untuk menampilkan PDF di browser
        $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));

        }else{
            $pdfFilePath = $surat->file_surat;
            // URL untuk menampilkan PDF di browser
            $pdfUrl = asset('storage/' . $pdfFilePath);
        }
        
        // Jika status surat "Dikirim", ubah menjadi "Dibaca"
        if ($verifikasiTerbaru && $verifikasiTerbaru->status_surat === "Dikirim") {
            $verifikasiTerbaru->status_surat = "Dibaca";
            $verifikasiTerbaru->save();
        }
    
        // Mengambil data verifikasi terkait pegawai
        $verifikasiSurat = VerifikasiSurat::with('pegawai')
            ->where('id_surat', $surat->id_surat)
            ->get();
            
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        $atasanLangsung = VerifikasiSurat::whereNull('catatan')
                        ->where('nik_verifikator', '!=', $nik)
                        ->where('id_surat', '=', $surat->id_surat)
                        ->orderBy('id_verifikasi_surat', 'DESC')
                        ->first();

        // Mengirim data ke tampilan
        return view('surat_masuk.verifikasi', compact('title', 'surat', 'pdfUrl', 'tanggalSurat', 'verifikasiSurat','pegawai','atasanLangsung'));
    }
    
    public function detail($encryptedKodeSurat) {
        Carbon::setLocale('id');
        $title = 'Detail Surat Keluar';
        $kode_surat = decrypt($encryptedKodeSurat);
    
        // Mengambil data surat berdasarkan kode surat
        $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
            ->where('kode_surat', $kode_surat)
            ->firstOrFail();

        $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
        $verifikasiSurat = VerifikasiSurat::with('pegawai')->where('id_surat',$surat->id_surat)->get();
    
        if ($surat->nik_pengirim!=""){
        // Mengambil template DOCX dari storage
        $templatePath = storage_path('app/public/' . $surat->file_surat);
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }
    
        // Mengonversi DOCX ke PDF        
        $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);
    
        // Cek apakah PDF berhasil dibuat
        if ($pdfFilePath) {
            // URL untuk menampilkan PDF di browser
            $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));
        } else {
            return response()->json(['error' => 'Konversi gagal.'], 500);
        }
        }else{
            $pdfFilePath = $surat->file_surat;
            // URL untuk menampilkan PDF di browser
            $pdfUrl = asset('storage/' . $pdfFilePath);
        }
        $disposisiAll= DisposisiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();
        // Kembali ke tampilan dengan data surat dan PDF
        return view('surat_masuk.detail', compact('title', 'surat', 'pdfUrl','tanggalSurat','verifikasiSurat','disposisiAll'));
    }

    public function verifikasiProses(Request $request, $id_verifikasi_surat)
    {
        // Ambil data verifikasi surat terkait
        $verifikasi = VerifikasiSurat::where('id_verifikasi_surat', $id_verifikasi_surat)->first();
        // Ambil data surat
        $surat = Surat::findOrFail($verifikasi->id_surat);
         
        // Jika status surat sudah "Disetujui" atau "Ditolak", tidak boleh kembali ke "Dibaca" atau "Dikirim"
        if (in_array($verifikasi->status_surat, ['Disetujui', 'Ditolak'])) {
            return redirect()->back()->with('error', 'Status tidak dapat diubah, karena sudah disetujui atau ditolak.');
        }

        // Update status dan catatan verifikasi
        $verifikasi->status_surat = $request->input('status_surat');
        $verifikasi->catatan = $request->input('catatan');
        $verifikasi->tanggal_verifikasi = now();
        $verifikasi->save();

        // Cek apakah ada atasan langsung yang dipilih
        $nik_atasan_langsung = $request->input('nik_atasan_langsung');
        if ($nik_atasan_langsung) {
            // Simpan atasan langsung jika dipilih
            VerifikasiSurat::create([
                'id_surat' => $surat->id_surat,
                'nik_verifikator' => $nik_atasan_langsung,
                'status_surat' => 'Dikirim',  // Status default untuk atasan langsung yang baru ditambahkan
            ]);
        }

        return redirect()->back()->with('success', 'Verifikasi berhasil diperbarui.');
    }

    public function disposisi($encryptedKodeSurat) {
        Carbon::setLocale('id');
        $nik = Auth::user()->username; // Mendapatkan NIK user yang sedang login
        $title = 'Verifikasi dan Disposisi Surat Masuk';
        $kode_surat = decrypt($encryptedKodeSurat);
    
        // Mengambil data surat berdasarkan kode surat
        $surat = Surat::with(['pegawai', 'klasifikasi_surat', 'sifat_surat'])
        ->where('kode_surat', $kode_surat)
        ->firstOrFail();
    
        // Ambil verifikasi terakhir setelah mendapatkan surat
        $verifikasiTerbaru = VerifikasiSurat::where('id_surat', $surat->id_surat)
            ->orderBy('id_verifikasi_surat', 'DESC')
            ->first();
    
        $surat->verifikasi = $verifikasiTerbaru;
        
        $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
        if ($surat->nik_pengirim!=""){
        // Mengambil template DOCX dari storage
        $templatePath = storage_path('app/public/' . $surat->file_surat);
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Mengonversi DOCX ke PDF
        $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);
    
        // Cek apakah PDF berhasil dibuat
        if (!$pdfFilePath) {
            return response()->json(['error' => 'Konversi gagal.'], 500);
        }
    
        // URL untuk menampilkan PDF di browser
        $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));
    }else{
        $pdfFilePath = $surat->file_surat;
        // URL untuk menampilkan PDF di browser
        $pdfUrl = asset('storage/' . $pdfFilePath);
    }
        // Jika status surat "Dikirim", ubah menjadi "Dibaca"
        if ($verifikasiTerbaru && $verifikasiTerbaru->status_surat === "Dikirim") {
            $verifikasiTerbaru->status_surat = "Dibaca";
            $verifikasiTerbaru->save();
        }
    
        // Mengambil data verifikasi terkait pegawai
        $verifikasiSurat = VerifikasiSurat::with('pegawai')
            ->where('id_surat', $surat->id_surat)
            ->get();
            
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();

        $disposisi=DisposisiSurat::where('nik_disposisi', $nik)->orderBy('id_disposisi_surat', 'DESC')->first();
        $disposisiAll= DisposisiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();

        // Mengirim data ke tampilan
        return view('surat_masuk.disposisi', compact('title', 'surat', 'pdfUrl', 'tanggalSurat', 'verifikasiSurat','pegawai','disposisi','disposisiAll'));
    }

    public function verifikasiDisposisiProses(Request $request, $id_verifikasi_surat)
{
    // Validasi input dari form
    $validatedData = $request->validate([
        'status_surat' => 'required|string',
        'catatan' => 'nullable|string',
        'nik_penerima' => 'nullable|string',
        'catatan_disposisi' => 'nullable|string',
    ]);

    // Mengambil data verifikasi surat berdasarkan id_verifikasi_surat
    $verifikasiSurat = VerifikasiSurat::findOrFail($id_verifikasi_surat);
    
    // Update status dan catatan verifikasi surat
    $verifikasiSurat->status_surat = $validatedData['status_surat'];
    $verifikasiSurat->catatan = $validatedData['catatan'];
    $verifikasiSurat->tanggal_verifikasi = now();
    $verifikasiSurat->save();

    // Jika nik_penerima (disposisi ke pegawai lain) tidak kosong, maka lakukan disposisi
    if (!empty($validatedData['nik_penerima'])) {
        // Buat disposisi surat
        DisposisiSurat::create([
            'id_surat' => $verifikasiSurat->id_surat,
            'nik_disposisi' => Auth::user()->username, // Direktur atau yang melakukan disposisi
            'nik_penerima' => $validatedData['nik_penerima'], // Penerima disposisi
            'status_disposisi' => 'Dikirim', // Status awal disposisi
            'tanggal_disposisi' => now(),
            'catatan_disposisi' => $validatedData['catatan_disposisi'],
        ]);
    }

    return redirect()->route('surat_masuk.index')->with('success', 'Verifikasi dan disposisi berhasil diproses.');
}
public function tindaklanjut($encryptedKodeSurat)
{
    Carbon::setLocale('id');
    $nik = Auth::user()->username; // Mendapatkan NIK user yang sedang login
    $title = 'Tindak Lanjut Surat';
    $kode_surat = decrypt($encryptedKodeSurat);
    
    // Mengambil data surat berdasarkan kode surat
    $surat = Surat::with('pegawai', 'verifikasi', 'klasifikasi_surat', 'sifat_surat')
        ->where('kode_surat', $kode_surat)
        ->firstOrFail();
    $tanggalSurat = Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y');
    // Ambil verifikasi terakhir setelah mendapatkan surat
    $disposisiTerbaru = DisposisiSurat::where('id_surat', $surat->id_surat)->where('nik_penerima', $nik)
            ->orderBy('id_disposisi_surat', 'DESC')
            ->first();
            if ($surat->nik_pengirim!=""){
            // Mengambil template DOCX dari storage
        $templatePath = storage_path('app/public/' . $surat->file_surat);
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        // Mengonversi DOCX ke PDF
        $pdfFilePath = $this->convertDocxToPdf($templatePath, $surat);
    
        // Cek apakah PDF berhasil dibuat
        if (!$pdfFilePath) {
            return response()->json(['error' => 'Konversi gagal.'], 500);
        }
    
        // URL untuk menampilkan PDF di browser
        $pdfUrl = asset('storage/temp_surat/' . basename($pdfFilePath));
    }else{
        $pdfFilePath = $surat->file_surat;
        // URL untuk menampilkan PDF di browser
        $pdfUrl = asset('storage/' . $pdfFilePath);
    }
    $surat->disposisi = $disposisiTerbaru;
    if ($disposisiTerbaru && $disposisiTerbaru->status_disposisi === "Dikirim") {
        $disposisiTerbaru->status_disposisi = "Dibaca";
        $disposisiTerbaru->save();
    }

    // Mengambil pegawai yang aktif untuk dropdown
    $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
    $disposisiAll= DisposisiSurat::with('pegawai')->where('id_surat', $surat->id_surat)->get();
    $verifikasiSurat = VerifikasiSurat::with('pegawai')
    ->where('id_surat', $surat->id_surat)
    ->get();

    return view('surat_masuk.tindaklanjut', compact('title', 'surat', 'pegawai','disposisiTerbaru','disposisiAll','tanggalSurat','verifikasiSurat','pdfUrl'));
}

public function tindaklanjutProses(Request $request, $id_disposisi_surat)
{
    // Validasi input dari form

    $disposisiTerbaru = DisposisiSurat::where('id_disposisi_surat', $id_disposisi_surat)->first();

    $validatedData = $request->validate([
        'status_disposisi' => 'required|string',
        'nik_penerima' => 'required|string',
        'catatan' => 'nullable|string',
    ]);

    $disposisiTerbaru->status_disposisi = $validatedData['status_disposisi'];
    $disposisiTerbaru->save();

    if (!empty($validatedData['nik_penerima'])) {
    // Simpan tindak lanjut
    DisposisiSurat::create([
        'id_surat' => $disposisiTerbaru->id_surat,
        'nik_disposisi' => Auth::user()->username, // User yang melakukan tindak lanjut
        'nik_penerima' => $validatedData['nik_penerima'], // Penerima disposisi
        'status_disposisi' => 'Dikirim', // Status awal disposisi
        'tanggal_disposisi' => now(),
        'catatan_disposisi' => $validatedData['catatan'],
    ]);
    }

    return redirect()->route('surat_masuk.index')->with('success', 'Tindak lanjut berhasil diproses.');
}
private function convertDocxToPdf($docxPath, $surat)
{
    $templateProcessor = new TemplateProcessor($docxPath);
    $templateProcessor->setValue('nomor', $surat->nomor_surat);
    $templateProcessor->setValue('perihal', $surat->perihal);
    $templateProcessor->setValue('sifat', $surat->sifat_surat->nama_sifat_surat);
    $templateProcessor->setValue('tanggal_surat', Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'));
    $templateProcessor->setValue('lampiran', $surat->lampiran);

    // Ambil semua tanda tangan dari tabel TandaTangan
    $tandaTangan = TandaTangan::where('id_surat', $surat->id_surat)->get();

    // Placeholder list for QR Codes
    $placeholders = ['qrcode', 'qrcode_2', 'qrcode_3', 'qrcode_4']; // Placeholder untuk masing-masing status_ttd
    
    // Path untuk gambar kotak abu-abu dan logo
    $kotakAbuPath = public_path('assets/images/kotakabu.jpg');
    $logoPath = public_path('assets/images/web.png');

    // URL untuk QR Code
    $pdfUrl = url(route('surat_keluar.detail', ['encryptedKodeSurat' => encrypt($surat->kode_surat)]));

    // Loop untuk tanda tangan dan penanganan QR code atau kotak abu-abu
    foreach ($placeholders as $index => $placeholder) {
        $qrcodePath = storage_path('app/public/temp_surat/qrcode_with_logo_' . $placeholder . '.png');

        // Cek apakah tanda tangan sesuai dengan pengirim
        $ttd = $tandaTangan->where('status_ttd', $placeholder)->first();
        
        // Jika tanda tangan cocok dengan pengirim
        if ($ttd && $ttd->nik_penandatangan === $surat->nik_pengirim) {
            // Jika pengirim, buat QR Code langsung
            if (file_exists($logoPath)) {
                QrCode::format('png')
                    ->merge($logoPath, 0.2, true)
                    ->size(300)
                    ->margin(0)
                    ->generate($pdfUrl, $qrcodePath);

                // Tempatkan QR code di placeholder
                $templateProcessor->setImageValue($placeholder, [
                    'path' => $qrcodePath,
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            } else {
                Log::error('Logo file not found at: ' . $logoPath);
            }
        } elseif ($ttd) {
            // Cek apakah status surat disetujui untuk verifikator
            $verifikasiSurat = VerifikasiSurat::where('id_surat', $surat->id_surat)
                ->where('nik_verifikator', $ttd->nik_penandatangan)
                ->where('status_surat', 'Disetujui')
                ->first();

            // Jika verifikasi disetujui, buat QR Code
            if ($verifikasiSurat) {
                if (file_exists($logoPath)) {
                    QrCode::format('png')
                        ->merge($logoPath, 0.2, true)
                        ->size(300)
                        ->margin(0)
                        ->generate($pdfUrl, $qrcodePath);

                    // Tempatkan QR code di placeholder
                    $templateProcessor->setImageValue($placeholder, [
                        'path' => $qrcodePath,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true
                    ]);
                } else {
                    Log::error('Logo file not found at: ' . $logoPath);
                }
            } else {
                // Jika tidak memenuhi syarat, tampilkan kotak abu-abu
                if (file_exists($kotakAbuPath)) {
                    $templateProcessor->setImageValue($placeholder, [
                        'path' => $kotakAbuPath,
                        'width' => 100,
                        'height' => 100,
                        'ratio' => true
                    ]);
                } else {
                    Log::error('Kotak abu-abu file not found at: ' . $kotakAbuPath);
                }
            }
        } else {
            // Jika tidak ada tanda tangan, tampilkan kotak abu-abu
            if (file_exists($kotakAbuPath)) {
                $templateProcessor->setImageValue($placeholder, [
                    'path' => $kotakAbuPath,
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            }
        }
    }

    // Simpan file DOCX yang sudah diisi
    $filledDocxPath = storage_path('app/public/temp_surat/filled_surat_keluar-' . $surat->kode_surat . '.docx');
    $templateProcessor->saveAs($filledDocxPath);

    // Path untuk menyimpan file PDF hasil konversi
    $pdfPath = storage_path('app/public/temp_surat/filled_surat_keluar-' . $surat->kode_surat . '.pdf');
    
    // Path ke LibreOffice
    $libreOfficePath = 'C:\Program Files\LibreOffice\program\soffice.exe';

    // Siapkan command untuk eksekusi
    $command = '"' . $libreOfficePath . '" --headless --convert-to pdf --outdir "' . dirname($pdfPath) . '" "' . $filledDocxPath . '"';

    // Eksekusi command
    shell_exec($command);

    // Cek apakah file PDF berhasil dibuat
    if (file_exists($pdfPath)) {
        return $pdfPath;
    } else {
        return false;
    }
}
}