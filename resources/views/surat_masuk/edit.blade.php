@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title)

@section('content')
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

                <form action="{{ route('surat_masuk.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat" required>
                                    @foreach($klasifikasiSurat as $klasifikasi)
                                        <option value="{{ $klasifikasi->id_klasifikasi_surat }}" {{ $klasifikasi->id_klasifikasi_surat == $surat->id_klasifikasi_surat ? 'selected' : '' }}>{{ $klasifikasi->nama_klasifikasi_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_sifat_surat">Sifat Surat</label>
                                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat" required>
                                    @foreach($sifatSurat as $sifat)
                                        <option value="{{ $sifat->id_sifat_surat }}" {{ $sifat->id_sifat_surat == $surat->id_sifat_surat ? 'selected' : '' }}>{{ $sifat->nama_sifat_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nomor_surat">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control" id="nomor_surat" value="{{ $surat->nomor_surat }}" required>
                            </div>

                            <div class="form-group">
                                <label for="pengirim_external">Pengirim External</label>
                                <input type="text" name="pengirim_external" class="form-control" id="pengirim_external" value="{{ $surat->pengirim_external }}" required>
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
                                <label for="tanggal_surat_diterima">Tanggal Surat Diterima</label>
                                <input type="date" name="tanggal_surat_diterima" class="form-control" id="tanggal_surat_diterima" value="{{ $surat->tanggal_surat_diterima }}" required>
                            </div>

                            <div class="form-group">
                                <label for="lampiran">Jumlah Lampiran</label>
                                <input type="text" name="lampiran" class="form-control" id="lampiran" value="{{ $surat->lampiran }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
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
                         <button type="submit" class="btn btn-primary">Update Surat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for date field
        flatpickr('#tanggal_surat', {
            dateFormat: "Y-m-d",
        });

        flatpickr('#tanggal_surat_diterima', {
            dateFormat: "Y-m-d",
        });
        // Initialize Choices.js for select elements
        const elements = ['id_klasifikasi_surat', 'id_sifat_surat', 'ttd_utama', 'ttd_1', 'ttd_2', 'ttd_3'];
        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const choices = new Choices(element, {
                    searchEnabled: true,
                    position: 'bottom',
                    shouldSort: false,
                });
            }
        });
    });
</script>
@endsection
