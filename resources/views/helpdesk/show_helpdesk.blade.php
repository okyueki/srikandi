@extends('layouts.pages-layouts')

@section('pageTitle', 'Detail Ticket - ' . $ticket->no_tiket)

@section('content')
<div class="container">
    <div class="card custom-card">
        <div class="card-header">
            <h3>Detail Ticket: {{ $ticket->no_tiket }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>NIK:</strong> {{ $ticket->nik }}</p>
                    <p><strong>No Inventaris:</strong> {{ $ticket->no_inventaris }}</p>
                    <p><strong>Tanggal:</strong> {{ $ticket->tanggal }}</p>
                    <p><strong>Prioritas:</strong> 
                        @if($ticket->prioritas == 'High')
                            <span class="badge bg-danger">High</span>
                        @elseif($ticket->prioritas == 'Medium')
                            <span class="badge bg-warning">Medium</span>
                        @else
                            <span class="badge bg-success">Low</span>
                        @endif
                    </p>
                    <p><strong>Status:</strong> 
                        @if($ticket->status == 'Open')
                            <span class="badge bg-info">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'In Progress')
                            <span class="badge bg-warning">{{ ucfirst($ticket->status) }}</span>
                        @else
                            <span class="badge bg-success">{{ ucfirst($ticket->status) }}</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Deadline:</strong> {{ $ticket->deadline }}</p>
                    <p><strong>Judul:</strong> {{ $ticket->judul }}</p>
                    <p><strong>Departemen:</strong> {{ $ticket->departemen }}</p>
                    <p><strong>NIK Teknisi:</strong> {{ $ticket->nik_teknisi }}</p>
                    <p><strong>No HP:</strong> {{ $ticket->no_hp }}</p>
                    <p><strong>Jenis Permintaan:</strong> {{ $ticket->jenis_permintaan }}</p>
                </div>
            </div>
            <hr>
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $ticket->deskripsi }}</p>
            @if($ticket->upload)
                <p><strong>Upload:</strong> <a href="{{ asset('storage/uploads/' . $ticket->upload) }}" target="_blank">Lihat Lampiran</a></p>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('helpdesk.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection