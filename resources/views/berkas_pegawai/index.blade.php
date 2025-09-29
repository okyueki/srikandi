@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
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
                <table class="table table-bordered" id="berkas-pegawai">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Bidang</th>
                            <th width="280px">Aksi</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#berkas-pegawai').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/berkas_pegawai',
            columns: [
                { data: null, name: 'no', searchable: false, orderable: false, render: function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { data: 'nama', name: 'nama' },
                { data: 'jbtn', name: 'jbtn' },
                { data: 'bidang', name: 'bidang' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
     document.addEventListener('DOMContentLoaded', function () {
        $(document).on('click', '.delete-btn', function () {
            var deleteUrl = $(this).data('url');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                            $('#datatable').DataTable().ajax.reload(); // Reload DataTables
                        },
                        error: function () {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>

@endsection