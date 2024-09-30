<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\ItemPenilaian;
use Illuminate\Http\Request;

class ItemPenilaianController extends Controller
{
    public function index()
    {
        $items = ItemPenilaian::all();
        return view('budayakerja.item_index', compact('items'));
    }

    public function create()
    {
        return view('budayakerja.item_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'bobot_nilai' => 'required|integer',
        ]);

        ItemPenilaian::create($request->all());

        return redirect()->route('item_penilaian.index')->with('success', 'Item penilaian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = ItemPenilaian::findOrFail($id);
        return view('budayakerja.item_edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'bobot_nilai' => 'required|integer',
        ]);

        $item = ItemPenilaian::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('item_penilaian.index')->with('success', 'Item penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = ItemPenilaian::findOrFail($id);
        $item->delete();

        return redirect()->route('item_penilaian.index')->with('success', 'Item penilaian berhasil dihapus.');
    }
}