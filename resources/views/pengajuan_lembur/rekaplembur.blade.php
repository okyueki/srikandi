@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    {{ $title }}
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
        </div>
    </div>

    <!-- Tabel DataTables -->
    <table id="rekapLemburTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Total Jam Lembur</th>
                </tr>
            </thead>
        </table>
</div>
</div>
</div>
</div>

<script>
        $(document).ready(function() {
            $("#start_date, #end_date").flatpickr({
                dateFormat: "Y-m-d"
            });

            let table = $('#rekapLemburTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/rekap-lembur',
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    { data: 'nik', name: 'nik' },
                    { data: 'nama', name: 'nama' },
                    { data: 'total_jam', name: 'total_jam' }
                ]
            });

            $('#filter').click(function() {
                table.ajax.reload();
            });
        });
    </script>

@endsection