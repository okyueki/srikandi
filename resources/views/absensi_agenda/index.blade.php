@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Agenda')

@section('content')

        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="agenda-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Tempat</th>
                                <th>Pimpinan Rapat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#agenda-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/absensi_agenda', // URL untuk mengambil data agenda
            columns: [
                { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }},
                { data: 'judul', name: 'judul' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'mulai', name: 'mulai' },
                { data: 'akhir', name: 'akhir' },
                { data: 'tempat', name: 'tempat' },
                { data: 'pimpinan_rapat', name: 'pimpinan_rapat' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection