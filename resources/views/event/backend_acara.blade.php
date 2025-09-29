@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Agenda')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body"> {{-- Ganti container jadi card-body --}}
                    <h1>Daftar Agenda</h1>

                    <!-- Tombol Tambah Agenda -->
                    <a href="{{ route('acara_create') }}" class="btn btn-success mb-3">Tambah Agenda</a>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    <table class="table table-bordered" id="agendaTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Tempat</th>
                                <th>Pimpinan Rapat</th>
                                <th>Notulen</th>
                                <th>Jumlah Terundang</th> {{-- Tambahkan ini --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#agendaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/backend-acara',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'judul', name: 'judul' },
                    { data: 'mulai', name: 'mulai' },
                    { data: 'akhir', name: 'akhir' },
                    { data: 'tempat', name: 'tempat' },
                    { data: 'pimpinan_nama', name: 'pimpinan.nama' },
                    { data: 'notulen_nama', name: 'notulenPegawai.nama' },
                    { data: 'jumlah_terundang', name: 'jumlah_terundang', searchable: false }, // Tambahkan ini
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection