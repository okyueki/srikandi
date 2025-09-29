@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Kamar')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan Pasien</h3>
        </div>
        <!-- Total Pasien -->
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Total Pasien: {{ $dataKamarInap->total() }}</p>
        </div>
         <div class="card-footer d-flex align-items-center">
        <form action="{{ route('kamar_inap.index') }}" method="GET" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="belum" value="belum" {{ request('filter') == 'belum' || !request('filter') ? 'checked' : '' }}>
                <label class="form-check-label" for="belum">Belum Pulang</label>
            </div>
        </div>

        <div class="col-auto">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="masuk" value="masuk" {{ request('filter') == 'masuk' ? 'checked' : '' }}>
                <label class="form-check-label" for="masuk">Tgl. Masuk:</label>
            </div>
            <input type="date" name="tgl_masuk_awal" class="form-control form-control-sm d-inline-block" style="width:auto;" value="{{ request('tgl_masuk_awal') }}">
            <span class="mx-1">s.d</span>
            <input type="date" name="tgl_masuk_akhir" class="form-control form-control-sm d-inline-block" style="width:auto;" value="{{ request('tgl_masuk_akhir') }}">
        </div>

        <div class="col-auto">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="pulang" value="pulang" {{ request('filter') == 'pulang' ? 'checked' : '' }}>
                <label class="form-check-label" for="pulang">Pulang:</label>
            </div>
            <input type="date" name="tgl_keluar_awal" class="form-control form-control-sm d-inline-block" style="width:auto;" value="{{ request('tgl_keluar_awal') }}">
            <span class="mx-1">s.d</span>
            <input type="date" name="tgl_keluar_akhir" class="form-control form-control-sm d-inline-block" style="width:auto;" value="{{ request('tgl_keluar_akhir') }}">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </div>
    </div>
</form>
</div>
        <!-- Search -->
        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="text-muted">
                    Show
                    <div class="mx-2 d-inline-block">
                        <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                    </div>
                    entries
                </div>
                <div class="ms-auto text-muted">
                    Search:
                    <div class="ms-2 d-inline-block">
                        
                        <form action="{{ route('kamar_inap.index') }}" method="GET">
                            <input id="searchInput" name="search" type="text" class="form-control form-control-sm" aria-label="Search invoice" value="{{ request('search') }}">
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>No Rawat</th>
                            <th>Kamar</th>
                            <th>Diagnosa Awal</th>
                            <th>Tanggal Masuk</th>
                            <th>Lama Menginap</th>
                            <th>Nama Dokter</th>
                            <th>Jenis Bayar</th>
                            <th>Total Obat</th>
                            <th>Total Kamar</th>
                            <th>Total Tindakan</th>
                            <th>Total Lab</th>
                            <th>Total Radiologi</th>
                            <th>Total Keseluruhan</th>
                            <th>Plafon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataKamarInap as $kamar)
                        @php
                            $no_rawat = str_replace('/', '', $kamar->no_rawat);
                        @endphp
                        <tr>
                            <td data-id="{{ $kamar->regPeriksa->pasien->no_rkm_medis ?? '-' }}">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $kamar->regPeriksa->pasien->no_rkm_medis ?? '-' }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('soapie.show', ['no_rawat' => $no_rawat]) }}">SOAP & Pemeriksaan</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('adimegizi.index', ['no_rawat' => $no_rawat]) }}">Adime Gizi</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('kamar_inap.show', $no_rawat) }}">Detail Rawat</a>
                                        </li>
                                         <li>
                                            <a class="dropdown-item" href="{{ route('discharge-note.index', $no_rawat) }}">Ringkasan</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $kamar->regPeriksa->pasien->nm_pasien ?? '-' }}</td>
                            <td>{{ $kamar->no_rawat ?? '-' }}</td>
                            <td>{{ $kamar->kamar->bangsal->nm_bangsal ?? '-' }}</td>
                            <td>{{ $kamar->diagnosa_awal }}</td>
                            <td>{{ $kamar->tgl_masuk }}</td>
                            <td>{{ $kamar->lama }}</td>
                            <td>{{ $kamar->regPeriksa->dokter->nm_dokter ?? '-' }}</td>
                            <td>{{ $kamar->regPeriksa->penjab->png_jawab ?? '-' }}</td>
                            <td>{{ number_format($kamar->total_obat, 0, ',', '.') }}
                            <br> Obat: {{ number_format(($kamar->total_obat / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.') }}% @if (($kamar->total_obat / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 30) <span> ⛔</span> @endif </td>
                            <td>{{ number_format($kamar->total_biaya_kamar, 0, ',', '.') }} <br> Kamar : {{ number_format(($kamar->total_biaya_kamar / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.') }}%
                                @if (($kamar->total_biaya_kamar / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 20)
                                <span>⛔</span>
                                @endif </td>
                            <td>{{ number_format($kamar->total_biaya_tindakan, 0, ',', '.') }} <br> Tindakan : {{ number_format(($kamar->total_biaya_tindakan / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.') }}%
                                @if (($kamar->total_biaya_tindakan / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 30)
                                <span>⛔</span>
                                @endif </td>
                            <td>{{ number_format($kamar->total_biaya_lab, 0, ',', '.') }} <br> Lab : {{ number_format(($kamar->total_biaya_lab / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.') }}%
                                @if (($kamar->total_biaya_lab / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 10)
                                <span>⛔</span>
                                @endif </td>
                            <td>{{ number_format($kamar->total_biaya_radiologi, 0, ',', '.') }} <br> Radiologi : {{ number_format(($kamar->total_biaya_radiologi / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.') }}% 
                                @if (($kamar->total_biaya_radiologi / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 10) 
                                <span>⛔</span>
                                @endif</td>
                            <td>{{ number_format($kamar->total_keseluruhan, 0, ',', '.') }}</td>
                            
                            <td>
                                @if($kamar->exceedPlafon)
                                <span style="color: red;">Total cost exceeds plafon!</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex align-items-center">
    <p class="m-0 text-muted">Showing <span>{{ $dataKamarInap->firstItem() }}</span> to <span>{{ $dataKamarInap->lastItem() }}</span> of <span>{{ $dataKamarInap->total() }}</span> entries</p>
    <ul class="pagination m-0 ms-auto">
        @if ($dataKamarInap->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">prev</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $dataKamarInap->previousPageUrl() }}&search={{ request('search') }}" rel="prev">prev</a>
            </li>
        @endif

        @for ($i = 1; $i <= $dataKamarInap->lastPage(); $i++)
            <li class="page-item {{ $dataKamarInap->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $dataKamarInap->url($i) }}&search={{ request('search') }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($dataKamarInap->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $dataKamarInap->nextPageUrl() }}&search={{ request('search') }}" rel="next">next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">next</span>
            </li>
        @endif
    </ul>
</div>

</div>


@endsection