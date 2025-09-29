@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
        
                        <div class="table-responsive">
                         <table id="asuhan-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No. Rawat</th>
                                        <th>Nama Pasien</th>
                                        <th>Kamar</tht>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
<script>
$(function () {
    $('#asuhan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('datadischargenote.index') }}',
        columns: [
            { data: 'no_rawat', name: 'no_rawat' },
            { data: 'nama_pasien', name: 'regPeriksa.pasien.nm_pasien' },
            { data: 'nm_bangsal', name: 'kamrInap.kamar.bangsal.nm_bangsal' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection