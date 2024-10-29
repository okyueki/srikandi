<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateSurat;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class TemplateSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Template Surat';
        if (request()->ajax()) {
            $templateSurat = TemplateSurat::select(['id_template_surat', 'nama_template', 'deskripsi', 'file_template']);
            return DataTables::of($templateSurat)
                ->addColumn('action', function($row){
                    return '<a class="btn btn-info waves-effect waves-light" href="'.route('template_surat.edit', $row->id_template_surat).'"><i class="far fa-edit"></i></a> ' .
                           '<form action="'.route('template_surat.destroy', $row->id_template_surat).'" method="POST" style="display:inline;">' .
                           '<input type="hidden" name="_token" value="'.csrf_token().'">' .
                           '<input type="hidden" name="_method" value="DELETE">' .
                           '<button type="submit" class="btn btn-danger waves-effect waves-light"><i class="far fa-trash-alt"></i></button></form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('template_surat.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Template Surat';
        return view('template_surat.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_template' => 'required|file|mimes:docx',
        ]);

        // Upload file template
        $filePath = $request->file('file_template')->store('uploads/templates', 'public');

        TemplateSurat::create([
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
            'file_template' => $filePath,
        ]);

       return redirect()->route('template_surat.index')->with('success', 'Template Surat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Template Surat';
        $templateSurat = TemplateSurat::findOrFail($id);
        return view('template_surat.edit', compact('templateSurat', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_template' => 'nullable|file|mimes:docx',
        ]);

        $templateSurat = TemplateSurat::findOrFail($id);

        // Update file template jika ada file yang diupload
        if ($request->hasFile('file_template')) {
            // Hapus file lama
            if ($templateSurat->file_template) {
                Storage::disk('public')->delete($templateSurat->file_template);
            }
            // Upload file baru
            $filePath = $request->file('file_template')->store('uploads/templates', 'public');
            $templateSurat->file_template = $filePath;
        }

        $templateSurat->update([
            'nama_template' => $request->nama_template,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('template_surat.index')->with('success', 'Template Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $templateSurat = TemplateSurat::findOrFail($id);

        // Hapus file template
        if ($templateSurat->file_template) {
            Storage::disk('public')->delete($templateSurat->file_template);
        }

        $templateSurat->delete();

        return redirect()->route('template_surat.index')->with('success', 'Template Surat berhasil dihapus.');
    }
}
