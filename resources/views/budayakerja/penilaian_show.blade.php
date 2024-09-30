@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Penilaian')

@section('content')
<div class="container">
    <h1>Detail Penilaian Harian</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Pegawai:</strong> {{ $penilaian->pegawai->nama }}</p>
            <p><strong>Tanggal Penilaian:</strong> {{ $penilaian->tanggal_penilaian }}</p>
            <p><strong>Waktu Penilaian:</strong> {{ $penilaian->waktu_penilaian }}</p>

            <h3>Detail Item Penilaian</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaian->detailPenilaian as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->itemPenilaian->nama_item }}</td>
                            <td>{{ $detail->nilai ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p><strong>Total Nilai:</strong> {{ $totalNilai }}</p>
        </div>
    </div>
</div>
@endsection
