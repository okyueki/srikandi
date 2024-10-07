@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Tiket Helpdesk')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Detail Tiket</div>
                <table class="table table-bordered">
                    <tr>
                        <th>No Tiket</th>
                        <td>{{ $ticket->no_tiket }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $ticket->nik }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Permintaan</th>
                        <td>{{ $ticket->jenis_permintaan }}</td>
                    </tr>
                    <tr>
                        <th>Prioritas</th>
                        <td>{{ $ticket->prioritas }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $ticket->status }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $ticket->deskripsi }}</td>
                    </tr>
                    @if($ticket->upload)
                    <tr>
                        <th>Upload</th>
                        <td><img src="{{ asset('uploads/' . $ticket->upload) }}" width="100"></td>
                    </tr>
                    @endif
                </table>
                <div>
                <a href="{{ route('tickets.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection