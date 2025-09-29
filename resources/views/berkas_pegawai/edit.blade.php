@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
           
            <div class="card-body">
                <div class="row gy-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <h4><strong>Nama Pegawai:</strong> {{ $Pegawai->nama }} <br>
                    <strong>NIK:</strong> {{ $Pegawai->nik }}</h4>

    <form action="{{ route('berkas_pegawai.update', $Pegawai->nik) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="accordion" id="accordionExample">
            @foreach ($jenisBerkas as $key => $jenis)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $key }}">
                        <button class="accordion-button {{ $key !== 0 ? 'collapsed' : '' }}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse{{ $key }}" 
                                aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" 
                                aria-controls="collapse{{ $key }}">
                            {{ $jenis->jenis_berkas }}
                        </button>
                    </h2>
                    <div id="collapse{{ $key }}" 
                         class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}" 
                         aria-labelledby="heading{{ $key }}" 
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @php
                                $berkas = $berkasPegawai->firstWhere('id_jenis_berkas', $jenis->id);
                            @endphp

                            <!-- Nomor Berkas -->
                            <div class="mb-3">
                                <label for="nomor_berkas_{{ $jenis->id }}" class="form-label">Nomor Berkas</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nomor_berkas_{{ $jenis->id }}" 
                                       name="nomor_berkas[{{ $jenis->id }}]" 
                                       value="{{ $berkas->nomor_berkas ?? '' }}">
                            </div>

                            <!-- Existing File Information -->
                            @if ($berkas && $berkas->file)
                                <p><strong>Berkas Saat Ini:</strong></p>
                                <a href="{{ asset('storage/' . $berkas->file) }}" target="_blank">Download</a>
                            @else
                                <p><strong>Berkas Saat Ini:</strong> Belum ada berkas</p>
                            @endif

                            <!-- File Upload -->
                            <div class="mb-3">
                                <label for="file_{{ $jenis->id }}" class="form-label">Unggah Berkas Baru</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="file_{{ $jenis->id }}" 
                                       name="file[{{ $jenis->id }}]">
                            </div>

                            <!-- Status Berkas -->
                            <div class="mb-3">
                                <label for="status_berkas_{{ $jenis->id }}" class="form-label">Status Berkas</label>
                                <select class="form-control" 
                                        id="status_berkas_{{ $jenis->id }}" 
                                        name="status_berkas[{{ $jenis->id }}]">
                                    <option value="valid" {{ ($berkas->status_berkas ?? '') == 'Masih Berlaku' ? 'selected' : '' }}>Masih Berlaku</option>
                                    <option value="invalid" {{ ($berkas->status_berkas ?? '') == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                                    <option value="pending" {{ ($berkas->status_berkas ?? '') == 'Proses Pengajuan' ? 'selected' : '' }}>Proses Pengajuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('berkas_pegawai.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection