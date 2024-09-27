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
        $struktur = StrukturOrganisasi::with('pegawai', 'atasan')->get();

        // Menyusun data ke dalam format hierarkis
        $hierarchy = $this->buildHierarchy($struktur);

        return view('struktur_organisasi.index', compact('hierarchy', 'title'));
    }
    private function buildHierarchy($items, $parentId = null)
    {
        $branch = [];

        foreach ($items as $item) {
            if ($item->nik_atasan_langsung == $parentId) {
                $children = $this->buildHierarchy($items, $item->nik);
                if ($children) {
                    $item->children = $children;
                }
                $branch[] = $item;
            }
        }

        return $branch;
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
        $title = 'Edit Struktur Organisasi';
        $struktur = StrukturOrganisasi::findOrFail($id);
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        $pegawai2 = Pegawai::where('stts_aktif', 'AKTIF')->get();
        return view('struktur_organisasi.edit', compact('struktur', 'pegawai','pegawai2','title'));
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
         // Hapus data dari database
        $struktur = StrukturOrganisasi::find($id);
        $struktur->delete();
        return redirect()->route('struktur_organisasi.index')->with('success', 'Sifat Surat deleted successfully.');
        
    }
}
