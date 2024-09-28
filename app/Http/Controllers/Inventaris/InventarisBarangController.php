<?php

namespace App\Http\Controllers\Inventaris;
use App\Http\Controllers\Controller; // Import Controller utama
use App\Models\InventarisBarang;
use App\Models\InventarisProdusen;
use App\Models\InventarisMerk;
use App\Models\InventarisKategori;
use App\Models\InventarisJenis;
use Illuminate\Http\Request;

class InventarisBarangController extends Controller
{
public function index()
{
    $data = InventarisBarang::with(['produsen', 'merk', 'kategori', 'jenis'])->paginate(10); // 10 item per halaman
    return view('inventaris.index_barang', compact('data'))->with('pageTitle', 'Inventaris Barang');
}

    public function create()
    {
    $produsen = InventarisProdusen::all();
    $merk = InventarisMerk::all();
    $kategori = InventarisKategori::all();
    $jenis = InventarisJenis::all();
    
    return view('inventaris.create_barang', compact('produsen', 'merk', 'kategori', 'jenis'))->with('pageTitle', 'Tambah Inventaris Barang');
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|max:20',
            'nama_barang' => 'required|max:60',
            'jml_barang' => 'required|integer',
            'kode_produsen' => 'required',
            'id_merk' => 'required',
            'thn_produksi' => 'required|digits:4',
            'isbn' => 'nullable|max:20',
            'id_kategori' => 'required',
            'id_jenis' => 'required'
        ]);

        InventarisBarang::create($request->all());

        return redirect()->route('inventaris-barang.index')->with('success', 'Inventaris Barang berhasil ditambahkan.');
    }

   public function edit($kode_barang)
{
    $barang = InventarisBarang::findOrFail($kode_barang);
    $produsen = InventarisProdusen::all();
    $merk = InventarisMerk::all();
    $kategori = InventarisKategori::all();
    $jenis = InventarisJenis::all();

    return view('inventaris.edit_barang', compact('barang', 'produsen', 'merk', 'kategori', 'jenis'))->with('pageTitle', 'Edit Inventaris Barang');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required|max:20',
            'nama_barang' => 'required|max:60',
            'jml_barang' => 'required|integer',
            'kode_produsen' => 'required',
            'id_merk' => 'required',
            'thn_produksi' => 'required|digits:4',
            'isbn' => 'nullable|max:20',
            'id_kategori' => 'required',
            'id_jenis' => 'required'
        ]);

        $barang = InventarisBarang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('inventaris-barang.index')->with('success', 'Inventaris Barang berhasil diperbarui.');
    }

    public function destroy($kode_barang)
{
    $barang = InventarisBarang::findOrFail($kode_barang); // Gunakan kode_barang sebagai parameter
    $barang->delete();

    return redirect()->route('inventaris-barang.index')->with('success', 'Inventaris Barang berhasil dihapus.');
}

}
