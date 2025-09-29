@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Temporary Presensi')

@section('content')
<div class="col-xl-12">
    <div class="card custom-card">
        <div class="card-body">
            <h3 class="card-title">Temporary Presensi</h3>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('presensi.index') }}">
                <div class="row">
                    <!-- Filter Jabatan -->
                    <div class="col-md-3">
                        <select name="jabatan" class="js-example-basic-single4 form-control">
                            <option value="">Semua Jabatan</option>
                            @foreach($allJabatan as $jabatan)
                                <option value="{{ $jabatan }}" {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                                    {{ $jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Filter Departemen -->
                    <div class="col-md-3">
                        <label for="departemen" class="form-label">Departemen</label>
                        <select id="departemen" name="departemen" class="js-example-basic-single2 form-control">
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($allDepartemen as $departemen)
                                <option value="{{ $departemen }}" {{ request('departemen') == $departemen ? 'selected' : '' }}>
                                    {{ $departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Pencarian Nama -->
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama" value="{{ request('search') }}">
                    </div>

                    <!-- Tombol Cari -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

            <h3>Presensi Masuk</h3>
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>Shift</th>
                        <th>Ruangan</th>
                        <th>Jam Datang</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presensi as $data)
                    <tr>
                        <td>{{ $data->pegawai->id }}</td>
                        <td>{{ $data->pegawai->nama }}</td>
                        <td>{{ $data->pegawai->jbtn }}</td>
                        <td>{{ $data->pegawai->departemen }}</td>
                        <td>{{ $data->shift }}</td>
                        <td>{{ $data->pegawai->bidang }}</td>
                        <td>{{ $data->jam_datang }}</td>
                        <td>
                            <a href="{{ route('presensi.verifikasi', $data->id) }}" class="btn btn-success btn-xs">
                                <i class="fa fa-home"></i> <span class="hidden-xs">Verif</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $presensi->links('vendor.pagination.tabler') }}
</div>

<script>
    $(document).ready(function() {
    // Inisialisasi Select2 untuk Jabatan dan Departemen
    $('.js-example-basic-single4').select2();
    $('.js-example-basic-single5').select2();
});
</script>
@endsection
