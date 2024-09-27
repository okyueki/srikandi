@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')

        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <a href="{{ route('sifat_surat.create') }}" class="btn btn-success waves-effect waves-light mb-3">Create Sifat Surat</a>

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

                        <table class="table table-bordered" id="sifat-surat-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sifat Surat</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->
<script>
        $(document).ready(function() {
    $('#sifat-surat-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('sifat_surat.index') }}',
        columns: [
            { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                return meta.row + 1;
            }},
            { data: 'nama_sifat_surat', name: 'nama_sifat_surat' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $('#sifat-surat-table').on('click', '.btn-danger', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection