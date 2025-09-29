<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateSurat;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class TataNaskahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $title = 'Tata Naskah';
    if (request()->ajax()) {
        $templateSurat = TemplateSurat::select(['id_template_surat', 'nama_template', 'deskripsi', 'file_template']);
        return DataTables::of($templateSurat)
            ->addColumn('action', function($row) {
                return '<a class="btn btn-info waves-effect waves-light" href="'.route('template_surat.edit', $row->id_template_surat).'"><i class="far fa-edit"></i></a> ' .
                       '<form action="'.route('template_surat.destroy', $row->id_template_surat).'" method="POST" style="display:inline;">' .
                       '<input type="hidden" name="_token" value="'.csrf_token().'">' .
                       '<input type="hidden" name="_method" value="DELETE">' .
                       '<button type="submit" class="btn btn-danger waves-effect waves-light"><i class="far fa-trash-alt"></i></button></form>';
            })
            ->addColumn('download', function($row) {
                $fileUrl = asset('uploads/templates/' . $row->file_template);
                return '<a class="btn btn-success waves-effect waves-light" href="' . $fileUrl . '" download><i class="fas fa-download"></i> Download</a>';
            })
            ->rawColumns(['action', 'download'])
            ->make(true);
    }

    return view('tata_naskah.index', compact('title'));
}
}