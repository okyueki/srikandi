@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Penilaian Harian')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Penilaian Harian</h4>
                        <div class="card-actions">
                            <a href="{{ route('budayakerja.create') }}" class="btn btn-primary">Tambah Penilaian</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Filter Tanggal -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <input type="date" id="start_date" class="form-control" placeholder="Tanggal Mulai">
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="end_date" class="form-control" placeholder="Tanggal Sampai">
                            </div>
                            <div class="col-md-3">
                                <button id="filter" class="btn btn-primary">Filter</button>
                                <button id="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="budayaKerjaTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>NIK Pegawai</th>
                                        <th>Nama Pegawai</th>
                                        <th>Departemen</th>
                                        <th>Jabatan</th>
                                        <th>Shift</th>
                                        <th>Total Nilai</th>
                                        <th>Petugas</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
    // Set default dates to today's date
    var today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
    $('#start_date').val(today);
    $('#end_date').val(today);

    // Initialize DataTable
    var table = $('#budayaKerjaTable').DataTable({
        processing: true,  // Enable processing indicator
        serverSide: true,  // Enable server-side processing for large datasets
        ajax: {
            url: '/databudayakerja',  // The route for fetching data
            data: function(d) {
                d.start_date = $('#start_date').val();  // Send start date for filtering
                d.end_date = $('#end_date').val();  // Send end date for filtering
            }
        },
        columns: [
            { data: 'tanggal', name: 'tanggal' },
            { data: 'jam', name: 'jam' },
            { data: 'nik_pegawai', name: 'nik_pegawai' },
            { data: 'nama_pegawai', name: 'nama_pegawai' },
            { data: 'departemen', name: 'departemen' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'shift', name: 'shift' },
            { data: 'total_nilai', name: 'total_nilai' },
            { data: 'petugas', name: 'petugas' },
            { data: 'keterangan', name: 'keterangan', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Filter Button: Reload table with the filter applied
    $('#filter').click(function() {
        table.ajax.reload();
    });

    // Reset Button: Reset the date fields and reload table without filters
    $('#reset').click(function() {
        $('#start_date').val('');
        $('#end_date').val('');
        table.ajax.reload();
    });
});
</script>

@endsection