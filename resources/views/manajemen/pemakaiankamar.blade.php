@extends('layouts.pages-layouts')

@section('pageTitle', $title ?? 'Pemakaian Kamar')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    {{ $title ?? 'Pemakaian Kamar' }}
                </div>
            </div>
            <div class="card-body">

                <!-- Filter Tanggal -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start_date">Mulai Tanggal:</label>
                        <input type="date" id="start_date" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">Sampai Tanggal:</label>
                        <input type="date" id="end_date" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary">Filter</button>
                        <button id="reset" class="btn btn-secondary ms-2">Reset</button>
                    </div>
                </div>

                <!-- Tabel DataTables -->
                <table id="kamar-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bangsal</th>
                            <th>Jumlah Pasien</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    let table = null;

    function loadData(start_date = '', end_date = '') {
        if(table) {
            table.destroy();
        }
        table = $('#kamar-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pemakaiankamar.index') }}",
                data: { start_date: start_date, end_date: end_date }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nm_bangsal', name: 'nm_bangsal' },
                { data: 'jumlah_pasien', name: 'jumlah_pasien' }
            ],
            order: [[1, 'asc']],
            paging: true,
            lengthChange: true,
            searching: true,
        });
    }

    loadData();

    $('#filter').on('click', function () {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        loadData(start_date, end_date);
    });

    $('#reset').on('click', function () {
        $('#start_date').val('');
        $('#end_date').val('');
        loadData();
    });
});
</script>

@endsection