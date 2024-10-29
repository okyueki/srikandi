@extends('layouts.pages-layouts')

@section('pageTitle', $pageTitle)

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('inventaris-barang.store') }}" method="POST">
                @csrf
                @include('inventaris.form_barang')
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Choices.js untuk dropdown
        const kodeProdusen = new Choices('#kode_produsen', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idMerk = new Choices('#id_merk', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idKategori = new Choices('#id_kategori', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idJenis = new Choices('#id_jenis', {
            searchEnabled: true,
            shouldSort: false,
        });
    });
</script>
@endsection
