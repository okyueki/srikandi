@extends('layouts.pages-layouts')

@section('pageTitle', $pageTitle)

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('inventaris-barang.update', $barang->kode_barang) }}" method="POST">
                @csrf
                @method('PUT')
                @include('inventaris.form_barang')
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
