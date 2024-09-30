@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Item Penilaian')

@section('content')
<div class="container">
    <h1>Edit Item Penilaian</h1>
    <form action="{{ route('item_penilaian.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_item">Nama Item</label>
            <input type="text" name="nama_item" id="nama_item" class="form-control" value="{{ $item->nama_item }}" required>
        </div>
        <div class="form-group">
            <label for="bobot_nilai">Bobot Nilai</label>
            <input type="number" name="bobot_nilai" id="bobot_nilai" class="form-control" value="{{ $item->bobot_nilai }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection