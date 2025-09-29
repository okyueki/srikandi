<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'User';
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('users.edit', $row->id).'" class="btn btn-info waves-effect waves-light"><i class="far fa-edit"></i></a>
                        <form action="'.route('users.destroy', $row->id).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger waves-effect waves-light" onclick="return confirmDelete(this)"><i class="far fa-trash-alt"></i></button>
                        </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        
        return view('users.index', compact('title'));
    }

    public function create()
    {
        $title = 'Create User';
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get();
        return view('users.create', compact('title', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'level' => 'required|in:Direktur,Kabag,Kabid,Kasie,Koordinator,Pelaksana,Komite',
        ]);

         // Extract the nik and nama from the pegawai_id
         $pegawaiData = explode(',', $request->input('pegawai_id'));
         $nama = $pegawaiData[1] ?? '';

        User::create([
            'name' => $nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $title = 'Edit User';
        $pegawai = Pegawai::where('stts_aktif', 'AKTIF')->get(); // Get active Pegawai for the dropdown
        return view('users.edit', compact('user','title','pegawai'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'password' => 'nullable|min:8',
            'level' => 'required|in:Direktur,Kabag,Kabid,Kasie,Koordinator,Pelaksana,Komite',
        ]);
         // Extract the nik and nama from the pegawai_id
        $pegawaiData = explode(',', $request->input('pegawai_id'));
        $nik = $pegawaiData[0];
        $nama = $pegawaiData[1] ?? '';

        $data = [
            'name' => $nama,
            'username' => $request->username,
            'level' => $request->level,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
