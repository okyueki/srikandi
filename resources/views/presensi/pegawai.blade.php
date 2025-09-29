@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Data Pegawai')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pegawai</h3>
        </div>

        <div class="card-body">
            <!-- Form Pencarian dan Filter -->
            <form method="GET" action="{{ route('pegawai.index') }}" class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari NIK, Nama, Departemen" value="{{ request()->input('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="stts_aktif" class="form-control">
                        <option value="">Pilih Status Aktif</option>
                        <option value="AKTIF" {{ request()->input('stts_aktif') == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                        <option value="CUTI" {{ request()->input('stts_aktif') == 'CUTI' ? 'selected' : '' }}>CUTI</option>
                        <option value="KELUAR" {{ request()->input('stts_aktif') == 'KELUAR' ? 'selected' : '' }}>KELUAR</option>
                        <option value="TENAGA LUAR" {{ request()->input('stts_aktif') == 'TENAGA LUAR' ? 'selected' : '' }}>TENAGA LUAR</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="departemen" class="form-control" placeholder="Departemen" value="{{ request()->input('departemen') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Cari</button>
                </div>
            </form>

            <!-- Jumlah Pegawai -->
            <p>Total Pegawai: <strong>{{ $totalPegawai }}</strong></p>

            <!-- Tabel Pegawai -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>NPWP</th>
                        <th>Status Aktif</th>
                        <th>No KTP</th>
                        <th>Jumlah Pemeriksaan</th> <!-- Kolom baru -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawai as $pgw)
                        <tr>
                            <td>{{ $pgw->id }}</td>
                            <td>{{ $pgw->nik }}</td>
                            <td>{{ $pgw->nama }}</td>
                            <td>{{ $pgw->jbtn }}</td>
                            <td>{{ $pgw->indexinsDepartemen->nama ?? 'Tidak Diketahui' }}</td> <!-- Tampilkan nama departemen berdasarkan indexins -->
                            <td>{{ $pgw->npwp }}</td>
                            <td>{{ $pgw->stts_aktif }}</td>
                            <td>{{ $pgw->no_ktp }}</td>
                            <td>{{ $pgw->pemeriksaan_ralan_count }}</td> <!-- Jumlah pemeriksaan -->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data yang ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $pegawai->links('vendor.pagination.tabler') }}
            </div>
        </div>
    </div>
</div>
@endsection
