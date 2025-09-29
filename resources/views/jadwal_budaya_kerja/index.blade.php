@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Penilaian Harian')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Jadwal Budaya Kerja</h3>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan pesan sukses jika ada -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <a href="{{ route('jadwalbudayakerja.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

                        <table class="table table-bordered" id="jadwal-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Bertugas</th>
                                    <th>Shift</th>
                                    <th>Hari</th>
                                    <th>No. Hp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let table = $('#jadwal-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/jadwalbudayakerja", // Endpoint API
            columns: [
                { data: null, name: 'no', searchable: false, orderable: false, 
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama', name: 'nama' },
                { data: 'tanggal_bertugas', name: 'tanggal_bertugas' },
                { data: 'shift', name: 'shift' },
                { data: 'hari', name: 'hari' },
                { data: 'no_telp', name: 'no_telp' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // SweetAlert2 untuk Konfirmasi Hapus
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let deleteUrl = $(this).attr('href');

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success");
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Terjadi kesalahan saat menghapus.", "error");
                        }
                    });
                }
            });
        });

    });
</script>
@endsection


