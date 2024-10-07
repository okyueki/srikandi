<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\TicketTeknisi;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketTeknisiController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'teknisi_id' => 'required|string',
        ]);

        // Cek apakah teknisi sudah ada di tiket ini
        $existing = TicketTeknisi::where('ticket_id', $ticketId)
                                 ->where('teknisi_id', $request->input('teknisi_id'))
                                 ->first();

        if ($existing) {
            return redirect()->back()->with('warning', 'Teknisi ini sudah ditambahkan pada tiket ini.');
        }

        // Tambahkan teknisi ke tiket
        TicketTeknisi::create([
            'ticket_id' => $ticketId,
            'teknisi_id' => $request->input('teknisi_id'),
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil ditambahkan.');
    }
}
