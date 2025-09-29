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

               <form action="{{ route('surat_keluar.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat" required>
                    @foreach($klasifikasiSurat as $klasifikasi)
                        <option value="{{ $klasifikasi->id_klasifikasi_surat }}" 
                            {{ $klasifikasi->id_klasifikasi_surat == $surat->id_klasifikasi_surat ? 'selected' : '' }}>
                            {{ $klasifikasi->nama_klasifikasi_surat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_sifat_surat">Sifat Surat</label>
                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat" required>
                    @foreach($sifatSurat as $sifat)
                        <option value="{{ $sifat->id_sifat_surat }}" 
                            {{ $sifat->id_sifat_surat == $surat->id_sifat_surat ? 'selected' : '' }}>
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
                <input type="text" name="lampiran" class="form-control" id="lampiran" value="{{ $surat->lampiran }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="ttd_utama">Penandatanganan Surat Utama:</label>
                <select name="ttd_utama" id="ttd_utama" class="form-control" required>
                    <option value="">-- Select Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->nik }}" 
                            {{ $p->nik == optional($tandaTangan->where('nik_penandatangan', $p->nik)->where('status_ttd', 'qrcode')->first())->nik_penandatangan ? 'selected' : ($p->nik == $surat->ttd_utama ? 'selected' : '') }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            @for ($i = 2; $i <= 4; $i++)
    <div class="form-group mb-3">
        <label for="ttd_{{ $i }}">Penandatangan Surat {{ $i }} (Opsional):</label>
        <select name="ttd_{{ $i }}" id="ttd_{{ $i }}" class="form-control">
            <option value="">-- Select Pegawai --</option>
            @foreach ($pegawai as $p)
                <option value="{{ $p->nik }}" 
                    {{ $p->nik == optional(${'selectedTtd'.$i})->nik_penandatangan ? 'selected' : '' }}>
                    {{ $p->nama }}
                </option>
            @endforeach
        </select>
    </div>
@endfor
        </div>
    </div>

    <div class="form-group">
        <label for="file_surat">Unggah Surat (PHPWord)</label>
        <input type="file" name="file_surat" class="form-control" id="file_surat" accept=".docx">
        @if($surat->file_surat)
            <small>File saat ini:</small>
            <a href="{{ asset('storage/' . $surat->file_surat) }}" class="btn btn-sm btn-primary" download>Download Surat</a>
        @else
            <small>Tidak ada file surat</small>
        @endif
    </div>

    <div class="form-group">
        <label for="file_lampiran">Unggah Lampiran</label>
        <input type="file" name="file_lampiran" class="form-control" id="file_lampiran" accept=".pdf">
        @if($surat->file_lampiran)
            <small>File saat ini:</small>
            <a href="{{ asset('storage/' . $surat->file_lampiran) }}" class="btn btn-sm btn-primary" download>Download Lampiran</a>
        @else
            <small>Tidak ada lampiran</small>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Update Surat</button>
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

        // Initialize Choices.js for select elements
        const elements = ['id_klasifikasi_surat', 'id_sifat_surat', 'ttd_utama', 'ttd_2', 'ttd_3', 'ttd_4'];
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
