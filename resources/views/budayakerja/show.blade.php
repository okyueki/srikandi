@extends('layouts.pages-layouts')

@section('pageTitle', 'Detail Penilaian Harian')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Penilaian Harian</h4>
                    </div>
                    <div class="card-body">
                        <h5>Tanggal: {{ $budayaKerja->tanggal }}</h5>
                        <h5>Jam: {{ $budayaKerja->jam }}</h5>
                        <h5>NIK Pegawai: {{ $budayaKerja->nik_pegawai }}</h5>
                        <h5>Nama Pegawai: {{ $budayaKerja->nama_pegawai }}</h5>
                        <h5>Departemen: {{ $budayaKerja->departemen }}</h5>
                        <h5>Jabatan: {{ $budayaKerja->jabatan }}</h5>
                        <h5>Shift: {{ $budayaKerja->shift }}</h5>
                        <h5>Total Nilai: {{ $budayaKerja->total_nilai }}</h5>
                        <h5>Petugas: {{ $budayaKerja->petugas }}</h5>

                        <h5>Item Penilaian:</h5>
                        <ul>
                            @foreach(['sepatu', 'sabuk', 'make_up', 'minyak_wangi', 'jilbab', 'kuku', 'baju', 'celana', 'name_tag', 'perhiasan', 'kaos_kaki'] as $item)
                                <li>
                                    {{ ucfirst(str_replace('_', ' ', $item)) }}: 
                                    {{ $budayaKerja->$item == 1 ? 'Sesuai' : 'Tidak Sesuai' }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('budayakerja.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection