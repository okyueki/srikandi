@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Tiket')

@section('content')
<div class="col-xl-12">
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title">
                Daftar Semua Tiket
            </div>
            <div class="prism-toggle">
                <button class="btn btn-sm btn-primary-light">Show Code<i class="ri-code-line ms-2 d-inline-block align-middle"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">No Tiket</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Status</th>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->no_tiket }}</td>
                            <td>{{ $ticket->judul }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td><span class="badge bg-primary">{{ ucfirst($ticket->prioritas) }}</span></td>
                            <td>{{ $ticket->deadline ? $ticket->deadline->format('d-m-Y') : '-' }}</td>
                            <td>
                                <div class="hstack gap-2 fs-15">
                                    @if($ticket->status === 'open')
                                        <form action="{{ route('teknisi.terima-tiket', $ticket->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-icon btn-sm btn-success">
                                                <i class="ri-check-line"></i> Terima Tiket
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Tiket sudah diterima</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
