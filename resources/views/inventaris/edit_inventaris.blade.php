@extends('layouts.pages-layouts')

@section('pageTitle', 'Edit Inventaris')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Inventaris</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('inventaris.update', $inventaris->no_inventaris) }}" method="POST">
                @csrf
                @method('PUT')
                @include('inventaris.form_inventaris', ['inventaris' => $inventaris])
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
