@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Item Penilaian')

@section('content')
<div class="container">
    <h1>Tambah Item Penilaian</h1>
    <form action="{{ route('item_penilaian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_item">Nama Item</label>
            <input type="text" name="nama_item" id="nama_item" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="bobot_nilai">Bobot Nilai</label>
            <input type="number" name="bobot_nilai" id="bobot_nilai" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
