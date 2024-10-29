@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Tiket Helpdesk')

@section('content')
<div class="container">
    <h1>Edit Tiket</h1>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('tickets.form')
        <button type="submit" class="btn btn-success">Update Tiket</button>
    </form>
</div>
@endsection