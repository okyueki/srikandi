@extends('layouts.pages-layouts')

@section('pageTitle', 'Detail Inventaris')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Inventaris</h3>
            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary float-right">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>No Inventaris</th>
                    <td>{{ $inventaris->no_inventaris }}</td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $inventaris->kode_barang }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $inventaris->barang->nama_barang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Produsen</th>
                    <td>{{ optional($inventaris->barang->produsen)->nama_produsen ?? 'Tidak Diketahui' }}</td>
                </tr>
                <tr>
                    <th>Merk</th>
                    <td>{{ optional($inventaris->barang->merk)->nama_merk ?? 'Tidak Diketahui' }}</td>
                </tr>
                <tr>
                    <th>Nama Ruang</th>
                    <td>{{ optional($inventaris->ruang)->nama_ruang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Asal Barang</th>
                    <td>{{ $inventaris->asal_barang }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td>{{ $inventaris->tgl_pengadaan }}</td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>{{ number_format($inventaris->harga, 2) }}</td>
                </tr>
                <tr>
                    <th>Status Barang</th>
                    <td>{{ $inventaris->status_barang }}</td>
                </tr>
                <tr>
                    <th>ID Ruang</th>
                    <td>{{ $inventaris->id_ruang }}</td>
                </tr>
                <tr>
                    <th>No Rak</th>
                    <td>{{ $inventaris->no_rak }}</td>
                </tr>
                <tr>
                    <th>No Box</th>
                    <td>{{ $inventaris->no_box }}</td>
                </tr>
            </table>

            <h4>Gambar Inventaris</h4>
            <div class="row">
                @foreach ($inventaris->gambar as $gambar)
                    <div class="col-md-3">
                        <img src="http://192.168.10.74/webapps2/inventaris/{{ $gambar->photo }}" class="img-fluid" alt="Gambar Inventaris">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
