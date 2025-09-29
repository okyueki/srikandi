@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')

        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    <a href="{{ route('surat_masuk.create') }}" class="btn btn-success waves-effect waves-light mb-3">Create Surat Masuk</a>

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
    document.addEventListener('DOMContentLoaded', function () {
        $('#suratTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/surat_masuk',
                dataSrc: function(json) {
                    console.log(json); // Cek response dari server
                    return json.data; // Return data ke DataTables
                },
                columns: [
                    { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }},
                    { data: 'nama_pegawai', name: 'nama_pegawai' },
                    { data: 'perihal', name: 'perihal' },
                    { data: 'tanggal_surat', name: 'tanggal_surat', orderable: true },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[3, 'desc']], // Sort by tanggal_surat in descending order
                rowCallback: function(row, data, index) {
                        // Cek jika statusnya "Dikirim"
                        if (data.status_verifikasi === 'Dikirim') {
                            $(row).css('background-color', '#f9dedc'); // Warna kuning (warning)
                        }else if (data.status_disposisi === 'Dikirim') {
                            $(row).css('background-color', '#f9dedc'); // Warna kuning (warning)
                        }
                    }
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