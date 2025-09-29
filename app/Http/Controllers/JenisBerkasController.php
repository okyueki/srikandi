<?php

namespace App\Http\Controllers;

use App\Models\JenisBerkas;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisBerkasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JenisBerkas::query();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('jenis_berkas.edit', $row->id_jenis_berkas);
                    $deleteUrl = route('jenis_berkas.destroy', $row->id_jenis_berkas);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger waves-effect waves-light delete-confirm"><i class="far fa-trash-alt"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $title = 'Jenis Berkas';
        return view('jenis_berkas.index', compact('title'));
    }

    public function create()
    {
        $title = 'Tambah Jenis Berkas';
        $bidang = Bidang::all();
        return view('jenis_berkas.create', compact('title','bidang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_berkas' => 'required|max:100',
            'bidang' => 'nullable|array',
            'masa_berlaku' => 'required|in:Iya,Tidak',
        ]);
        
        $data = $request->all();
        $data['bidang'] = $request->bidang ? implode(',', $request->bidang) : null;

        JenisBerkas::create($data);
       
        return redirect()->route('jenis_berkas.index')->with('success', 'Jenis berkas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenisBerkas = JenisBerkas::findOrFail($id);
        $title = 'Edit Jenis Berkas';
        $bidang = Bidang::all();
        return view('jenis_berkas.edit', compact('jenisBerkas', 'title', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_berkas' => 'required|max:100',
            'bidang' => 'nullable|array',
            'masa_berlaku' => 'required|in:Iya,Tidak',
        ]);
    
        $jenisBerkas = JenisBerkas::findOrFail($id);
        $data = $request->all();
        $data['bidang'] = $request->bidang ? implode(',', $request->bidang) : null;
    
        $jenisBerkas->update($data);
    
        return redirect()->route('jenis_berkas.index')->with('success', 'Jenis berkas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jenisBerkas = JenisBerkas::findOrFail($id);
        $jenisBerkas->delete();

        return redirect()->route('jenis_berkas.index')->with('success', 'Jenis berkas berhasil dihapus!');
    }
}
