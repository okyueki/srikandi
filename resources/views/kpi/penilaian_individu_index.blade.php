@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title)

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    {{ $title }}
                </div>
                <div class="prism-toggle">
                    <button class="btn btn-sm btn-primary-light" onclick="window.location='{{ route('penilaian_individu.create') }}'">
                        <i class="ri-add-line align-middle me-1"></i>Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Bulan Penilaian</th>
                                <th scope="col">NIK Atasan</th>
                                <th scope="col">Nama Atasan</th>
                                <th scope="col">NIK Bawahan</th>
                                <th scope="col">Nama Bawahan</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Total Nilai</th>
                                <th scope="col">Total Persentase</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penilaians as $index => $penilaian)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $penilaian->tanggal }}</td>
                                    <td>{{ $penilaian->penilaian_bulan }}</td>
                                    <td>{{ $penilaian->nik_atasan }}</td>
                                    <td>{{ $penilaian->nama_atasan }}</td>
                                    <td>{{ $penilaian->nik_bawahan }}</td>
                                    <td>{{ $penilaian->nama_bawahan }}</td>
                                    <td>{{ $penilaian->departemen }}</td>
                                    <td>{{ $penilaian->total_nilai }}</td>
                                    <td>{{ $penilaian->total_persentase }}%</td>
                                    <td>
                                        <div class="btn-list">
                                            <a href="{{ route('kpi.penilaian.show', $penilaian->id) }}" class="btn btn-sm btn-info btn-wave waves-effect waves-light">
                                                <i class="ri-eye-line align-middle me-2 d-inline-block"></i>Detail
                                            </a>
                                            <a href="{{ route('kpi.penilaian.edit', $penilaian->id) }}" class="btn btn-sm btn-warning btn-wave waves-effect waves-light">
                                                <i class="ri-edit-line align-middle me-2 d-inline-block"></i>Edit
                                            </a>
                                            <form action="{{ route('kpi.penilaian.destroy', $penilaian->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-wave waves-effect waves-light">
                                                    <i class="ri-delete-bin-line align-middle me-2 d-inline-block"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada data penilaian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection
