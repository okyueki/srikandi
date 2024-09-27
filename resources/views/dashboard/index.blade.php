@extends('layouts.pages-layouts')

@section('title', $title ?? 'Welcome Page')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Temporary Presensi</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Shift</th>
                                    <th>Jam Datang</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                    <th>Keterlambatan</th>
                                    <th>Durasi</th>
                                    <th>Foto</th>
                                    <th>Aksi</th> <!-- Tambahkan kolom aksi -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($presensi as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->pegawai->nik ?? '-' }}</td>
                                    <td>{{ $item->pegawai->nama ?? '-' }}</td>
                                    <td>{{ $item->shift }}</td>
                                    <td>{{ $item->jam_datang }}</td>
                                    <td>{{ $item->jam_pulang }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->keterlambatan }}</td>
                                    <td>{{ $item->durasi }}</td>
                                    <td><img src="{{ asset('storage/'.$item->photo) }}" alt="Foto" width="100"></td>
                                    <td>
                                        <!-- Tombol Jam Datang -->
                                        <form action="{{ route('presensi.updateJamDatang', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">Datang</button>
                                        </form>
                                        
                                        <!-- Tombol Jam Pulang -->
                                        <form action="{{ route('presensi.updateJamPulang', $item->id) }}" method="POST" style="margin-top: 5px;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">Pulang</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection
