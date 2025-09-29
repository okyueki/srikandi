@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <a href="{{ route('cuti.create') }}" class="btn btn-success waves-effect waves-light mb-3">Create Cuti</a>

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
                        <table class="table table-bordered" id="cuti-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Pengajuan</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
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
            $('#cuti-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/cuti',
                columns: [
                    { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }},
                    { data: 'jenis_pengajuan_libur', name: 'jenis_pengajuan_libur' },
                    { data: 'nama_pegawai', name: 'nama_pegawai' },
                    { data: 'tanggal_awal', name: 'tanggal_awal' },
                    { data: 'tanggal_akhir', name: 'tanggal_akhir' },
                    { data: 'jumlah_hari', name: 'jumlah_hari' },
                    { data: 'status', name: 'status', render: function (data, type, row) {
                    var badgeClass = '';
                    switch(data) {
                        case 'Dikirim':
                            badgeClass = 'badge bg-warning';
                            break;
                        case 'Disetujui':
                            badgeClass = 'badge bg-success';
                            break;
                        case 'Ditolak':
                            badgeClass = 'badge bg-danger';
                            break;
                        default:
                            badgeClass = 'badge bg-secondary';
                    }
                    return '<span style="font-size: 14px;" class="' + badgeClass + '">' + data + '</span>';
                }},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
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
        });
    </script>
@endsection