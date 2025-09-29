<?php
namespace App\Http\Controllers\KamarInap;

use App\Http\Controllers\Controller;
use App\Models\AdimeGizi;
use App\Models\RegPeriksa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AdimeGiziController extends Controller
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

    public function index(Request $request, $no_rawat)
    {
        $formatted_no_rawat = $this->formatNoRawat($no_rawat);
        //echo $formatted_no_rawat;
        if ($formatted_no_rawat) {
            $adimeGizi = AdimeGizi::where('no_rawat', $formatted_no_rawat)->with('pegawai')->get();
        } else {
            $adimeGizi = AdimeGizi::with('pegawai')->all();
        }
        return view('adimegizi.index', compact('adimeGizi','no_rawat'));

    }
    public function create(Request $request,$no_rawat)
    {
        $formatted_no_rawat = $this->formatNoRawat($no_rawat);
        $hariIni = date('Y-m-d H:i:s');
        $regPeriksa = RegPeriksa::with('pasien')->where('no_rawat', $formatted_no_rawat)->first();
        return view('adimegizi.create',compact('regPeriksa','hariIni','no_rawat'));
    }

    public function store(Request $request)
    {
        $nik = Auth::user()->username;
    
        $request->validate([
            'no_rawat' => 'required',
            'tanggal' => 'required',
            'asesmen' => 'required',
            'diagnosis' => 'required',
            'intervensi' => 'required',
            'monitoring' => 'required',
            'evaluasi' => 'required',
            'instruksi' => 'required',
            // 'nip' => 'required', // HAPUS ini karena 'nip' diisi otomatis
        ]);
    
        // Gabungkan input form dengan NIP dari user yang login
        $data = $request->only([
            'no_rawat', 'tanggal', 'asesmen', 'diagnosis',
            'intervensi', 'monitoring', 'evaluasi', 'instruksi'
        ]);
        $data['nip'] = $nik;
    
        AdimeGizi::create($data);
    
        $no_rawat = str_replace('/', '', $request->no_rawat);
        return redirect()->route('adimegizi.index', $no_rawat)
            ->with('success', 'Adime Gizi created successfully.');
    }

    // public function show(AdimeGizi $adimeGizi)
    // {
    //     return view('adimegizi.show', compact('adimeGizi'));
    // }

    public function edit($no_rawat,$tanggal)
    {
        $formatted_no_rawat = $this->formatNoRawat($no_rawat);
        //echo $formatted_no_rawat;
        $adimeGizi = AdimeGizi::where('no_rawat', $formatted_no_rawat)->whereDate('tanggal', $tanggal)->with('pegawai')->first();
        return view('adimegizi.edit', compact('adimeGizi','no_rawat'));
    }

       public function update(Request $request, $no_rawat, $tanggal)
    {
        $nik = Auth::user()->username;
    
        $request->validate([
            'no_rawat' => 'required',
            'tanggal' => 'required|date',
            'asesmen' => 'required',
            'diagnosis' => 'required',
            'intervensi' => 'required',
            'monitoring' => 'required',
            'evaluasi' => 'required',
            'instruksi' => 'required',
            // jangan validasi 'nip'
        ]);
    
        $formatted_no_rawat = $this->formatNoRawat($no_rawat);
    
        $adimeGizi = AdimeGizi::where('no_rawat', $formatted_no_rawat)
            ->whereDate('tanggal', $tanggal)
            ->firstOrFail();
    
        // Ambil input valid, lalu tambahkan 'nip' dari user login
        $data = $request->only([
            'no_rawat', 'tanggal', 'asesmen', 'diagnosis',
            'intervensi', 'monitoring', 'evaluasi', 'instruksi'
        ]);
        $data['nip'] = $nik;
    
        $adimeGizi->update($data);
    
        return redirect()->route('adimegizi.index', str_replace('/', '', $no_rawat))
            ->with('success', 'Adime Gizi updated successfully.');
    }

    public function destroy($no_rawat,$tanggal)
    {
        $formatted_no_rawat = $this->formatNoRawat($no_rawat);
        $adimeGizi = AdimeGizi::where('no_rawat', $formatted_no_rawat)->whereDate('tanggal', $tanggal)->firstOrFail();
        $adimeGizi->delete();

        return redirect()->route('adimegizi.index', compact('no_rawat'))
            ->with('success', 'Adime Gizi deleted successfully.');
    }
}