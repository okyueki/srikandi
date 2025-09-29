@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- Page Header -->
        <div class="col-12">
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <h4 class="mb-0">Assalamualaikum, @if(Auth::check())
                        {{ Auth::user()->name }}
                    @endif</h4>
                    <p class="mb-0 text-muted">{{ $presensiMessage }}</p>
                </div>
                <div class="main-dashboard-header-right d-flex gap-3">
                    <div>
                        <label class="fs-13 text-muted">Customer Ratings</label>
                        <div class="main-star">
                            <i class="bi bi-star-fill fs-13 text-warning"></i> 
                            <i class="bi bi-star-fill fs-13 text-warning"></i> 
                            <i class="bi bi-star-fill fs-13 text-warning"></i> 
                            <i class="bi bi-star-fill fs-13 text-warning"></i> 
                            <i class="bi bi-star-fill fs-13 text-muted op-8"></i> <span>(14,873)</span>
                        </div>
                    </div>
                    <div>
                        <label class="fs-13 text-muted">TOTAL PEGAWAI RS</label>
                        <h5 class="mb-0 fw-semibold">{{ $jumlahPegawai->sum() }} orang</h5>
                    </div>
                    <div>
                        <label class="fs-13 text-muted">Jumlah Dokter</label>
                        <h5 class="mb-0 fw-semibold">15</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
    </div>

    <!-- Presensi Table -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-table">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0 text-nowrap">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Jam Datang</th>
                                <th>Status</th>
                                <th>Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presensiUser as $presensi)
                            <tr>
                                <td>{{ $presensi->shift }}</td>
                                <td>{{ \Carbon\Carbon::parse($presensi->jam_datang)->format('H:i') }}</td>
                                <td>{{ $presensi->status }}</td>
                                <td>{{ $presensi->keterlambatan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="px-3 pt-3 pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">Cuti Tahunan</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ 12 - $totalHari }} Hari</h4>
                                    <p class="mb-0 fs-12 text-fixed-white op-7">Sisa Cuti Tahunan</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                    <i class="fas fa-user-friends text-fixed-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3">
         <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-warning-gradient">
                    <div class="px-3 pt-3 pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">JUMLAH PASIEN RAWAT JALAN HARI INI</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ $jumlahPasienHariIni }} orang</h4>
                            <p class="mb-0 fs-12 text-fixed-white op-7">Pasien Diperiksa</p>
                        </div>
                        <span class="ms-auto">
                            <i class="fas fa-arrow-circle-up text-fixed-white"></i>
                            <span class="text-fixed-white op-7"> +{{ $pertumbuhanPasien }} dari kemarin</span>
                        </span>
                    </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="px-3 pt-3 pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">TOTAL PEGAWAI AKTIF</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ $jumlahPegawai->sum() }} orang</h4>
                                    <p class="mb-0 fs-12 text-fixed-white op-7">Pegawai aktif saat ini</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                    <i class="fas fa-user-friends text-fixed-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="px-3 pt-3 pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">JUMLAH PASIEN RAWAT INAP</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ $jumlahPasienRawatInap }} orang</h4>
                                    <p class="mb-0 fs-12 text-fixed-white op-7">Pasien rawat inap dengan lama < 6 hari</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                    <i class="fas fa-procedures text-fixed-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="px-3 pt-3 pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">JUMLAH PASIEN IGD HARI INI</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ $jumlahPasienIGD }} orang</h4>
                                    <p class="mb-0 fs-12 text-fixed-white op-7">Pasien terdaftar di IGD</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                    <i class="fas fa-hospital-alt text-fixed-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Pegawai -->
    <div class="row g-3">
          <div class="col-xl-4 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header pb-1">
                <h3 class="card-title mb-2">Terlambat Pegawai Hari Ini</h3>
                <p class="fs-12 mb-0 text-muted">Daftar pegawai yang terlambat berdasarkan keterlambatan terbesar</p>
            </div>
            <div class="product-timeline card-body pt-2 mt-1">
                <ul class="timeline-1 mb-0">
                    @foreach($topTerlambat as $pegawai)
                    <li class="mt-0">
                        <i class="fe fe-user bg-primary-gradient text-fixed-white product-icon"></i>
                        <span class="fw-medium mb-4 fs-14">{{ $pegawai->pegawai->nama }}</span>
                        <a href="javascript:void(0);" class="float-end fs-11 text-muted">
                            {{ $pegawai->jam_datang->diffForHumans() }}  <!-- Menggunakan diffForHumans() dengan Carbon -->
                        </a>
                        <p class="mb-0 text-muted fs-12">
                            {{ $pegawai->status }} - Terlambat: {{ $pegawai->keterlambatan }} - Shift: {{ $pegawai->shift }}
                        </p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header pb-1">
                <h3 class="card-title mb-2">Top 10 Pegawai Rajin (30 Hari Terakhir)</h3>
                <p class="fs-12 mb-0 text-muted">Berikut adalah pegawai yang paling sering mengisi pemeriksaan rawat jalan</p>
            </div>
            <div class="product-timeline card-body pt-2 mt-1">
                <ul class="timeline-1 mb-0">
                    @foreach($topPegawaiRajin as $pegawai)
                    <li class="mt-0">
                        <i class="fe fe-user bg-primary-gradient text-fixed-white product-icon"></i>
                        <span class="fw-medium mb-4 fs-14">{{ $pegawai->nama_pegawai }}</span>
                        <p class="mb-0 text-muted fs-12">Jumlah Entri: {{ $pegawai->jumlah_entri }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header pb-1">
                <h3 class="card-title mb-2">Pegawai Ulang Tahun Dalam 10 Hari Kedepan</h3>
                <p class="fs-12 mb-0 text-muted">Daftar pegawai yang akan berulang tahun dalam waktu dekat</p>
            </div>
            <div class="product-timeline card-body pt-2 mt-1">
                <ul class="timeline-1 mb-0">
                    @if($pegawaiUlangTahun->isEmpty())
                        <li class="mt-0">
                            <i class="fe fe-calendar bg-danger-gradient text-fixed-white product-icon"></i>
                            <span class="fw-medium mb-4 fs-14">Tidak ada pegawai yang berulang tahun dalam waktu dekat</span>
                        </li>
                    @else
                        @foreach($pegawaiUlangTahun as $pegawai)
                        <li class="mt-0">
                            <i class="bi bi-emoji-smile-fill bg-danger-gradient text-fixed-white product-icon"></i>
                            <span class="fw-medium mb-4 fs-14">{{ $pegawai->nama }}</span>
                            <a href="javascript:void(0);" class="float-end fs-11 text-muted">{{ $pegawai->status }}</a>
                            <p class="mb-0 text-muted fs-12">Tanggal Lahir: {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->format('d F') }}</p>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    </div>

    <!-- Statistik Grafik -->
    <div class="row g-3">
       <!-- Jumlah Pegawai per Departemen -->
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Jumlah Pegawai per Unit / Departemen</div>
            </div>
            <div class="card-body">
                <h4>Total Pegawai: {{ $jumlahPegawai->sum() }} orang</h4> <!-- Display total pegawai -->
                <div id="chart-departemen" style="min-height: 365px;"></div> <!-- Tempat untuk grafik -->
            </div>
        </div>
    </div>

    <!-- Jumlah Pegawai per Bidang -->
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Distribusi Pegawai per Bidang</div>
            </div>
            <div class="card-body">
                <h4>Total Pegawai: {{ $jumlahPerBidang->sum() }} orang</h4> <!-- Display total pegawai per bidang -->
                <div id="chart-bidang" style="min-height: 365px;"></div> <!-- Tempat untuk grafik -->
            </div>
        </div>
    </div>
    </div>
