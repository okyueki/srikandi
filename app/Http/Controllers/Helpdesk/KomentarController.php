<?php

namespace App\Http\Controllers\Helpdesk;

use App\Http\Controllers\Controller;
use App\Models\Komentar; // Pastikan model Komentar diimpor dengan benar
use App\Models\Ticket;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'email' => 'required|email',
            'komentar' => 'required|string',
        ]);

        // Simpan komentar baru
        Komentar::create([
            'ticket_id' => $ticketId,
            'email' => $request->input('email'),
            'komentar' => $request->input('komentar'),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
