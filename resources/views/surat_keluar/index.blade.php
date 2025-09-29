@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')

        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <a href="{{ route('surat_keluar.create') }}" class="btn btn-success me-2">
                            Create Surat Keluar
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Template Surat
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($templateSurat as $ts)
                                <li><a class="dropdown-item" href="{{ asset('storage/' . $ts->file_template) }}">{{ $ts->nama_template }}</a></li>
                                @endforeach        
                            </ul>
                        </div>
                    </div>
                        @if ($message = Session::get('success'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: '{{ $message }}',
                                        confirmButtonText: 'OK'
                                    });
                                });
                            </script>
                        @endif
                        <div class="table-responsive">
                        <table class="table table-bordered" id="suratTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pengirim</th>
                                    <th>Perihal</th>
                                    <th>Tanggal Surat</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->
<script>
        $(document).ready(function() {
    $('#suratTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/surat_keluar',
        columns: [
            
             { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                return meta.row + 1;
            }},
            { data: 'nama_pegawai', name: 'nama_pegawai' },
            { data: 'perihal', name: 'perihal' },
            { data: 'tanggal_surat', name: 'tanggal_surat' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[3, 'desc']] // Urutkan kolom ke-4 (index 3, yaitu tanggal_surat) secara descending
    });

    $('#suratTable').on('click', '.deletesurat', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak akan dapat mengembalikan ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>
@endsection