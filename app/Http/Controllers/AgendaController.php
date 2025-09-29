<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pegawai;
use App\Models\Petugas;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\AgendaToken;
use App\Models\AbsensiAgenda;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar agenda.
     */
    public function index()
    {
        
        $agendas = Agenda::with(['pimpinan', 'notulenPegawai'])->get();
    
        $events = $agendas->map(function($agenda) {
            return [
                'id' => $agenda->id,
                'title' => $agenda->judul,
                'start' => $agenda->mulai,
                'end' => $agenda->akhir,
                'deskripsi' => $agenda->deskripsi,
                'tempat' => $agenda->tempat,
                'pimpinan_rapat' => $agenda->pimpinan->nama ?? '-', 
                'notulen' => $agenda->notulenPegawai->nama ?? '-', 
                'keterangan' => $agenda->keterangan,
                'yang_terundang' => is_string($agenda->yang_terundang) ? json_decode($agenda->yang_terundang, true) : $agenda->yang_terundang, // Perhatikan baris ini
            ];
        });
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
    
        // Kirim data agenda dan events ke view
        return view('event.acara_index', compact('agendas', 'events'));
    }


    /**
     * Menampilkan form untuk menambah agenda baru.
     */
    public function create()
    {
        // Mengambil data pegawai untuk pilihan pimpinan, notulen, dan yang terundang
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();

        return view('event.acara_create', compact('pegawai'));
    }

    /**
     * Menyimpan agenda baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mulai' => 'required|date',
            'akhir' => 'nullable|date|after_or_equal:mulai',
            'tempat' => 'nullable|string',
            'pimpinan_rapat' => 'nullable|string',
            'notulen' => 'nullable|string',
            'yang_terundang' => 'nullable|array',
            'yang_terundang.*' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'materi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ]);
        
        // Generate nomor_agenda otomatis
        $year = Carbon::now()->year;
        $latestAgenda = Agenda::whereYear('created_at', $year)->latest()->first();
        $nextNumber = $latestAgenda ? (int)substr($latestAgenda->nomor_agenda, -3) + 1 : 1;
        $nomorAgenda = 'AGD-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $validatedData['nomor_agenda'] = $nomorAgenda;
    
        // ✅ Handle "all" dengan BENAR — dan HANYA sekali
        if (is_array($request->yang_terundang) && in_array('all', $request->yang_terundang)) {
            $semuaNik = Pegawai::where('stts_aktif', 'AKTIF')->pluck('nik')->toArray();
            $validatedData['yang_terundang'] = json_encode($semuaNik);
        } else {
            $validatedData['yang_terundang'] = json_encode($request->yang_terundang ?? []);
        }
    
        // Upload file
        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('agenda_fotos', 'public');
        }
        if ($request->hasFile('materi')) {
            $validatedData['materi'] = $request->file('materi')->store('agenda_materis', 'public');
        }
    
        // ✅ JANGAN ASSIGN LAGI DI SINI!
        Agenda::create($validatedData);
    
        return redirect()->route('acara_index')->with('success', 'Agenda berhasil ditambahkan');
    }
    /**
     * Menampilkan form untuk mengedit agenda.
     */
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $pegawai = Pegawai::all();

        return view('event.acara_edit', compact('agenda', 'pegawai'));
    }

    /**
     * Mengupdate data agenda.
     */
    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
    
        // Validasi: lewati validasi exists jika ada "all"
        $rules = [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mulai' => 'required|date',
            'akhir' => 'nullable|date|after_or_equal:mulai',
            'tempat' => 'nullable|string',
            'pimpinan_rapat' => 'nullable|string|exists:pegawai,nik',
            'notulen' => 'nullable|string|exists:pegawai,nik',
            'yang_terundang' => 'nullable|array',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'materi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ];
    
        // Jika tidak ada "all", baru validasi exists
        if (!in_array('all', (array) $request->yang_terundang)) {
            $rules['yang_terundang.*'] = 'exists:pegawai,nik';
        }
    
        $validatedData = $request->validate($rules);
    
        // Handle file
        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('agenda_fotos', 'public');
        }
        if ($request->hasFile('materi')) {
            $validatedData['materi'] = $request->file('materi')->store('agenda_materis', 'public');
        }
    
        // Handle "all" di update
        if (is_array($request->yang_terundang) && in_array('all', $request->yang_terundang)) {
            $semuaNik = Pegawai::where('stts_aktif', 'AKTIF')->pluck('nik')->toArray();
            $validatedData['yang_terundang'] = json_encode($semuaNik);
        } else {
            $validatedData['yang_terundang'] = json_encode($request->yang_terundang ?? []);
        }
    
        $agenda->update($validatedData);
    
        return redirect()->route('acara_index')->with('success', 'Agenda berhasil diperbarui');
    }
