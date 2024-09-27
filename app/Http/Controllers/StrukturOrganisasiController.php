<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;
use App\Models\Pegawai;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $title = 'Struktur Organisasi';
        $strukturOrganisasi = StrukturOrganisasi::with(['pegawai', 'atasan'])->get();
        return view('struktur_organisasi.index', compact('strukturOrganisasi', 'title'));
    }

    public function create()
    {
        $title = 'Create Struktur Organisasi';
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        $pegawai2 = Pegawai::where('stts_aktif', 'AKTIF')->get();
        return view('struktur_organisasi.create', compact('pegawai','pegawai2','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'nik_atasan_langsung' => 'nullable|string|max:20',
        ]);

        StrukturOrganisasi::create($request->all());

        return redirect()->route('struktur_organisasi.index')->with('success', 'Data Struktur Organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        $pegawai2 = Pegawai::where('stts_aktif', 'AKTIF')->get();
        return view('struktur_organisasi.edit', compact('struktur', 'pegawai'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'nik_atasan_langsung' => 'nullable|string|max:20',
        ]);

        $struktur = StrukturOrganisasi::findOrFail($id);
        $struktur->update($request->all());

        return redirect()->route('struktur_organisasi.index')->with('success', 'Data Struktur Organisasi berhasil diubah.');
    }

    public function destroy($id)
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        $struktur->delete();

        return redirect()->route('struktur_organisasi.index')->with('success', 'Data Struktur Organisasi berhasil dihapus.');
    }

    public function getTreeData()
    {
        try {
            // Ambil data struktur organisasi
            $strukturOrganisasi = StrukturOrganisasi::all();
            \Log::info($strukturOrganisasi); // Debug log
    
            // Format data untuk jsTree
            $data = $this->formatTreeData($strukturOrganisasi);
        
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error fetching tree data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching tree data'], 500);
        }
    }
    public function show($id)
{
    $struktur = StrukturOrganisasi::findOrFail($id);
    return view('struktur_organisasi.show', compact('struktur'));
}

    private function formatTreeData($strukturOrganisasi)
    {
        $result = [];
        foreach ($strukturOrganisasi as $struktur) {
            $children = StrukturOrganisasi::where('nik_atasan_langsung', $struktur->nik)->get();
            $node = [
                'id' => $struktur->nik,
                'text' => 'NIK: ' . $struktur->nik,
                'children' => $this->formatTreeData($children)
            ];
            $result[] = $node;
        }
        return $result;
    }
}
