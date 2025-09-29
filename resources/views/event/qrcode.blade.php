@extends('layouts.pages-layouts')

@section('pageTitle', 'Scan QR Code')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body text-center">
                <h3>{{ $agenda->judul }}</h3>
    {!! $qrcode !!}
    <p>Scan QR Code untuk Absensi!</p>
            </div>
        </div>
    </div>
</div>
@endsection
