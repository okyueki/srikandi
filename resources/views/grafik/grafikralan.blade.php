@extends('layouts.pages-layouts')

@section('pageTitle', 'Grafik Jumlah Pasien Per Bulan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Grafik Jumlah Pasien Per Bulan (Total Tahun {{ $currentYear }})</h4>
    </div>
    <div class="card-body">
        <div id="chart-total" style="min-height: 335px;"></div>
    </div>
</div>

<form method="GET" action="{{ route('grafikralan.index') }}">
    <label for="kd_poli">Pilih Poli:</label>
    <select name="kd_poli" id="kd_poli">
        <option value="">Semua Poli</option>
        <!-- Loop untuk daftar poli -->
        @foreach ($daftarPoli as $poli)
            <option value="{{ $poli->kd_poli }}" {{ request('kd_poli') == $poli->kd_poli ? 'selected' : '' }}>
                {{ $poli->nm_poli }}
            </option>
        @endforeach
    </select>
    <button type="submit">Tampilkan</button>
</form>
<div class="card mt-4">
    <div class="card-header">
        <h4>Grafik Jumlah Pasien Per Bulan Berdasarkan Poli (Tahun {{ $currentYear }})</h4>
    </div>
    <div class="card-body">
        <div id="chart-poli" style="min-height: 335px;"></div>
    </div>
</div>

<form method="GET" action="{{ route('grafikralan.index') }}">
    <label for="kd_dokter">Pilih Dokter:</label>
    <select name="kd_dokter" id="kd_dokter">
        <option value="">Semua Dokter</option>
        <!-- Loop untuk daftar dokter -->
        @foreach ($daftarDokter as $dokter)
            <option value="{{ $dokter->kd_dokter }}" {{ request('kd_dokter') == $dokter->kd_dokter ? 'selected' : '' }}>
                {{ $dokter->nm_dokter }}
            </option>
        @endforeach
    </select>

    <button type="submit">Tampilkan</button>
</form>
<div class="card mt-4">
    <div class="card-header">
        <h4>Grafik Jumlah Pasien Per Bulan Berdasarkan Dokter (Tahun {{ $currentYear }})</h4>
    </div>
    <div class="card-body">
        <div id="chart-dokter" style="min-height: 335px;"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Grafik 1: Total Jumlah Pasien per Bulan
        var optionsTotal = {
            chart: { type: 'bar', height: 320 },
            series: [{
                name: 'Jumlah Pasien',
                data: @json(array_values($monthlyCountsTotal))
            }],
            xaxis: { categories: @json($monthNames) },
            yaxis: { title: { text: 'Jumlah Pasien' } },
            tooltip: {
                y: { formatter: function (val) { return val + " pasien"; } }
            }
        };
        new ApexCharts(document.querySelector("#chart-total"), optionsTotal).render();

        // Grafik 2: Jumlah Pasien per Bulan Berdasarkan Poli
        var seriesByPoli = [];
        @foreach ($monthlyCountsByPoli as $poli => $counts)
            seriesByPoli.push({
                name: 'Poli {{ $poli }}',
                data: @json(array_values($counts))
            });
        @endforeach
        var optionsPoli = {
            chart: { type: 'bar', height: 320 },
            series: seriesByPoli,
            xaxis: { categories: @json($monthNames) },
            yaxis: { title: { text: 'Jumlah Pasien' } },
            tooltip: {
                y: { formatter: function (val) { return val + " pasien"; } }
            }
        };
        new ApexCharts(document.querySelector("#chart-poli"), optionsPoli).render();

        // Grafik 3: Jumlah Pasien per Bulan Berdasarkan Dokter
        var seriesByDokter = [];
        @foreach ($monthlyCountsByDokter as $dokter => $counts)
            seriesByDokter.push({
                name: 'Dokter {{ $dokter }}',
                data: @json(array_values($counts))
            });
        @endforeach
        var optionsDokter = {
            chart: { type: 'bar', height: 320 },
            series: seriesByDokter,
            xaxis: { categories: @json($monthNames) },
            yaxis: { title: { text: 'Jumlah Pasien' } },
            tooltip: {
                y: { formatter: function (val) { return val + " pasien"; } }
            }
        };
        new ApexCharts(document.querySelector("#chart-dokter"), optionsDokter).render();
    });
</script>
@endsection
