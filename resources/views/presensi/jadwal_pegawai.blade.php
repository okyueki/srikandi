@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Jadwal Pegawai')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kelola Jadwal Presensi</h3>
                        <ul class="nav nav-tabs l_tinynav1">
                            <li class="active">
                                <a href="{{ route('jadwal.index') }}" role="tab">Jadwal</a>
                            </li>
                            <li class="">
                                <a href="#">Tambah</a>
                            </li>
                        </ul>
                    </div>
            
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col col-md-6">
                                <h3 style="margin-top:5px;margin-bottom:15px;">Jumlah: {{ $jadwalPegawai->total() }} || Bulan: {{ strtoupper(date('M', mktime(0, 0, 0, $bulan, 1))) }}</h3>
                            </div>
            
                            <div class="row mb-4">
                                <form method="GET" action="{{ route('jadwal.index') }}" class="row mb-4">
                                <div class="col-md-3">
                                    <select name="b" id="bulan" class="form-control">
                                        <option value="">Bulan</option>
                                        @foreach(['01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER'] as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $bulan ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="col-md-4">
                                    <input type="text" name="s" value="{{ $phrase }}" class="form-control" placeholder="Cari Nama Pegawai">
                                </div>
                            
                                <div class="col-md-3">
                                    <select name="d" id="departemen" class="form-control">
                                        <option value="">Departemen</option>
                                        @foreach($departemenList as $id => $name)
                                            <option value="{{ $id }}" {{ $id == $departemen ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
            
                        <div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-striped margin" style="min-width: 1200px;">
        <thead>
            <tr>
                <th>Nama</th>
                @for ($i = 1; $i <= 31; $i++)
                    <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalPegawai as $jadwal)
                <tr>
                    <td>{{ $jadwal->pegawai->nama }}</td>
                    @for ($i = 1; $i <= 31; $i++)
                        @php
                            $hari = 'h'.$i;
                        @endphp
                        <td>{{ $jadwal->$hari }}</td>
                    @endfor
                    <td class="text-right">
                        <a href="{{ route('jadwal.edit', [$jadwal->id, $bulan, $tahun]) }}" class="btn btn-success btn-xs">
                            <i class="fa fa-pencil"></i> <span class="hidden-xs">Ganti</span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

            
                        <!-- Pagination -->
                       {{ $jadwalPegawai->withQueryString()->links('vendor.pagination.tabler') }}
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