</div>

   

<script>
// Data for Treemap Chart for Departemen
var optionsTreemapDepartemen = {
    series: [{
        data: {!! json_encode($departemen) !!}
    }],
    chart: {
        type: 'treemap',
        height: 350
    },
    title: {
        text: 'Jumlah Pegawai per Departemen'
    },
    dataLabels: {
        enabled: true,
        formatter: function(val, opts) {
            var departmentName = opts.w.config.series[0].data[opts.dataPointIndex].x;
            var label = opts.w.config.series[0].data[opts.dataPointIndex].label;
            // Gunakan '\n' untuk memecah baris
            return departmentName + "\n" + label.replace("(", "\n(");
        },
        style: {
            fontSize: '12px',
            colors: ['#000'],
            fontWeight: 'bold'
        }
    }
};

// Render Chart for Departemen
var chartTreemapDepartemen = new ApexCharts(document.querySelector("#chart-departemen"), optionsTreemapDepartemen);
chartTreemapDepartemen.render();

// Data for Treemap Chart for Bidang
var optionsTreemapBidang = {
    series: [{
        data: {!! json_encode($bidang) !!}
    }],
    chart: {
        type: 'treemap',
        height: 350
    },
    title: {
        text: 'Distribusi Pegawai per Bidang'
    },
    dataLabels: {
        enabled: true,
        formatter: function(val, opts) {
            var bidangName = opts.w.config.series[0].data[opts.dataPointIndex].x;
            var label = opts.w.config.series[0].data[opts.dataPointIndex].label;
            // Gunakan '\n' untuk memecah baris
            return bidangName + "\n" + label.replace("(", "\n(");
        },
        style: {
            fontSize: '12px',
            colors: ['#000'],
            fontWeight: 'bold'
        }
    }
};

// Render Chart for Bidang
var chartTreemapBidang = new ApexCharts(document.querySelector("#chart-bidang"), optionsTreemapBidang);
chartTreemapBidang.render();
</script>


@endsection