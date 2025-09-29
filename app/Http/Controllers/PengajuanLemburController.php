<?php
namespace App\Http\Controllers;

use App\Models\PengajuanLembur;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QRCode

class PengajuanLemburController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Pengajuan Lembur';
        $nik = Auth::user()->username;
        
        if ($request->ajax()) {
            $data = PengajuanLembur::with('pegawai')->where('nik', $nik)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('jam_lembur', function($row) {
                    // Mengakses nama pegawai dari relasi
                    return $row->jam_awal.' - '.$row->jam_akhir;
                })
                ->addColumn('action', function($row) {
                    if ($row->status == 'Dikirim') {
                    $btn = '
                        <a href="'.route('pengajuan_lembur.edit', $row->id_pengajuan_lembur).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                        <form action="'.route('pengajuan_lembur.destroy', $row->id_pengajuan_lembur).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger waves-effect waves-light delete-confirm"><i class="far fa-trash-alt"></i></button>
                        </form>';
                    } else {
                        $btn = '<a href="'.route('pengajuan_lembur.show', encrypt($row->kode_pengajuan_lembur)).'" class="btn btn-primary waves-effect waves-light"><i class="fas fa-eye"></i> Show</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pengajuan_lembur.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create Pengajuan Lembur';
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        return view('pengajuan_lembur.create', compact('title','pegawai'));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'keterangan' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
            'nik_atasan_langsung' => 'required',
            'tanggal_dibuat' => Carbon::now(),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Add `nik` as the username of the currently authenticated user
        $request->merge(['nik' => Auth::user()->username]);

        PengajuanLembur::create($request->all());
    
        return redirect()->route('pengajuan_lembur.index')
            ->with('success', 'Pengajuan Lembur created successfully.');
    }

    public function edit($id)
    {
        $title = 'Edit Pengajuan Lembur';
        $pengajuan_lembur = PengajuanLembur::findOrFail($id);
        $pegawai = Pegawai::where('stts_aktif','AKTIF')->get();
        return view('pengajuan_lembur.edit', compact('title', 'pengajuan_lembur','pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
            'nik_atasan_langsung' => 'required',
        ]);

        $pengajuan_lembur = PengajuanLembur::findOrFail($id);
        $pengajuan_lembur->update($request->all());

        return redirect()->route('pengajuan_lembur.index')
            ->with('success', 'Pengajuan Lembur updated successfully.');
    }

    public function destroy($id)
    {
        PengajuanLembur::findOrFail($id)->delete();

        return redirect()->route('pengajuan_lembur.index')
            ->with('success', 'Pengajuan Lembur deleted successfully.');
    }

    public function show($encryptedKodePengajuanLembur)
    {
        $title = 'Pengajuan Lembur';
        $kode_pengajuan_lembur = decrypt($encryptedKodePengajuanLembur);
      
        $pengajuanlembur = PengajuanLembur::with(['pegawai.departemen_unit', 'pegawai2'])
        ->where('kode_pengajuan_lembur', $kode_pengajuan_lembur)
        ->firstOrFail();
        $pdfUrl = route('pengajuan-lembur.pdf', ['kode_pengajuan_lembur' => $encryptedKodePengajuanLembur]);
        return view('pengajuan_lembur.show', compact('pengajuanlembur','title','pdfUrl'));
    }
    public function rekapLembur(Request $request)
{
    $title = 'Rekapitulasi Lembur Pegawai';

    // Jika request bukan Ajax, tampilkan halaman rekaplembur.blade.php
    if (!$request->ajax()) {
        return view('pengajuan_lembur.rekaplembur', compact('title'));
    }

    // Ambil data lembur yang disetujui dan hitung total jam lembur
    $query = PengajuanLembur::with('pegawai')
        ->select('pengajuan_lembur.nik', 'pengajuan_lembur.tanggal_awal', 'pengajuan_lembur.jam_awal', 'pengajuan_lembur.jam_akhir')
        ->where('status', 'Disetujui');

    // Filter berdasarkan tanggal jika ada input
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('pengajuan_lembur.tanggal_awal', [$request->start_date, $request->end_date]);
    }

    // Ambil data dan kelompokkan berdasarkan NIK
   $rekap = $query->get()->groupBy('nik')->map(function ($items) {
    $totalSeconds = $items->sum(function ($item) {
        return strtotime($item->jam_akhir) - strtotime($item->jam_awal);
    });

    $hours = floor($totalSeconds / 3600);
    $minutes = ($totalSeconds % 3600) / 60;

    return [
        'nik'        => $items->first()->nik,
        'nama'       => optional($items->first()->pegawai)->nama,
        'total_jam'  => sprintf('%d Jam %d Menit', $hours, $minutes),
    ];
})->values();

    return DataTables::of($rekap)->make(true);
}

    public function generateLemburPDF($encryptedKodePengajuanLembur)
    {
        Carbon::setLocale('id');
         // Ambil data pengajuan libur berdasarkan id
        $kode_pengajuan_lembur = decrypt($encryptedKodePengajuanLembur);

        $pengajuan = PengajuanLembur::with(['pegawai.departemen_unit', 'pegawai2'])
        ->where('kode_pengajuan_lembur', $kode_pengajuan_lembur)
        ->firstOrFail();

        $qrCodeData = url('/pengajuan_lembur/pdf/' . $encryptedKodePengajuanLembur);
        $qrcode = QrCode::format('png')->size(300)->margin(0)->generate($qrCodeData);

         // Path ke logo yang akan ditambahkan di QR code
        $logoPath = public_path('assets/images/web.png');

        // Generate QR code dengan logo di tengahnya
        $qrcode = QrCode::format('png')
            ->size(300) // Ukuran QR code
            ->merge($logoPath, 0.2, true) // Tambahkan logo di tengah dengan ukuran relatif (30%)
            ->margin(0)
            ->generate($qrCodeData);

        // Encode QR Code ke base64
        $qrcodeBase64 = base64_encode($qrcode);
        $qrcodeDataUri = 'data:image/png;base64,' . $qrcodeBase64;
    
    $tanggal_dibuat = Carbon::parse($pengajuan->tanggal_dibuat)->translatedFormat('d F Y');
    $tanggal_awal = Carbon::parse($pengajuan->tanggal_awal)->translatedFormat('l, d F Y');
    $tanggal_akhir = Carbon::parse($pengajuan->tanggal_akhir)->translatedFormat('l, d F Y');
    // Encode gambar kop surat ke base64
    $path = public_path('assets/images/logo_hitam.png'); // Ganti dengan path gambar Anda
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

       $data = [
           'pengajuan' => $pengajuan,
           'qrcode' =>  $qrcodeDataUri,
           'tanggal_dibuat' =>$tanggal_dibuat,
           'tanggal_awal' =>$tanggal_awal,
            'tanggal_akhir' =>$tanggal_akhir,
           'kop_surat' => $base64,
       ];

        $pdf = PDF::loadView('pengajuan_lembur.lemburpdfview', $data);
       // return view('pengajuan_lembur.lemburpdfview', $data);
        // Stream PDF agar bisa di-embed di halaman browser
        return $pdf->stream('pengajuan_lembur_' . $pengajuan->kode_pengajuan_lembur . '.pdf');
        //return response($qrcode)->header('Content-Type', 'text/html');
    }
}
