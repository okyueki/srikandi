<?php
namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
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
    
    // public function index(Request $request, $no_rawat)
    // {
    //     $formatted_no_rawat = $this->formatNoRawat($no_rawat);
    //   $tindakan = Tindakan::where('no_rawat', $formatted_no_rawat)->get();
    //     return view('tindakan.index', compact('tindakan'));
    // }

    public function store(Request $request, $no_rawat)
    {
         $formatted_no_rawat = $this->formatNoRawat($no_rawat);

        $request->validate([
            'tindakan' => 'required|string',
            'tanggal' => 'required|date',
        ]);
    
        $data = Tindakan::create([
            'no_rawat' => $formatted_no_rawat,
            'tindakan' => $request->tindakan,
            'tanggal' => $request->tanggal,
        ]);
    
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tindakan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $data = Tindakan::findOrFail($id);
        $data->update($request->only('tindakan', 'tanggal'));

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = Tindakan::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tindakan dihapus'
        ]);
    }
}