/**
 * Menghapus data agenda.
 */
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
    
        return redirect()->route('backend_acara')->with('success', 'Agenda berhasil dihapus');
    }

    public function show($id)
    {
        $agenda = Agenda::with(['pimpinan', 'notulenPegawai'])->findOrFail($id);
    
        // Hitung jumlah yang terundang — tangani kasus "all"
        if ($agenda->yang_terundang === 'all') {
            $jumlahTerundang = Pegawai::where('stts_aktif', 'AKTIF')->count();
            $listTerundang = []; // atau null, tergantung kebutuhan tampilan
            $isAll = true;
        } else {
            $decoded = is_array($agenda->yang_terundang) 
                ? $agenda->yang_terundang 
                : json_decode($agenda->yang_terundang, true);
            
            $listTerundang = is_array($decoded) ? $decoded : [];
            $jumlahTerundang = count($listTerundang);
            $isAll = false;
        }
    
        return view('event.acara_show', compact('agenda', 'jumlahTerundang', 'listTerundang', 'isAll'));
    }

    public function backendAcara(Request $request)
    {
        if ($request->ajax()) {
            $agendas = Agenda::with(['pimpinan', 'notulenPegawai'])
                ->select('agendas.*');
    
            return DataTables::of($agendas)
                ->addIndexColumn()
                ->addColumn('jumlah_terundang', function ($row) {
                    // Hitung jumlah yang terundang
                    if ($row->yang_terundang === 'all') {
                        return Pegawai::where('stts_aktif', 'AKTIF')->count();
                    } else {
                        $decoded = is_array($row->yang_terundang) 
                            ? $row->yang_terundang 
                            : json_decode($row->yang_terundang, true);
                        return is_array($decoded) ? count($decoded) : 0;
                    }
                })
                ->addColumn('pimpinan_nama', function ($row) {
                    return $row->pimpinan->nama ?? '-';
                })
                ->addColumn('notulen_nama', function ($row) {
                    return $row->notulenPegawai->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $detailUrl      = route('acara_show', $row->id);
                    $editUrl        = route('acara_edit', $row->id);
                    $deleteUrl      = route('acara_destroy', $row->id);
                    $qrcodeUrl      = route('agenda.qr_code', ['agendaId' => $row->id]);
                    // $sendMessageUrl = route('agenda.send_message', ['agendaId' => $row->id]);
    
                    $btn = '
                        <a href="'.$detailUrl.'" class="btn btn-info btn-sm">Detail</a>
                        <a href="'.$qrcodeUrl.'" class="btn btn-info btn-sm"><i class="fa-solid fa-qrcode"></i></a>
                        <a href="'.$editUrl.'" class="btn btn-warning btn-sm">Edit</a>
                        
                    ';
    
                    // Cek langsung apakah ada absensi
                    if (!$row->absensi()->exists()) {
                        $btn .= '
                            <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm(\'Apakah Anda yakin ingin menghapus agenda ini?\')">
                                    Hapus
                                </button>
                            </form>
                        ';
                    }
    
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    
        return view('event.backend_acara');
    }

    // Fungsi untuk mengirim pesan ke WAHA
    public function sendMessage($agendaId) 
    {
        $agenda = Agenda::findOrFail($agendaId);
         $yangTerundang = $agenda->yang_terundang;
    
        // Ambil nomor WA dari tabel petugas
        $noTelpList = Petugas::whereIn('nip', $yangTerundang)->pluck('no_telp')->toArray();
    
        foreach ($noTelpList as $noTelp) {
            $nomorWA = '62' . ltrim($noTelp, '0') . '@c.us';
    
            // Generate QR Code & simpan ke storage
            $qrCodePath = 'qrcodes/' . Str::uuid() . '.png';
            $qrCode = QrCode::size(300)->generate(route('agenda.qr_code', ['agendaId' => $agenda->id]));
            Storage::disk('public')->put($qrCodePath, $qrCode);
    
            // Link Absensi
            $link = route('agenda.qr_code', ['agendaId' => $agenda->id]);
    
            // Kirim pesan WA
            $pesan = "📢 *Undangan Agenda* 📢\n\n"
                . "Agenda: {$agenda->judul}\n"
                . "📅 Tanggal: " . Carbon::parse($agenda->mulai)->format('d M Y H:i') . "\n"
                . "📍 Lokasi: {$agenda->tempat}\n\n"
                . "🔗 Link Absensi: $link";
    
            $this->sendToWahaText($nomorWA, $pesan);
        }
    
         return view('event.backend_acara')->with('success', 'Pesan berhasil dikirim ke semua yang terundang');
    }
    // Fungsi untuk mengirim pesan WAHA dengan QR Code
    private function sendToWahaText($number, $message)
        {
            $wahaUrl = 'http://192.168.10.47:3000/api/sendText';
            $session = 'default';
        
            $client = new \GuzzleHttp\Client();
            $response = $client->post($wahaUrl, [
                'json' => [
                    'session' => $session,
                    'chatId' => $number,
                    'text' => $message
                ]
            ]);
        
            return $response->getBody();
        }
    
    public function generateQRCodeBaru($agendaId)
        {
             $agenda = Agenda::findOrFail($agendaId);
        
            $linkScan = url('/proses-scan?agendaId=' . $agenda->id);
        
            $qrcode = QrCode::size(300)->generate($linkScan);
        
            return view('event.qrcode', compact('agenda', 'qrcode'));
        }


 // Method to show the QR Code page
    public function showQRCodePage($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);
    
        // Parse waktu mulai agenda
        $mulai = Carbon::parse($agenda->mulai);
        $sekarang = Carbon::now();
        $waktuBukaQR = $mulai->copy()->subMinutes(35); // 45 menit sebelum mulai
    
        // Cek apakah QR Code boleh di-generate
        $bolehGenerate = $sekarang->greaterThanOrEqualTo($waktuBukaQR) && $sekarang->lessThanOrEqualTo(Carbon::parse($agenda->akhir));
    
        if (!$bolehGenerate) {
            // Jika belum waktunya, tampilkan pesan
            return view('event.generate_qr_code', [
                'agenda' => $agenda,
                'agendaBerakhir' => false,
                'belumWaktunya' => true,
                'waktuBukaQR' => $waktuBukaQR,
            ]);
        }
    
        // Jika sudah waktunya, generate QR seperti biasa
        $token = Str::random(32);
        $expiry = Carbon::now()->addMinutes(2);
    
        // Hapus token lama yang sudah expired (opsional, untuk kebersihan)
        AgendaToken::where('agenda_id', $agendaId)
            ->where('expiry', '<', now())
            ->delete();
        
        // Buat token BARU (jangan replace yang lama!)
        AgendaToken::create([
            'agenda_id' => $agendaId,
            'token' => $token,
            'expiry' => $expiry
        ]);
    
        $qrData = ['agenda_id' => $agendaId, 'token' => $token];
        $fileName = 'qr_codes/qr_code_' . $agendaId . '_' . time() . '.svg';
        Storage::disk('public')->put($fileName, QrCode::size(300)->generate(json_encode($qrData)));
        $qrCodeUrl = asset('storage/' . $fileName);
    
        return view('event.generate_qr_code', [
            'qrCodeUrl' => $qrCodeUrl,
            'token' => $token,
            'agendaId' => $agendaId,
            'agendaBerakhir' => false,
            'belumWaktunya' => false,
            'agenda' => $agenda,
        ]);
    }
    // Method to generate the QR code via AJAX
    public function generateQRCode(Request $request)
    {
        $agendaId = $request->get('agenda_id');
    
        // Selalu buat token baru setiap kali permintaan AJAX dilakukan
        $token = Str::random(32);
        $expiry = Carbon::now()->addMinutes(3);
    
        // Hapus token lama yang sudah expired (opsional, untuk kebersihan)
        AgendaToken::where('agenda_id', $agendaId)
            ->where('expiry', '<', now())
            ->delete();
        
        // Buat token BARU (jangan replace yang lama!)
        AgendaToken::create([
            'agenda_id' => $agendaId,
            'token' => $token,
            'expiry' => $expiry
        ]);
    
        // Generate QR Code
        $qrData = [
            'agenda_id' => $agendaId,
            'token' => $token,
        ];
        $fileName = 'qr_codes/qr_code_' . $agendaId . '_' . time() . '.svg';
        Storage::disk('public')->put($fileName, QrCode::size(300)->generate(json_encode($qrData)));
    
        $qrCodeUrl = asset('storage/' . $fileName);
    
        return response()->json([
            'qrCodeUrl' => $qrCodeUrl,
            'token' => $token,
        ]);
    }
    public function checkTokenStatus(Request $request)
{
    $agendaId = $request->agenda_id;
    $token = $request->token;

    // cek apakah token sudah dipakai di AbsensiAgenda
    $used = AbsensiAgenda::where('agenda_id', $agendaId)
        ->where('token', $token)
        ->exists();

    return response()->json([
        'used' => $used
    ]);
}

}