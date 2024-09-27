<?php

namespace App\Http\Controllers;

use App\Models\KlasifikasiSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KlasifikasiSuratController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Klasifikasi Surat';
        if ($request->ajax()) {
            $data = KlasifikasiSurat::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '
                        <a href="'.route('klasifikasi_surat.edit', $row->id_klasifikasi_surat).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                        <form action="'.route('klasifikasi_surat.destroy', $row->id_klasifikasi_surat).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="return confirmDelete(this)"><i class="far fa-trash-alt"></i></button>
                        </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('klasifikasi_surat.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create Klasifikasi Surat';
        return view('klasifikasi_surat.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_klasifikasi_surat' => 'required',
            'nama_klasifikasi_surat' => 'required',
        ]);

        KlasifikasiSurat::create($request->all());

        return redirect()->route('klasifikasi_surat.index')
                         ->with('success', 'Klasifikasi Surat created successfully.');
    }

    public function show(KlasifikasiSurat $klasifikasiSurat)
    {
       
    }

    public function edit(KlasifikasiSurat $klasifikasiSurat)
    {
        $title = 'Edit Klasifikasi Surat';
        return view('klasifikasi_surat.edit', compact('klasifikasiSurat', 'title'));
    }

    public function update(Request $request, KlasifikasiSurat $klasifikasiSurat)
    {
        $request->validate([
            'kode_klasifikasi_surat' => 'required',
            'nama_klasifikasi_surat' => 'required',
        ]);

        $klasifikasiSurat->update($request->all());

        return redirect()->route('klasifikasi_surat.index')
                         ->with('success', 'Klasifikasi Surat updated successfully.');
    }

    public function destroy(KlasifikasiSurat $klasifikasiSurat)
    {
        $klasifikasiSurat->delete();

        return redirect()->route('klasifikasi_surat.index')
                         ->with('success', 'Klasifikasi Surat deleted successfully.');
    }
}