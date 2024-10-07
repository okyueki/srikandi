@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Helpdesk Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach($tickets as $ticket)
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card border border-primary custom-card">
                <div class="card-body">
                    <!-- Judul Tiket -->
                    <h5 class="card-title">{{ $ticket->judul }}</h5>

                    <!-- No Tiket dan Icon -->
                    <p class="fs-14 fw-semibold mb-2 lh-1">
                        Ticket No: {{ $ticket->no_tiket }}
                        <a href="javascript:void(0);" class="float-end text-primary">
                            <i class="bi bi-ticket-perforated"></i>
                        </a>
                    </p>

                    <!-- Nama Pegawai dan Departemen -->
                    <p class="mb-2"><strong>Nama Pegawai:</strong> {{ $ticket->pegawai->nama ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Departemen:</strong> {{ $ticket->pegawai->departemen ?? 'N/A' }}</p>

                    <!-- Informasi Inventaris -->
                    <p class="mb-2"><strong>No Inventaris:</strong> {{ $ticket->no_inventaris }}</p>
                    <p class="mb-2"><strong>Nama Barang:</strong> {{ $ticket->inventaris->barang->nama_barang ?? 'N/A' }}</p>

                    <!-- Tanggal dan Deadline -->
                    <p class="mb-2"><strong>Tanggal:</strong> {{ $ticket->tanggal }}</p>
                    <p class="mb-2"><strong>Deadline:</strong> {{ $ticket->deadline }}</p>

                    <p class="mb-2">
                        <strong>Prioritas:</strong>
                        @if($ticket->prioritas == 'High')
                            <span class="badge bg-danger">{{ ucfirst($ticket->prioritas) }}</span>
                        @elseif($ticket->prioritas == 'Medium')
                            <span class="badge bg-warning">{{ ucfirst($ticket->prioritas) }}</span>
                        @else
                            <span class="badge bg-success">{{ ucfirst($ticket->prioritas) }}</span>
                        @endif
                    </p>


                    <!-- Status dengan Badge -->
                    <p class="mb-2">
                        <strong>Status:</strong>
                        @if($ticket->status == 'open')
                            <span class="badge bg-danger">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'in progress')
                            <span class="badge bg-warning text-dark">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'in review')
                            <span class="badge bg-primary">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'close')
                            <span class="badge bg-light text-dark">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'pending')
                            <span class="badge bg-secondary">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'di jadwalkan')
                            <span class="badge bg-dark">{{ ucfirst($ticket->status) }}</span>
                        @else
                            <span class="badge bg-light text-dark">Unknown</span>
                        @endif
                    </p>
                    <p class="mb-2"><strong>respon tiket:</strong> {{ $ticket->response_time ?? 'Belum ada respon' }} </p>
                    <p class="mb-2"><strong>waktu penyelesaian:</strong> {{ $ticket->completion_time ?? 'Belum selesai' }} </p>
                    <!-- Teknisi -->
                    <p class="mb-2"><strong>Nama Teknisi:</strong> {{ $ticket->teknisi->nama ?? 'N/A' }}</p>

                    <!-- Dropdown Action Button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <!-- Item Detail -->
                            <li>
                                <a class="dropdown-item" href="{{ route('helpdesk.ticket.show', $ticket->id) }}">Detail</a>
                            </li>
                            <!-- Item Respon -->
                            <li>
                            <a class="dropdown-item" href="{{ route('responKerja.create', $ticket->id) }}">Respon</a>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
