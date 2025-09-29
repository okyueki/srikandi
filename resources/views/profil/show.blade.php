@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Profil')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Profil Pegawai</div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pegawai->nama }}</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $pegawai->nik }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pegawai->jk }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>{{ $pegawai->jbtn }}</td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td>{{ $pegawai->departemen_unit->nama_departemen ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pegawai->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Kota</th>
                            <td>{{ $pegawai->kota }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
