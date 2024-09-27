@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sifat_surat.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="sifat_surat" class="form-label">Sifat Surat</label>
                            <input type="text" name="nama_sifat_surat" class="form-control" id="sifat_surat" required>
                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->

@endsection