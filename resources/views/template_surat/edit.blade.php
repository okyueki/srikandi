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

                    <form action="{{ route('template_surat.update', $templateSurat->id_template_surat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_template">Nama Template</label>
                            <input type="text" name="nama_template" class="form-control" value="{{ old('nama_template', $templateSurat->nama_template) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $templateSurat->deskripsi) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="file_template">Upload Template Baru (Opsional)</label>
                            <input type="file" name="file_template" class="form-control" accept=".docx">
                            <small>File sebelumnya: <a href="{{ asset('storage/' . $templateSurat->file_template) }}" target="_blank">{{ basename($templateSurat->file_template) }}</a></small>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Template</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->

@endsection