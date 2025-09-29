@extends('layouts.pages-layouts')

@section('pageTitle', 'Edit Agenda')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <h2 class="mb-4">Edit Agenda</h2>
                <form action="{{ route('acara_update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ $agenda->judul }}" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control">{{ $agenda->deskripsi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Mulai</label>
                        <input type="datetime-local" name="mulai" class="form-control" value="{{ \Carbon\Carbon::parse($agenda->mulai)->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Akhir</label>
                        <input type="datetime-local" name="akhir" class="form-control" value="{{ \Carbon\Carbon::parse($agenda->akhir)->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control" value="{{ $agenda->tempat }}">
                    </div>
                    <div class="form-group">
                        <label>Pimpinan Rapat</label>
                        <select name="pimpinan_rapat" class="form-control">
                            @foreach($pegawai as $p)
                                <option value="{{ $p->nik }}" {{ $agenda->pimpinan_rapat == $p->nik ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Notulen</label>
                        <select name="notulen" class="form-control">
                            @foreach($pegawai as $p)
                                <option value="{{ $p->nik }}" {{ $agenda->notulen == $p->nik ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Yang Terundang</label>
                        <select name="yang_terundang[]" class="form-control" multiple>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->nik }}" {{ in_array($p->nik, $agenda->yang_terundang) ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Materi</label>
                        <input type="file" name="materi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control">{{ $agenda->keterangan }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
