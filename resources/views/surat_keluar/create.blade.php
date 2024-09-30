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

                    <form action="{{ route('surat_keluar.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat">
                                    @foreach($klasifikasiSurat as $klasifikasi)
                                        <option value="{{ $klasifikasi->id_klasifikasi_surat }}">{{ $klasifikasi->nama_klasifikasi_surat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_sifat_surat">Sifat Surat</label>
                                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat">
                                    @foreach($sifatSurat as $sifat)
                                        <option value="{{ $sifat->id_sifat_surat }}">{{ $sifat->nama_sifat_surat }}</option>
                                    @endforeach
                                </select>
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
                                <label for="lampiran">Jumlah Lampiran</label>
                                <input type="number" name="lampiran" class="form-control" id="lampiran" placeholder="Jumlah lampiran" required>
                            </div>

                            <div class="form-group">
                                <label for="file_surat">Unggah Surat (PHPWord)</label>
                                <input type="file" name="file_surat" class="form-control" id="file_surat" accept=".docx, .pdf" required>
                            </div>

                            <div class="form-group">
                                <label for="file_lampiran">Unggah Lampiran</label>
                                <input type="file" name="file_lampiran" class="form-control" id="file_lampiran" accept=".pdf, .docx">
                            </div>

                            <div class="form-group mb-3">
                                <label for="nik_atasan_langsung">Atasan Langsung:</label>
                                <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->nik }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary">Simpan Surat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->

@endsection