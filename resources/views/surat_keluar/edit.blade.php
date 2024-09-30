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

                    <form action="{{ route('surat_keluar.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat">
                                    @foreach($klasifikasiSurat as $klasifikasi)
                                        <option value="{{ $klasifikasi->id_klasifikasi_surat }}" {{ $surat->id_klasifikasi_surat == $klasifikasi->id_klasifikasi_surat ? 'selected' : '' }}>
                                            {{ $klasifikasi->nama_klasifikasi_surat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_sifat_surat">Sifat Surat</label>
                                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat">
                                    @foreach($sifatSurat as $sifat)
                                        <option value="{{ $sifat->id_sifat_surat }}" {{ $surat->id_sifat_surat == $sifat->id_sifat_surat ? 'selected' : '' }}>
                                            {{ $sifat->nama_sifat_surat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="perihal">Perihal</label>
                                <input type="text" name="perihal" class="form-control" id="perihal" value="{{ $surat->perihal }}" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_surat">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control" id="tanggal_surat" value="{{ $surat->tanggal_surat }}" required>
                            </div>

                            <div class="form-group">
                                <label for="lampiran">Jumlah Lampiran</label>
                                <input type="number" name="lampiran" class="form-control" id="lampiran" value="{{ $surat->lampiran }}" required>
                            </div>

                            <div class="form-group">
                                <label for="file_surat">Unggah Surat (PHPWord)</label>
                                <input type="file" name="file_surat" class="form-control" id="file_surat" accept=".docx">
                                @if($surat->file_surat)
                                    <small>File saat ini:</small>
                                    <a href="{{ asset('storage/' . $surat->file_surat) }}" class="btn btn-sm btn-primary" download>
                                        Download Surat
                                    </a>
                                @else
                                    <small>Tidak ada file surat</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="file_lampiran">Unggah Lampiran</label>
                                <input type="file" name="file_lampiran" class="form-control" id="file_lampiran" accept=".pdf, .docx">
                                @if($surat->file_lampiran)
                                    <small>File saat ini:</small>
                                    <a href="{{ asset('storage/' . $surat->file_lampiran) }}" class="btn btn-sm btn-primary" download>
                                        Download Lampiran
                                    </a>
                                @else
                                    <small>Tidak ada lampiran</small>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="nik_atasan_langsung">Atasan Langsung:</label>
                                <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->nik }}" {{ $verifikasiSurat && $verifikasiSurat->nik_verifikator == $p->nik ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Perbarui Surat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->

@endsection