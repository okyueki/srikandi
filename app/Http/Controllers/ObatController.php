<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function formatNoRawat($no_rawat)
    {
        $year = substr($no_rawat, 0, 4);
        $month = substr($no_rawat, 4, 2);
        $day = substr($no_rawat, 6, 2);
        $id = substr($no_rawat, 8);

        $formatted_no_rawat = $year . '/' . $month . '/' . $day . '/' . $id;

        return $formatted_no_rawat;
    }
    // Menyimpan data obat baru
    public function store(Request $request, $no_rawat)
{
    $formatted_no_rawat = $this->formatNoRawat($no_rawat);

    $validated = $request->validate([
        'nama_obat'       => 'nullable|string',
        'dosis'           => 'nullable|string',
        'cara_pakai'      => 'nullable|string',
        'frekuensi'       => 'nullable|string',
        'fungsi_obat'     => 'nullable|string',
        'dosis_terakhir'  => 'nullable|string',
        'keterangan'      => 'nullable|string',
    ]);

    $validated['no_rawat'] = $formatted_no_rawat;

    // Jika kamu tidak pakai auto increment, kamu bisa set id_obat manual seperti ini
    // $validated['id_obat'] = Obat::max('id_obat') + 1;

    $obat = Obat::create($validated);

    return response()->json([
        'message' => 'Obat berhasil ditambahkan',
        'data'    => $obat,
    ]);
}

    // Mengupdate data obat
    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => 'nullable|string',
            'dosis' => 'nullable|string',
            'cara_pakai' => 'nullable|string',
            'frekuensi' => 'nullable|string',
            'fungsi_obat' => 'nullable|string',
            'dosis_terakhir' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $obat->update($validated);

        return response()->json(['message' => 'Obat berhasil diupdate']);
    }

    // Menghapus data obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return response()->json(['message' => 'Obat berhasil dihapus']);
    }
}
