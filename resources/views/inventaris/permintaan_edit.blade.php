@extends('layouts.pages-layouts')

@section('pageTitle', 'Tambah Inventaris')

@section('content')

<h1>Edit Permintaan Perbaikan</h1>

    <form action="{{ route('permintaan.update', $permintaan->no_permintaan) }}" method="POST">
    @csrf
    @method('PUT')
    @include('inventaris.permintaan_form')
    <button type="submit" class="btn btn-primary mt-3">Update</button>
</form>


@endsection