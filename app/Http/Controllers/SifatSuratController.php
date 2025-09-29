<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SifatSurat;

use Yajra\DataTables\DataTables;

class SifatSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = 'Sifat Surat';
        if (request()->ajax()) {
            $sifatSurat = SifatSurat::select(['id_sifat_surat', 'nama_sifat_surat']);
            return DataTables::of($sifatSurat)
                ->addColumn('action', function($row){
                    return '<a class="btn btn-info waves-effect waves-light" href="'.route('sifat_surat.edit', $row->id_sifat_surat).'"><i class="far fa-edit"></i></a> ' .
                           '<form action="'.route('sifat_surat.destroy', $row->id_sifat_surat).'" method="POST" style="display:inline;">' .
                           '<input type="hidden" name="_token" value="'.csrf_token().'">' .
                           '<input type="hidden" name="_method" value="DELETE">' .
                           '<button type="submit" class="btn btn-danger waves-effect waves-light"><i class="far fa-trash-alt"></i></button></form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sifat_surat.index', compact('title') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = 'Create Sifat Surat';
        return view('sifat_surat.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_sifat_surat' => 'required|string|max:255',
        ]);

        SifatSurat::create($request->all());

        return redirect()->route('sifat_surat.index')->with('success', 'Sifat Surat created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $title = 'Edit Sifat Surat';
        $sifatSurat = SifatSurat::findOrFail($id);
        return view('sifat_surat.edit', compact('sifatSurat','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama_sifat_surat' => 'required|string|max:255',
        ]);

        $sifatSurat = SifatSurat::findOrFail($id);
        $sifatSurat->update($request->all());

        return redirect()->route('sifat_surat.index')->with('success', 'Sifat Surat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $sifatSurat = SifatSurat::findOrFail($id);
        $sifatSurat->delete();

        return redirect()->route('sifat_surat.index')->with('success', 'Sifat Surat deleted successfully.');
    }
}
