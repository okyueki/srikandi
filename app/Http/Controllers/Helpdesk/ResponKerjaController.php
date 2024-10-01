<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Pegawai;
use App\Models\ResponKerja;
use App\Models\Komentar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResponKerjaController extends Controller
{
    // Method untuk menampilkan form respon
    public function create($ticketId)
{
    // Ambil data tiket berdasarkan ID
    $ticket = Ticket::with('teknisiMenangani.pengguna')->findOrFail($ticketId);

    // Ambil data respon pertama yang ada untuk tiket ini
    $responKerja = ResponKerja::where('ticket_id', $ticket->id)->first();

    // Jika status tiket masih "Open" dan belum ada respon, ubah status menjadi "In Progress"
    if ($ticket->status == 'Open' && !$responKerja) {
        $ticket->status = 'In Progress';
        $ticket->response_time = Carbon::now(); // Menyimpan waktu respons saat tombol diklik
        $ticket->save();
    }

    // Ambil data pegawai untuk dropdown teknisi
    $pegawai = Pegawai::all();

    // Hitung response time hanya jika ticket->created_at dan ticket->response_time ada
    $waktuRespon = null;
    if ($ticket->created_at && $ticket->response_time) {
        $responseTime = $ticket->response_time instanceof Carbon 
                        ? $ticket->response_time 
                        : Carbon::parse($ticket->response_time);
        $waktuRespon = $responseTime->diffInMinutes($ticket->created_at);
    }

    // Kirim data respon jika ada, dan jika tidak ada, kirimkan objek baru
    return view('helpdesk.respon_helpdesk', compact('ticket', 'pegawai', 'waktuRespon', 'responKerja'));
}

    // Method untuk menyimpan respon
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'teknisi_id' => 'required',
            'deskripsi_hasil' => 'required',
            'status_akhir' => 'required',
            'tingkat_kesulitan' => 'required',
            'biaya' => 'nullable|numeric',
            'petunjuk_penyelesaian' => 'nullable|string',
            'foto_hasil' => 'nullable|image|max:2048',
        ]);

        // Mengambil data tiket
        $ticket = Ticket::findOrFail($ticketId);

        // Upload foto hasil jika ada
        if ($request->hasFile('foto_hasil')) {
            $fotoPath = $request->file('foto_hasil')->store('foto_hasil', 'public');
        }

        // Menyimpan data ke dalam tabel respon_kerja
        ResponKerja::create([
            'ticket_id' => $ticketId,
            'teknisi_id' => $request->input('teknisi_id'),
            'foto_hasil' => $fotoPath ?? null,
            'deskripsi_hasil' => $request->input('deskripsi_hasil'),
            'status_akhir' => $request->input('status_akhir'),
            'biaya' => $request->input('biaya'),
            'tingkat_kesulitan' => $request->input('tingkat_kesulitan'),
            'petunjuk_penyelesaian' => $request->input('petunjuk_penyelesaian'),
        ]);

        return redirect()->route('helpdesk.dashboard')->with('success', 'Respon teknisi berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'teknisi_id' => 'required',
        'deskripsi_hasil' => 'required',
        'status_akhir' => 'required',
        'tingkat_kesulitan' => 'required',
        'biaya' => 'nullable|numeric',
        'petunjuk_penyelesaian' => 'nullable|string',
        'foto_hasil' => 'nullable|image|max:2048',
    ]);

    // Ambil data respon kerja berdasarkan ID
    $responKerja = ResponKerja::findOrFail($id);

    // Upload foto hasil jika ada
    if ($request->hasFile('foto_hasil')) {
        $fotoPath = $request->file('foto_hasil')->store('foto_hasil', 'public');
    }

    // Perbarui data respon kerja
    $responKerja->update([
        'teknisi_id' => $request->input('teknisi_id'),
        'foto_hasil' => $fotoPath ?? $responKerja->foto_hasil,
        'deskripsi_hasil' => $request->input('deskripsi_hasil'),
        'status_akhir' => $request->input('status_akhir'),
        'biaya' => $request->input('biaya'),
        'tingkat_kesulitan' => $request->input('tingkat_kesulitan'),
        'petunjuk_penyelesaian' => $request->input('petunjuk_penyelesaian'),
    ]);

    return redirect()->route('helpdesk.dashboard')->with('success', 'Respon teknisi berhasil diperbarui.');
}

}
