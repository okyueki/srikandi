@extends('layouts.pages-layouts')

@section('pageTitle', $pageTitle)

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">{{ $pageTitle }}</h3>
            <a href="{{ route('inventaris-barang.create') }}" class="btn btn-primary">Tambah Barang</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($data->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada data inventaris barang yang tersedia.
                </div>
            @else
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Produsen</th>
                            <th>Merk</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jml_barang }}</td>
                            <td>{{ optional($barang->produsen)->nama_produsen ?? 'Tidak Diketahui' }}</td>
                            <td>{{ optional($barang->merk)->nama_merk ?? 'Tidak Diketahui' }}</td>
                            <td>{{ optional($barang->kategori)->nama_kategori ?? 'Tidak Diketahui' }}</td>
                            <td>{{ optional($barang->jenis)->nama_jenis ?? 'Tidak Diketahui' }}</td>
                            <td class="d-flex">
                                <a href="{{ route('inventaris-barang.edit', $barang->kode_barang) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
                                <form action="{{ route('inventaris-barang.destroy', $barang->kode_barang) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Link Paginasi -->
                <div class="d-flex justify-content-center">
                    {{ $data->links('vendor.pagination.tabler') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
