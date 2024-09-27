@extends('layouts.pages-layouts')

@section('pageTitle', 'Presensi Datang')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Presensi Datang</h3>
        </div>
        <div class="card-body">
            <h1>Input Presensi Pegawai</h1>
        
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <form action="{{ route('presensi.datang') }}" method="POST" enctype="multipart/form-data" id="frmPresensi">
                @csrf
                <!-- Pilih Jam Masuk dengan Select2 -->
                <div>
                    <label for="jam_masuk">Jam Masuk:</label>
                    <select name="jam_masuk" id="jam_masuk" class="js-example-basic-single form-control">
                        <option value="">Pilih Jam Masuk</option>
                        @foreach($jam_jaga as $jam)
                            <option value="{{ $jam->jam_masuk }}">{{ $jam->jam_masuk }} sd {{ $jam->jam_pulang }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div>
                    <label for="barcode">Nmr.Kartu:</label>
                    <input type="text" name="barcode" id="barcode">
                </div>

                <!-- Kamera -->
                <div id="my_camera"></div>
                <input type="hidden" name="image" class="image-tag">
                
                <!-- Tombol Simpan -->
                <button type="button" onclick="take_snapshot()">Ambil Foto</button>
                <button type="submit">Simpan</button>
            </form>

            <!-- Tempat menampilkan hasil foto -->
            <div id="results">Hasil foto akan muncul di sini...</div>
            
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    // Atur kamera
    Webcam.set({
        width: 370,
        height: 300,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            document.querySelector('.image-tag').value = data_uri;
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
