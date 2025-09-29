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
    <table id="rekapCutiTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Ijin</th>
                <th>Tahunan</th>
                <th>Melahirkan</th>
                <th>Ambil Libur</th>
                <th>Menikah</th>
                <th>Total Hari Cuti</th>
            </tr>
        </thead>
    </table>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    // Inisialisasi Flatpickr
    $("#start_date,#end_date").flatpickr({
        dateFormat: "Y-m-d",
        allowInput: true
    });

    // Inisialisasi DataTables
    let table = $('#rekapCutiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/rekap-libur',
            data: function (d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
            { data: 'nama', name: 'nama' },
            { data: 'ijin', name: 'ijin' },
            { data: 'tahunan', name: 'tahunan' },
            { data: 'melahirkan', name: 'melahirkan' },
            { data: 'ambil_libur', name: 'ambil_libur' },
            { data: 'menikah', name: 'menikah' },
            { data: 'total_hari', name: 'total_hari' }
        ]
    });

    // Filter Data Saat Tombol Diklik
    $('#filter').click(function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();

        if (startDate === '' || endDate === '') {
            alert('Silakan pilih rentang tanggal terlebih dahulu.');
            return;
        }

        table.ajax.reload();
    });
});
</script>

@endsection