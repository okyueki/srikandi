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
<!-- Select2 Initialization -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();

        // Initialize for kode_barang and id_ruang
        $('#kode_barang').select2();
        $('#id_ruang').select2();
    });
</script>
@endsection

