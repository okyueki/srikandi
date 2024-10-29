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
                <form action="{{ route('surat_masuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat" required>
                                    @foreach($klasifikasiSurat as $klasifikasi)
                                        <option value="{{ $klasifikasi->id_klasifikasi_surat }}">{{ $klasifikasi->nama_klasifikasi_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_sifat_surat">Sifat Surat</label>
                                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat" required>
                                    @foreach($sifatSurat as $sifat)
                                        <option value="{{ $sifat->id_sifat_surat }}">{{ $sifat->nama_sifat_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nomor_surat">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control" id="nomor_surat" placeholder="Masukkan Nomor Surat" required>
                            </div>

                            <div class="form-group">
                                <label for="pengirim_external">Pengirim External</label>
                                <input type="text" name="pengirim_external" class="form-control" id="pengirim_external" placeholder="Masukkan Pengirim External" required>
                            </div>

                            <div class="form-group">
                                <label for="perihal">Perihal</label>
                                <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Masukkan perihal" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_surat">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control" id="tanggal_surat" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_surat_diterima">Tanggal Surat Diterima</label>
                                <input type="date" name="tanggal_surat_diterima" class="form-control" id="tanggal_surat_diterima" required>
                            </div>
                            <div class="form-group">
                                <label for="lampiran">Jumlah Lampiran</label>
                                <input type="text" name="lampiran" class="form-control" id="lampiran" placeholder="Jumlah lampiran" required>
                            </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_surat">Unggah Surat (PDF)</label>
                                    <input type="file" name="file_surat" class="form-control" id="file_surat" accept=".pdf" required>
                                </div>
                                <div class="form-group">
                                <label for="file_lampiran">Unggah Lampiran</label>
                                <input type="file" name="file_lampiran" class="form-control" id="file_lampiran" accept=".pdf, .docx">
                            </div> 
                            <button type="submit" class="btn btn-primary">Simpan Surat</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->

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
        const elements = ['id_klasifikasi_surat', 'id_sifat_surat'];
        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const choices = new Choices(element, {
                    searchEnabled: true,
                    position: 'top',
                    shouldSort: false,
                });
            }
        });
    });
</script>
@endsection