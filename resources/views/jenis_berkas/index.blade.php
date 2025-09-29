@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <a href="{{ route('jenis_berkas.create') }}" class="btn btn-success waves-effect waves-light mb-3">Tambah Jenis Berkas</a>

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
                <table class="table table-bordered" id="jenis-berkas-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Berkas</th>
                            <th>Bidang</th>
                            <th>Masa Berlaku</th>
                            <th width="280px">Aksi</th>
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
    $(function () {
        $('#jenis-berkas-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: /jenis_berkas',
            columns: [
                { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'jenis_berkas', name: 'jenis_berkas' },
                { data: 'bidang', name: 'bidang' },
                { data: 'masa_berlaku', name: 'masa_berlaku', render: function(data, type, row) {
                    var badgeClass = data === 'Iya' ? 'badge bg-success' : 'badge bg-danger';
                    return '<span style="font-size: 14px;" class="' + badgeClass + '">' + data + '</span>';
                }},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    $(document).on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
</script>
@endsection
