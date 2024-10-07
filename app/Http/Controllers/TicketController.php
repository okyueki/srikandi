<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Pegawai;
use App\Models\Departemen;
use App\Models\JenisPermintaan;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

public function create()
{
    $pegawai = Pegawai::all(); 
    $departemen = Departemen::on('server_74')->get(); 
    $inventaris = Inventaris::on('server_74')->get(); 
    $jenisPermintaan = JenisPermintaan::all(); 

    return view('tickets.create', compact('pegawai', 'departemen', 'inventaris', 'jenisPermintaan'));
}

public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
    'nik' => 'required|exists:server_74.pegawai,nik',
    'jenis_permintaan' => 'required|numeric',
    'prioritas' => 'required',
    'status' => 'required',
    'judul' => 'required|string',
    'deskripsi' => 'required|string',
    'tanggal' => 'required|date',
    'deadline' => 'nullable|date',
    'departemen' => 'required|string',
    'no_inventaris' => 'nullable|string',
    'no_hp' => 'required|string', 
    'upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);


        
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validatedData['upload'] = $filename;
        }

        Ticket::create($validatedData);

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput(); // Tampilkan error validasi
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
    }
}

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

public function edit($id)
{
    $ticket = Ticket::findOrFail($id);
    $pegawai = Pegawai::all();
    $departemen = Departemen::on('server_74')->get(); 
    $inventaris = Inventaris::on('server_74')->get(); 
    $jenisPermintaan = JenisPermintaan::all();

    return view('tickets.edit', compact('ticket', 'pegawai', 'departemen', 'inventaris', 'jenisPermintaan'));
}

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validatedData = $request->validate([
            'nik' => 'required',
            'jenis_permintaan' => 'required|numeric',
            'prioritas' => 'required',
            'status' => 'required',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'deadline' => 'nullable|date', // Opsional
            'departemen' => 'required|string',
            'no_inventaris' => 'nullable|string', // Opsional
            'no_hp' => 'nullable|string', // Opsional
            'upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opsional
        ]);

        // Handle file upload
        if ($request->hasFile('upload')) {
            // Hapus file lama jika ada
            if ($ticket->upload && file_exists(public_path('uploads/' . $ticket->upload))) {
                unlink(public_path('uploads/' . $ticket->upload));
            }

            // Simpan file baru
            $file = $request->file('upload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $validatedData['upload'] = $filename;
        }

        // Update data tiket
        $ticket->update($validatedData);

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Hapus file jika ada
        if ($ticket->upload && file_exists(public_path('uploads/' . $ticket->upload))) {
            unlink(public_path('uploads/' . $ticket->upload));
        }

        // Hapus tiket
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus!');
    }
    
public function getNoHp(Request $request)
{
    // Ambil NIK dari request
    $nik = $request->nik;

    // Cari No Telp dari tabel 'petugas' di database 'sik3'
    $no_telp = \DB::connection('server_74')->table('petugas')
                  ->where('nip', $nik) // Relasi NIP dari tabel 'petugas' dengan NIK
                  ->value('no_telp'); // Ambil kolom 'no_telp'

    // Kembalikan No Telp sebagai response JSON
    return response()->json(['no_hp' => $no_telp]);
}

}
