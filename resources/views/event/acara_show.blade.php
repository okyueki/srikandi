@extends('layouts.pages-layouts')

@section('pageTitle', 'Detail Agenda')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h2 class="mb-4">{{ $agenda->judul }}</h2>
                    <p><strong>Deskripsi:</strong> {{ $agenda->deskripsi }}</p>
                    <p><strong>Mulai:</strong> {{ \Carbon\Carbon::parse($agenda->mulai)->format('d M Y H:i') }}</p>
                    <p><strong>Akhir:</strong> {{ $agenda->akhir ? \Carbon\Carbon::parse($agenda->akhir)->format('d M Y H:i') : '-' }}</p>
                    <p><strong>Tempat:</strong> {{ $agenda->tempat ?? '-' }}</p>
                    <p><strong>Pimpinan Rapat:</strong> {{ $agenda->pimpinan->nama ?? '-' }}</p>
                    <p><strong>Notulen:</strong> {{ $agenda->notulenPegawai->nama ?? '-' }}</p>
                    <p><strong>Keterangan:</strong> {{ $agenda->keterangan ?? '-' }}</p>
                    
                    {{-- Tampilkan jumlah terundang --}}
                    <p><strong>Yang Terundang:</strong> 
                        @if($isAll)
                            <span class="badge bg-success">Semua Pegawai ({{ $jumlahTerundang }} orang)</span>
                        @else
                            <span class="badge bg-primary">{{ $jumlahTerundang }} orang</span>
                        @endif
                    </p>

                    {{-- Tampilkan daftar hanya jika bukan "all" --}}
                    @if(!$isAll && !empty($listTerundang))
                        <div class="mt-2">
                            <strong>Daftar Nama:</strong>
                            <ul class="mb-0">
                                @foreach($listTerundang as $nik)
                                    @php
                                        $pegawai = \App\Models\Pegawai::on('server_74')->where('nik', $nik)->first();
                                    @endphp
                                    <li>{{ $pegawai ? $pegawai->nama : 'Pegawai tidak ditemukan (' . $nik . ')' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif($isAll)
                        <div class="mt-2">
                            <em>Semua pegawai aktif diundang.</em>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection