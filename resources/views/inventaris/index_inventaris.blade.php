@extends('layouts.pages-layouts')

@section('pageTitle', 'Inventaris')

@section('content')
<div class="col-xl-12">
    <div class="card custom-card">
        <div class="card-header">
            <h3 class="card-title">Daftar Inventaris</h3>
        </div>
<div class="card-body">
    <div class="table-responsive">
        <div class="hstack gap-3">
            <!-- Tombol "Tambah Inventaris" -->
            <a href="{{ route('inventaris.create') }}" class="btn btn-primary">Tambah Inventaris</a>

            <!-- Dropdown Filter "Pilih Nama Ruang" -->
            <select name="ruang" id="ruang" class="js-example-basic-single form-control">
                <option value="">-- Pilih Nama Ruang --</option>
                @foreach($ruang as $r)
                    <option value="{{ $r->id_ruang }}" {{ request('ruang') == $r->id_ruang ? 'selected' : '' }}>
                        {{ $r->nama_ruang }}
                    </option>
                @endforeach
            </select>

            <!-- Input Text untuk Search -->
            <input type="text" name="search" id="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">

            <!-- Tombol "Filter" -->
            <button type="submit" id="filter-button" class="btn btn-secondary">Filter</button>
        </div>
    </div>
</div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered" id="inventaris-table">
                <thead>
                    <tr>
                        <th>No Inventaris</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Produsen</th>
                        <th>Merk</th>
                        <th>Nama Ruang</th>
                        <th>Asal Barang</th>
                        <th>Tanggal Pengadaan</th>
                        <th>Harga</th>
                        <th>Status Barang</th>
                        <th>Photo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.js-example-basic-single').select2();

        // Inisialisasi DataTables
        var table = $('#inventaris-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/inventaris',
                data: function(d) {
                    d.ruang = $('#ruang').val();
                    d.search = $('#search').val();
                }
            },
            columns: [
                { data: 'no_inventaris', name: 'no_inventaris' },
                { data: 'kode_barang', name: 'kode_barang' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'nama_produsen', name: 'nama_produsen' },
                { data: 'nama_merk', name: 'nama_merk' },
                { data: 'nama_ruang', name: 'nama_ruang' },
                { data: 'asal_barang', name: 'asal_barang' },
                { data: 'tgl_pengadaan', name: 'tgl_pengadaan' },
                { data: 'harga', name: 'harga' },
                { data: 'status_barang', name: 'status_barang' },
                { data: 'photo', name: 'photo', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Event listener untuk filter
        $('#filter-button').click(function() {
            table.draw(); // Memuat ulang data tabel sesuai filter
        });
    });
</script>
@endsection
