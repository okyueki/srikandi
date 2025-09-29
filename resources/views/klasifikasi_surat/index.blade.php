@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    <a href="{{ route('klasifikasi_surat.create') }}" class="btn btn-success mb-3 waves-effect waves-light">Create Klasifikasi Surat</a>

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
                        <table class="table table-bordered" id="klasifikasi-surat-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Klasifikasi Surat</th>
                                    <th>Nama Klasifikasi Surat</th>
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
            $('#klasifikasi-surat-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/klasifikasi_surat',
                columns: [
                    { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }},
                    { data: 'kode_klasifikasi_surat', name: 'kode_klasifikasi_surat' },
                    { data: 'nama_klasifikasi_surat', name: 'nama_klasifikasi_surat' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });

        function confirmDelete(button) {
            event.preventDefault(); 
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
                    button.closest('form').submit();
                }
            });
        }
</script>
@endsection