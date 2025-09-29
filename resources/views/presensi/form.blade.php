@extends('layouts.pages-layouts')

@section('pageTitle', 'Presensi Datang')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <h1>Presensi Pegawai</h1>
            
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
            
                <form action="{{ route('absensi.handle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="jam_masuk">Jam Masuk</label>
                        <select name="jam_masuk" id="jam_masuk" class="form-control">
                            <option value="">Pilih Jam Masuk</option>
                            @foreach($jamJaga as $jam)
                                <option value="{{ $jam->jam_masuk }}">{{ $jam->jam_masuk }} sd {{ $jam->jam_pulang }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="barcode">Nmr.Kartu</label>
                        <input type="text" name="barcode" id="barcode" class="form-control">
                    </div>
            
                    <div class="form-group">
                        <div id="my_camera"></div>
                        <input type="hidden" name="image" class="image-tag">
                    </div>
            
                    <button type="button" onclick="take_snapshot()" class="btn btn-primary">Ambil Foto</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            
                <div id="results">Hasil foto akan muncul di sini...</div>
            </div>
        </div>
    </div>            
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
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
@endsection
