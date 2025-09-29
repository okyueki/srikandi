@extends('layouts.pages-layouts')

@section('pageTitle', 'Riwayat Pemeriksaan')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Riwayat Pemeriksaan</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No Rawat</th>
                            <th>Tanggal Perawatan</th>
                            <th>Jam Rawat</th>
                            <th>Suhu Tubuh</th>
                            <th>Tensi</th>
                            <th>Nadi</th>
                            <th>Respirasi</th>
                            <th>Tinggi</th>
                            <th>Berat</th>
                            <th>SpO2</th>
                            <th>GCS</th>
                            <th>Kesadaran</th>
                            <th>Keluhan</th>
                            <th>Pemeriksaan</th>
                            <th>Alergi</th>
                            <th>Lingkar Perut</th>
                            <th>RTL</th>
                            <th>Penilaian</th>
                            <th>Instruksi</th>
                            <th>Evaluasi</th>
                            <th>NIP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $pemeriksaan)
                        <tr>
                            <td>{{ $pemeriksaan->no_rawat }}</td>
                            <td>{{ $pemeriksaan->tgl_perawatan }}</td>
                            <td>{{ $pemeriksaan->jam_rawat }}</td>
                            <td>{{ $pemeriksaan->suhu_tubuh }}</td>
                            <td>{{ $pemeriksaan->tensi }}</td>
                            <td>{{ $pemeriksaan->nadi }}</td>
                            <td>{{ $pemeriksaan->respirasi }}</td>
                            <td>{{ $pemeriksaan->tinggi }}</td>
                            <td>{{ $pemeriksaan->berat }}</td>
                            <td>{{ $pemeriksaan->spo2 }}</td>
                            <td>{{ $pemeriksaan->gcs }}</td>
                            <td>{{ $pemeriksaan->kesadaran }}</td>
                            <td>{{ $pemeriksaan->keluhan }}</td>
                            <td>{{ $pemeriksaan->pemeriksaan }}</td>
                            <td>{{ $pemeriksaan->alergi }}</td>
                            <td>{{ $pemeriksaan->lingkar_perut }}</td>
                            <td>{{ $pemeriksaan->rtl }}</td>
                            <td>{{ $pemeriksaan->penilaian }}</td>
                            <td>{{ $pemeriksaan->instruksi }}</td>
                            <td>{{ $pemeriksaan->evaluasi }}</td>
                            <td>{{ $pemeriksaan->nip }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
