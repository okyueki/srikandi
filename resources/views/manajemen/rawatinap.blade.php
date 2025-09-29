@extends('layouts.pages-layouts')

@section('pageTitle', $title ?? 'Laporan Rawat Inap')

@section('content')
@php
    use Carbon\Carbon;
    $currentMonth = Carbon::now()->format('Y-m');
    $months = collect();

    for ($i = 0; $i < 12; $i++) {
        $date = Carbon::now()->subMonths($i);
        $months->push([
            'value' => $date->format('Y-m'),
            'label' => $date->translatedFormat('F Y'),
        ]);
    }
@endphp

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    {{ $title ?? 'Laporan Rawat Inap' }}
                </div>
            </div>
            <div class="card-body">

                <!-- Filter Bulan -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="bulan">Bulan :</label>
                        <select id="bulan" name="bulan" class="form-control">
                            @foreach ($months as $month)
                                <option value="{{ $month['value'] }}" {{ $month['value'] === $currentMonth ? 'selected' : '' }}>
                                    {{ $month['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary">Filter</button>
                        <button id="reset" class="btn btn-secondary ms-2">Reset</button>
                    </div>
                </div>

                <!-- Tabel -->
                <table id="laporan-rawatinap-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Masih Dirawat</th>
                            <th>Membaik</th>
                            <th>Rujuk</th>
                            <th>Meninggal</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
$(document).ready(function () {
    let table;

    function loadTable(bulan = '') {
        if (table) {
            table.destroy();
        }

        table = $('#laporan-rawatinap-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pasienrawatinap.index') }}",
                data: { bulan: bulan }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'masih_dirawat', name: 'masih_dirawat' },
                { data: 'membaik', name: 'membaik' },
                { data: 'rujuk', name: 'rujuk' },
                { data: 'meninggal', name: 'meninggal' }
            ]
        });
    }

    // Initial Load
    let defaultBulan = $('#bulan').val();
    loadTable(defaultBulan);

    // Filter
    $('#filter').on('click', function () {
        let selectedBulan = $('#bulan').val();
        loadTable(selectedBulan);
    });

    // Reset
    $('#reset').on('click', function () {
        $('#bulan').val("{{ $currentMonth }}");
        loadTable("{{ $currentMonth }}");
    });
});
</script>
@endsection
