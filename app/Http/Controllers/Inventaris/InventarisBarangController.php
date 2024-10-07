<?php

namespace App\Http\Controllers\Inventaris;
use App\Http\Controllers\Controller; 
use App\Models\InventarisBarang;
use App\Models\InventarisProdusen;
use App\Models\InventarisMerk;
use App\Models\InventarisKategori;
use App\Models\InventarisJenis;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class InventarisBarangController extends Controller
{

public function index(Request $request)
{
    // Cek apakah permintaan dari DataTables (AJAX request)
    if ($request->ajax()) {
        $data = InventarisBarang::with(['produsen', 'merk', 'kategori', 'jenis'])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('produsen', function($row) {
                return optional($row->produsen)->nama_produsen ?? 'Tidak Diketahui';
            })
            ->addColumn('merk', function($row) {
                return optional($row->merk)->nama_merk ?? 'Tidak Diketahui';
            })
            ->addColumn('kategori', function($row) {
                return optional($row->kategori)->nama_kategori ?? 'Tidak Diketahui';
            })
            ->addColumn('jenis', function($row) {
                return optional($row->jenis)->nama_jenis ?? 'Tidak Diketahui';
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('inventaris-barang.edit', $row->kode_barang).'" class="btn btn-warning btn-sm mr-2">Edit</a>';
                $btn .= '<form action="'.route('inventaris-barang.destroy', $row->kode_barang).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                         </form>';
                return $btn;
            })
            ->rawColumns(['action']) // Agar kolom action tidak di-escape HTML-nya
            ->make(true);
    }

    // Jika bukan permintaan AJAX, kembalikan view
    return view('inventaris.index_barang')->with('pageTitle', 'Inventaris Barang');
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
