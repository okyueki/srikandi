@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Tiket Helpdesk')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Daftar Tiket</div>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Buat Tiket Baru</a>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Tiket</th>
                            <th>NIK</th>
                            <th>Jenis Permintaan</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->no_tiket }}</td>
                            <td>{{ $ticket->nik }}</td>
                            <td>{{ $ticket->jenis_permintaan }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>{{ $ticket->prioritas }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus tiket ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>    
        </div>        
    </div>            
</div>
@endsection