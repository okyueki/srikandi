<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Ticket; // Pastikan model Ticket sudah ada
use Illuminate\Http\Request;

class HelpdeskController extends Controller
{
    // Method untuk menampilkan data ticket
     public function index()
    {
        // Mengambil data tickets beserta relasi pegawai
        $tickets = Ticket::with(['pegawai', 'teknisi', 'inventaris.barang','responKerja'])->get();

        return view('helpdesk.dashboard', compact('tickets'));
    }
    
    public function show($id)
{
    // Ambil data tiket berdasarkan ID
    $ticket = Ticket::findOrFail($id);

    // Kirim data tiket ke view
    return view('helpdesk.show_helpdesk', compact('ticket'));
}


}
