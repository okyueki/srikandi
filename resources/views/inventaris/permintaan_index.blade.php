@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Permintaan Perbaikan Inventaris')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Daftar Permintaan Perbaikan Inventaris</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('permintaan.create') }}" class="btn btn-primary">Buat Permintaan Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-xl">
    <div class="row row-cards">
        @foreach($permintaans as $permintaan)
        <div class="col-sm-6 col-lg-4"> <!-- Menampilkan 3 card per row pada layar besar -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">No Permintaan: {{ $permintaan->no_permintaan }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>No Inventaris:</strong> {{ $permintaan->inventaris->no_inventaris ?? 'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Kode Barang:</strong> {{ $permintaan->inventaris->kode_barang ?? 'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Nama Pegawai:</strong> {{ $permintaan->pegawai->nama ?? 'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Tanggal:</strong> {{ $permintaan->tanggal }}
                    </div>
                    <div class="mb-2">
                        <strong>Response Time:</strong> 
                        @if(isset($permintaan->response_time))
                            {{ $permintaan->response_time }} menit
                        @else
                            Belum Direspon
                        @endif
                    </div>
                    <div class="mb-2">
                        <strong>Prioritas</strong> {{ $permintaan->prioritas }}
                    </div>
                    <div class="mb-2">
                        <strong>Status</strong> {{ $permintaan->status }}
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('permintaan.edit', $permintaan->no_permintaan) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Actions</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('perbaikan.start', $permintaan->no_permintaan) }}">Mulai Perbaikan</a>
                            <form action="{{ route('permintaan.destroy', $permintaan->no_permintaan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item" type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection