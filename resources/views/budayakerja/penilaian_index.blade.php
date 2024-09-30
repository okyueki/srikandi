@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Penilaian')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">

                <div class="card-header">
                    <h3 class="card-title">Daftar Penilaian Harian</h3>
                </div>

                <!-- Date Filter Form and Action Buttons in One Line -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <!-- Date Filter Form -->
                    <form method="GET" action="{{ route('penilaian.index') }}" class="d-flex gap-2 align-items-center">
                        <div class="form-group mb-0">
                            <input type="date" name="start_date" class="form-control" placeholder="Tanggal Mulai" value="{{ request('start_date') }}">
                        </div>
                        <div class="form-group mb-0">
                            <input type="date" name="end_date" class="form-control" placeholder="Tanggal Selesai" value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>

                    <!-- Action Buttons (Rekapitulasi and Tambah Penilaian) -->
                    <div class="d-flex gap-2">
                        <form action="{{ route('rekapitulasi.bulanan') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Rekapitulasi Bulanan</button>
                        </form>
                        <a href="{{ route('penilaian.create') }}" class="btn btn-primary">Tambah Penilaian</a>
                    </div>
                </div>

                <!-- Filtered Results Table -->
                <table class="table table-bordered table-hover" id="penilaian-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Detail Penilaian</th>
                            <th>Total Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat secara dinamis oleh DataTables -->
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan AJAX
        var table = $('#penilaian-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('penilaian.index') }}',
                data: function (d) {
                    d.start_date = $('input[name="start_date"]').val();
                    d.end_date = $('input[name="end_date"]').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Kolom nomor urut
                { data: 'tanggal_penilaian', name: 'tanggal_penilaian' },
                { data: 'waktu_penilaian', name: 'waktu_penilaian' },
                { data: 'nama', name: 'nama' },
                { data: 'departemen', name: 'departemen' },
                { data: 'detail_penilaian', name: 'detail_penilaian', orderable: false, searchable: false },
                { data: 'total_nilai', name: 'total_nilai' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Filter berdasarkan tanggal
        $('form').on('submit', function(e) {
            e.preventDefault();
            table.draw();
        });
    });
</script>
@endsection
