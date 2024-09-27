@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('klasifikasi_surat.update', $klasifikasiSurat->id_klasifikasi_surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="kode_klasifikasi_surat">Kode Klasifikasi Surat:</label>
                            <input type="text" name="kode_klasifikasi_surat" class="form-control" placeholder="Enter Kode Klasifikasi Surat" value="{{ $klasifikasiSurat->kode_klasifikasi_surat }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_klasifikasi_surat">Nama Klasifikasi Surat:</label>
                            <input type="text" name="nama_klasifikasi_surat" class="form-control" placeholder="Enter Nama Klasifikasi Surat" value="{{ $klasifikasiSurat->nama_klasifikasi_surat }}">
                        </div>

                        <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
<!-- End Page-content -->

@endsection