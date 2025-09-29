<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Models\BudayaKerja;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BudayaKerjaController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $petugas = $user->username; // NIK user yang login
        $today = now()->toDateString(); // Ambil tanggal hari ini
    
        // Ambil NIK pegawai yang sudah memiliki data pada hari ini
        $nikSudahMengisi = BudayaKerja::whereDate('tanggal', $today)
            ->pluck('nik_pegawai'); // Ambil hanya NIK pegawai
    
        // Ambil pegawai yang AKTIF dan belum mengisi data hari ini
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')
            ->whereNotIn('nik', $nikSudahMengisi) // Filter pegawai yang belum mengisi
            ->get();
    
        return view('budayakerja.tambah', compact('pegawai', 'petugas'));
    }

    public function store(Request $request)
    {
        // Ambil data dari request
        $data = $request->all();

        $user = Auth::user();
        $petugas = $user->username; 
        $data['petugas'] = $petugas; 
    
        // Hitung total nilai
        $items = ['sepatu', 'sabuk', 'make_up', 'minyak_wangi', 'jilbab', 'kuku', 'baju', 'celana', 'name_tag', 'perhiasan', 'kaos_kaki'];
        $totalNilai = 0;
    
        foreach ($items as $item) {
            $totalNilai += $request->input($item, 0); // Default ke 0 jika tidak ada
        }
    
        $data['total_nilai'] = $totalNilai; // Menyimpan total nilai ke data
    
        try {
            BudayaKerja::create($data); // Simpan data ke database
            return redirect()->route('budayakerja.index')->with('success', 'Data berhasil disimpan!'); // Redirect ke index dengan pesan sukses
        } catch (\Exception $e) {
            // Tampilkan pesan error jika terjadi masalah
            dd($e->getMessage());
        }
    }

     public function index()
    {
        return view('budayakerja.index');
    }

   public function getData(Request $request)
{
    $query = BudayaKerja::query();

    // Filter berdasarkan rentang tanggal jika disediakan
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
    }

    // Daftar atribut dan labelnya
    $attributeLabels = [
        'sabuk' => 'Sabuk',
        'make_up' => 'Make Up',
        'minyak_wangi' => 'Minyak Wangi',
        'jilbab' => 'Jilbab',
        'kuku' => 'Kuku',
        'baju' => 'Baju',
        'celana' => 'Celana',
        'name_tag' => 'Name Tag',
        'perhiasan' => 'Perhiasan',
        'kaos_kaki' => 'Kaos Kaki'
    ];

    return DataTables::of($query)
        ->addColumn('keterangan', function ($item) use ($attributeLabels) {
            $itemsWithZero = [];

            // Cek atribut yang bernilai 0 dan gunakan label
            foreach ($attributeLabels as $attr => $label) {
                if ($item->$attr == 0) {
                    $itemsWithZero[] = $label;
                }
            }

            // Gabungkan menjadi string atau "-" jika kosong
            return empty($itemsWithZero) ? '-' : implode(', ', $itemsWithZero);
        })
        ->addColumn('action', function ($item) {
            $viewUrl = route('budayakerja.show', $item->id);
            $editUrl = route('budayakerja.edit', $item->id);
            $deleteUrl = route('budayakerja.destroy', $item->id);

            return '
                <a href="' . $viewUrl . '" class="btn btn-info btn-sm">Detail</a>
                <a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus?\')">Hapus</button>
                </form>
            ';
        })
        ->make(true);
}
    
    public function destroy($id)
    {
        try {
            // Temukan data berdasarkan ID
            $budayaKerja = BudayaKerja::findOrFail($id);
            
            // Hapus data
            $budayaKerja->delete();
    
            // Redirect ke index dengan pesan sukses
            return redirect()->route('budayakerja.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            // Tampilkan pesan error jika terjadi masalah
            return redirect()->route('budayakerja.index')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function show($id)
    {
        // Temukan data berdasarkan ID
        $budayaKerja = BudayaKerja::findOrFail($id);
    
        return view('budayakerja.show', compact('budayaKerja'));
    }
}