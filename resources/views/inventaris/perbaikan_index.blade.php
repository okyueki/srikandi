@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Perbaikan Inventaris')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Daftar Perbaikan Inventaris
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('perbaikan.create') }}" class="btn btn-primary">
                        Tambah Perbaikan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-xl">
    <div class="card">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>No Permintaan</th>
                        <th>Tanggal</th>
                        <th>Uraian Kegiatan</th>
                        <th>Pelaksana</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perbaikans as $perbaikan)
                        <tr>
                            <td>{{ $perbaikan->no_permintaan }}</td>
                            <td>{{ $perbaikan->tanggal }}</td>
                            <td>{{ $perbaikan->uraian_kegiatan }}</td>
                            <td>{{ $perbaikan->pelaksana }}</td>
                            <td>{{ $perbaikan->biaya }}</td>
                            <td>{{ $perbaikan->status }}</td>
                            <td class="text-end">
                                <span class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle align-text-top" data-bs-toggle="dropdown">Actions</button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('perbaikan.edit', $perbaikan->no_permintaan) }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('perbaikan.destroy', $perbaikan->no_permintaan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $perbaikans->links() }}
    </div>
</div>
@endsection
