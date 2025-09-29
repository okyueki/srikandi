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
        // $strukturOrganisasi = StrukturOrganisasi::where('nik', $nik)->first();
    
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
    if (is_null($row->nik_pengirim) || $row->nik_pengirim == '') {
        return !empty($row->pengirim_external) ? $row->pengirim_external : '-';
    } else {
        return $row->pegawai ? $row->pegawai->nama : '-';
    }
})

                ->addColumn('status_verifikasi', function ($row) use ($nik){
                   $verifikasi = $row->verifikasi()
                    ->where('nik_verifikator', $nik)
                    ->where('id_surat', $row->id_surat) // Perbaikan: gunakan $row->id_surat
                    ->orderBy('id_verifikasi_surat', 'DESC')
                    ->first();
                    return $verifikasi ? $verifikasi->status_surat : '-';
                })
                ->addColumn('status_disposisi', function ($row) use ($nik){
                    $disposisi = $row->disposisi()->where('nik_penerima', $nik)->where('id_surat', $row->id_surat)->where('id_surat', $row->id_surat)->orderBy('id_disposisi_surat', 'DESC')->first();
                    return $disposisi ? $disposisi->status_disposisi : '-';
                })
                ->addColumn('action', function ($row) use ( $nik, $level) {
                 $verifikasi = $row->verifikasi()
                        ->where('id_surat', $row->id_surat)
                        ->where('nik_verifikator', $nik)  // Pastikan mengambil verifikasi oleh pengguna yang login (Kabag/Kabid)
                        ->orderBy('id_verifikasi_surat', 'DESC')
                        ->first();
                    
                    $disposisi = $row->disposisi()
                        ->where('nik_penerima', $nik)
                        ->orderBy('id_disposisi_surat', 'DESC')
                        ->first();
                    
                    if ($level == "Direktur") {
                        // Jika user adalah direktur
                        if ($verifikasi && isset($verifikasi->status_surat) && trim($verifikasi->status_surat) == "Disetujui") {
                            // Jika surat sudah disetujui oleh Kabag
                            return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                        } else {
                            // Jika surat belum disetujui, tampilkan tombol disposisi dan detail
                            return '<a class="btn btn-info waves-effect waves-light edit" href="' . route('surat_masuk.disposisi', encrypt($row->kode_surat)) . '"><i class="far fa-edit"></i></a> ' .
                                   ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                        }
                    } elseif ($level == "Kabag" || $level == "Kabid") {
                       // Jika Kabag atau Kabid
                        if ($verifikasi && isset($verifikasi->status_surat) && trim($verifikasi->status_surat) == "Disetujui") {
                            // Jika Kabag sudah melakukan verifikasi dan surat disetujui
                            if ($disposisi) {
                                // Jika Kabag sudah menerima disposisi
                                if ($disposisi->status_disposisi == null || $disposisi->status_disposisi != "Ditindaklanjuti" && $disposisi->status_disposisi != "Selesai") {
                                    // Jika disposisi belum ditindaklanjuti, tampilkan tombol tindak lanjut dan detail
                                    return '<a class="btn btn-info waves-effect waves-light edit" href="' . route('surat_masuk.tindaklanjut', encrypt($row->kode_surat)) . '"><i class="far fa-edit"></i></a> ' .
                                           ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                                } else {
                                    // Jika disposisi sudah ditindaklanjuti atau selesai, hanya tampilkan tombol detail
                                    return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                                }
                            } else {
                                // Jika Kabag belum menerima disposisi, hanya tampilkan tombol detail
                                return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                            }
                        } else {
                            // Jika Kabag belum melakukan verifikasi atau surat belum disetujui
                            return '<a class="btn btn-info waves-effect waves-light edit" href="' . route('surat_masuk.verifikasidisposisi', encrypt($row->kode_surat)) . '"><i class="far fa-edit"></i></a> ' .
                                   ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                        }
                    }elseif($level == "Kasie"){
                        // Jika Kabag atau Kabid
                        if ($verifikasi && isset($verifikasi->status_surat) && trim($verifikasi->status_surat) == "Disetujui") {
                            // Jika Kabag sudah melakukan verifikasi dan surat disetujui
                            if ($disposisi) {
                                // Jika Kabag sudah menerima disposisi
                                if ($disposisi->status_disposisi == null || $disposisi->status_disposisi != "Ditindaklanjuti" && $disposisi->status_disposisi != "Selesai") {
                                    // Jika disposisi belum ditindaklanjuti, tampilkan tombol tindak lanjut dan detail
                                    return '<a class="btn btn-info waves-effect waves-light edit" href="' . route('surat_masuk.tindaklanjut', encrypt($row->kode_surat)) . '"><i class="far fa-edit"></i></a> ' .
                                           ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                                } else {
                                    // Jika disposisi sudah ditindaklanjuti atau selesai, hanya tampilkan tombol detail
                                    return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                                }
                            } else {
                                // Jika Kabag belum menerima disposisi, hanya tampilkan tombol detail
                                return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                            }
                        } else {
                            // Jika Kabag belum melakukan verifikasi atau surat belum disetujui
                            return '<a class="btn btn-info waves-effect waves-light edit" href="' . route('surat_masuk.verifikasi', encrypt($row->kode_surat)) . '"><i class="far fa-edit"></i></a> ' .
                                   ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                        }
                    }else{
                        if ($disposisi) {
                                // Jika Kabag sudah menerima disposisi
                                if ($disposisi->status_disposisi == null || $disposisi->status_disposisi != "Ditindaklanjuti" && $disposisi->status_disposisi != "Selesai") {
                                    // Jika disposisi belum ditindaklanjuti, tampilkan tombol tindak lanjut dan detail
                                    return '<a class="btn btn-info waves-effect waves-light edit" href="' . route('surat_masuk.tindaklanjut', encrypt($row->kode_surat)) . '"><i class="far fa-edit"></i></a> ' .
                                           ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                                } else {
                                    // Jika disposisi sudah ditindaklanjuti atau selesai, hanya tampilkan tombol detail
                                    return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
                                }
                            } else {
                                // Jika Kabag belum menerima disposisi, hanya tampilkan tombol detail
                                return ' <a class="btn btn-primary waves-effect waves-light" href="' . route('surat_masuk.detail', encrypt($row->kode_surat)) . '"><i class="far fa-eye"></i></a>';
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
            'pengirim_external' => $request->pengirim_external,
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
        $verifikasiTerbaru = VerifikasiSurat::where('id_surat', $surat->id_surat)->where('nik_verifikator',  $nik)
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
        $title = 'Detail Surat Masuk';
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

       return redirect()->route('surat_masuk.index')->with('success', 'Verifikasi berhasil diproses.');
    }

    public function disposisi($encryptedKodeSurat) {
        Carbon::setLocale('id');
        $nik = Auth::user()->username; // Mendapatkan NIK user yang sedang login
        $title = 'Disposisi Surat Masuk';
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

   public function disposisiProses(Request $request, $id_verifikasi_surat)
{
    // Validate input from the form
    $validatedData = $request->validate([
        'status_surat' => 'required|string',
        'catatan' => 'nullable|string',
        'nik_penerima' => 'nullable|array', // Change to array
        'nik_penerima.*' => 'string', // Each item in the array should be a string
        'catatan_disposisi' => 'nullable|string',
    ]);

    // Get the verification data based on id_verifikasi_surat
    $verifikasiSurat = VerifikasiSurat::findOrFail($id_verifikasi_surat);
    
    // Update status and notes of the verification letter
    $verifikasiSurat->status_surat = $validatedData['status_surat'];
    $verifikasiSurat->catatan = $validatedData['catatan'];
    $verifikasiSurat->tanggal_verifikasi = now();
    $verifikasiSurat->save();

    // If nik_penerima (disposition to other employees) is not empty, perform disposition
    if (!empty($validatedData['nik_penerima'])) {
        foreach ($validatedData['nik_penerima'] as $nik) {
            // Create letter disposition for each recipient
            DisposisiSurat::create([
                'id_surat' => $verifikasiSurat->id_surat,
                'nik_disposisi' => Auth::user()->username, // Director or the person making the disposition
                'nik_penerima' => $nik, // Recipient of the disposition
                'status_disposisi' => 'Dikirim', // Initial status of disposition
                'tanggal_disposisi' => now(),
                'catatan_disposisi' => $validatedData['catatan_disposisi'],
            ]);
        }
    }

    return redirect()->route('surat_masuk.index')->with('success', 'Verifikasi dan disposisi berhasil diproses.');
}

public function verifikasidisposisi($encryptedKodeSurat) {
    Carbon::setLocale('id');
    $nik = Auth::user()->username; // Mendapatkan NIK user yang sedang login
    $title = 'Disposisi Surat Masuk';
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
    return view('surat_masuk.verifikasidisposisi', compact('title', 'surat', 'pdfUrl', 'tanggalSurat', 'verifikasiSurat','pegawai','disposisi','disposisiAll'));
}

public function verifikasidisposisiProses(Request $request, $id_verifikasi_surat)
{
    // Validasi input dari form
    $validatedData = $request->validate([
        'status_surat' => 'required|string',
        'catatan' => 'nullable|string',
        'nik_verifikator' => 'nullable|string',
        'nik_penerima' => 'nullable|array', // Pastikan ini array jika ada beberapa penerima
        'catatan_disposisi' => 'nullable|string',
        'nik_atasan_langsung' => 'nullable|string', // Validasi nik atasan langsung
        'is_disposisi' => 'nullable|boolean', // Tambahkan validasi untuk checkbox disposisi
    ]);

    // Ambil data verifikasi surat berdasarkan ID
    $verifikasiSurat = VerifikasiSurat::findOrFail($id_verifikasi_surat);

    // Jika checkbox CheckDisposisi tidak diaktifkan, lakukan verifikasi
    if (!$request->input('is_disposisi')) {
        $verifikasiSurat->update([
            'status_surat' => $validatedData['status_surat'],
            'catatan' => $validatedData['catatan'],
            'tanggal_verifikasi' => now(),
        ]);
        
        
         // Simpan atasan langsung jika dipilih
        $nikAtasanLangsung = $validatedData['nik_atasan_langsung'] ?? null;
        if ($nikAtasanLangsung) {
            VerifikasiSurat::create([
                'id_surat' => $verifikasiSurat->id_surat,
                'nik_verifikator' => $nikAtasanLangsung,
                'status_surat' => 'Dikirim', // Status default untuk atasan langsung
            ]);
        }


        return redirect()->route('surat_masuk.index')->with('success', 'Verifikasi berhasil diproses.');
    }

    // Jika checkbox CheckDisposisi diaktifkan, lakukan disposisi
    if ($request->input('is_disposisi')) {
        // Buat disposisi surat untuk nik_verifikator (opsional)
        if (!empty($validatedData['nik_verifikator'])) {
            DisposisiSurat::create([
                'id_surat' => $verifikasiSurat->id_surat,
                'nik_disposisi' => Auth::user()->username,
                'nik_penerima' => $validatedData['nik_verifikator'],
                'status_disposisi' => 'Dikirim',
                'tanggal_disposisi' => now(),
                'catatan_disposisi' => null,
            ]);
        }
        
        $verifikasiSurat->update([
            'status_surat' => $validatedData['status_surat'],
            'catatan' => $validatedData['catatan'],
            'tanggal_verifikasi' => now(),
        ]);

        // Buat disposisi untuk setiap penerima (jika ada)
        if (!empty($validatedData['nik_penerima']) && is_array($validatedData['nik_penerima'])) {
            foreach ($validatedData['nik_penerima'] as $nik) {
                DisposisiSurat::create([
                    'id_surat' => $verifikasiSurat->id_surat,
                    'nik_disposisi' => Auth::user()->username,
                    'nik_penerima' => $nik,
                    'status_disposisi' => 'Dikirim',
                    'tanggal_disposisi' => now(),
                    'catatan_disposisi' => $validatedData['catatan_disposisi'],
                ]);
            }
        }

        return redirect()->route('surat_masuk.index')->with('success', 'Disposisi berhasil diproses.');
    }
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
        'nik_penerima' => 'nullable|array', // Change to array
        'nik_penerima.*' => 'string', // Each item in the array should be a string
        'catatan' => 'nullable|string',
    ]);

    $disposisiTerbaru->status_disposisi = $validatedData['status_disposisi'];
    $disposisiTerbaru->save();

   // If nik_penerima (disposition to other employees) is not empty, perform disposition
    if (!empty($validatedData['nik_penerima'])) {
        foreach ($validatedData['nik_penerima'] as $nik) {
            // Create letter disposition for each recipient
            DisposisiSurat::create([
                'id_surat' => $disposisiTerbaru->id_surat,
                'nik_disposisi' => Auth::user()->username, // Director or the person making the disposition
                'nik_penerima' => $nik, // Recipient of the disposition
                'status_disposisi' => 'Dikirim', // Initial status of disposition
                'tanggal_disposisi' => now(),
                'catatan_disposisi' => $validatedData['catatan'],
            ]);
        }
    }

    return redirect()->route('surat_masuk.index')->with('success', 'Tindak lanjut berhasil diproses.');
}

   private function convertDocxToPdf($docxPath, $surat)
{
    $templateProcessor = new TemplateProcessor($docxPath);
    $templateProcessor->setValue('nomor', htmlspecialchars($surat->nomor_surat, ENT_QUOTES, 'UTF-8'));
    $templateProcessor->setValue('perihal', htmlspecialchars($surat->perihal, ENT_QUOTES, 'UTF-8'));
    $templateProcessor->setValue('sifat', htmlspecialchars($surat->sifat_surat->nama_sifat_surat, ENT_QUOTES, 'UTF-8'));
    $templateProcessor->setValue('tanggal_surat', htmlspecialchars(Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y'), ENT_QUOTES, 'UTF-8'));
    $templateProcessor->setValue('lampiran', htmlspecialchars($surat->lampiran, ENT_QUOTES, 'UTF-8'));
    $templateProcessor->setValue('pengirim', htmlspecialchars($surat->pegawai->nama, ENT_QUOTES, 'UTF-8'));
    $templateProcessor->setValue('jabatan', htmlspecialchars($surat->pegawai->jbtn, ENT_QUOTES, 'UTF-8'));

    $tandaTangan = TandaTangan::where('id_surat', $surat->id_surat)->get();
    $placeholders = ['qrcode', 'qrcode_2', 'qrcode_3', 'qrcode_4'];

    $kotakAbuPath = public_path('assets/images/kotakabu.jpg');
    $logoPath = public_path('assets/images/web.png');
    $pdfUrl = url(route('surat.show', ['encryptedKodeSurat' => encrypt($surat->kode_surat)]));

    // Loop setiap placeholder untuk menyesuaikan tanda tangan
    foreach ($placeholders as $index => $placeholder) {
        $qrcodePath = storage_path('app/public/temp_surat/qrcode_'.$surat->id_surat.'_' . $placeholder . '.png');
        $ttd = $tandaTangan->where('status_ttd', $placeholder)->first();

        if ($ttd && $ttd->nik_penandatangan === $surat->nik_pengirim) {
            // Jika ini adalah pengirim, QR Code langsung muncul
            if (file_exists($logoPath)) {
                QrCode::format('png')
                    ->merge($logoPath, 0.2, true)
                    ->size(200)
                    ->margin(0)
                    ->generate($pdfUrl, $qrcodePath);

                $templateProcessor->setImageValue($placeholder, [
                    'path' => $qrcodePath,
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            }
        } else {
            // Jika bukan pengirim, pastikan atasan telah menyetujui
            $verifikasiSurat = VerifikasiSurat::where('id_surat', $surat->id_surat)
                ->where('nik_verifikator', $ttd ? $ttd->nik_penandatangan : null)
                ->where('status_surat', 'Disetujui')
                ->first();

            if ($verifikasiSurat && file_exists($logoPath)) {
                QrCode::format('png')
                    ->merge($logoPath, 0.2, true)
                    ->size(200)
                    ->margin(0)
                    ->generate($pdfUrl, $qrcodePath);

                $templateProcessor->setImageValue($placeholder, [
                    'path' => $qrcodePath,
                    'width' => 100,
                    'height' => 100,
                    'ratio' => true
                ]);
            } else {
                // Jika tidak disetujui, pasang kotak abu
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
    }

    $filledDocxPath = storage_path('app/public/temp_surat/surat-' . $surat->kode_surat . '-' . time() . '.docx');
    $templateProcessor->saveAs($filledDocxPath);

    $pdfPath = storage_path('app/public/temp_surat/surat-' . $surat->kode_surat . '-' . time() .'.pdf');
    $libreOfficePath = '/usr/bin/libreoffice';
    $command = '"' . $libreOfficePath . '" --headless --convert-to pdf --outdir "' . dirname($pdfPath) . '" "' . $filledDocxPath . '"';
    shell_exec($command);

    return file_exists($pdfPath) ? $pdfPath : false;
}
public function show($filename)
{
    $path = 'uploads/lampiran/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        return response("File tidak ditemukan: $path", 404);
    }

    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        return response("File tidak ditemukan secara fisik: $fullPath", 404);
    }

    try {
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
        ]);
    } catch (\Exception $e) {
        return response("Gagal membuka file: " . $e->getMessage(), 500);
    }
}
}