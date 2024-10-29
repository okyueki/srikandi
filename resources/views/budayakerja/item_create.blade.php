@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Item Penilaian')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Item Penilaian</h3>
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
    </div>        
</div>
@endsection
