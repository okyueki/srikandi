@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Create Dokter')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Inventaris</h3>
        </div>
        <div class="card-body">
            <!-- Form utama, pastikan enctype ditambahkan -->
            <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Include bagian form dari file terpisah -->
                @include('inventaris.form_inventaris')
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#kode_barang').change(function() {
            var kode_barang = $(this).val();
            if (kode_barang) {
                $.ajax({
                    url: '/get-barang-info/' + kode_barang,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#produsen').val(data.produsen);
                        $('#merk').val(data.merk);
                    }
                });
            } else {
                $('#produsen').val('Tidak Diketahui');
                $('#merk').val('Tidak Diketahui');
            }
        });
    });
</script>
@endsection
