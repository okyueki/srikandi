@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <a href="{{ route('struktur_organisasi.create') }}" class="btn btn-success waves-effect waves-light mb-3">Create Struktur Organisasi</a>

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

                        <div id="jstree">
        <ul>
            @foreach ($strukturOrganisasi->where('nik_atasan_langsung', null) as $direktur)
                <li>
                    <a href="#">{{ 'Direktur: ' . $direktur->nik }}</a>
                    <ul>
                        @foreach ($strukturOrganisasi->where('nik_atasan_langsung', $direktur->nik) as $kepalaBagian)
                            <li>
                                <a href="#">{{ 'Kepala Bagian: ' . $kepalaBagian->nik }}</a>
                                <ul>
                                    @foreach ($strukturOrganisasi->where('nik_atasan_langsung', $kepalaBagian->nik) as $koordinator)
                                        <li>
                                            <a href="#">{{ 'Koordinator: ' . $koordinator->nik }}</a>
                                            <ul>
                                                @foreach ($strukturOrganisasi->where('nik_atasan_langsung', $koordinator->nik) as $pelaksana)
                                                    <li>
                                                        <a href="#">{{ 'Pelaksana: ' . $pelaksana->nik }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
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

$(document).ready(function() {
    // Initialize jsTree
    $('#jstree').jstree({
        'core': {
            'data': {
                'url': '{{ route('struktur_organisasi.tree') }}', // URL untuk mengambil data
                'data': function (node) {
                    return { 'id': node.id }; // Kirim id node untuk mendapatkan anak
                }
            }
        },
        "plugins": ["wholerow"] // Opsional, untuk menyoroti seluruh baris
    });
});
</script>
@endsection