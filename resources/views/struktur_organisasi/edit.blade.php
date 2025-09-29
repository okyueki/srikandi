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

                    <form action="{{ route('struktur_organisasi.update', $struktur->id_struktur_organisasi) }}" method="POST">
        @csrf
        @method('PUT') <!-- Tambahkan method PUT untuk mengupdate data -->
        
        <div class="form-group mb-3">
            <label for="nik">NIK Pegawai:</label>
            <select name="nik" id="nik" class="form-control" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach ($pegawai2 as $p2)
                    <option value="{{ $p2->nik }}" {{ $p2->nik == $struktur->nik ? 'selected' : '' }}>{{ $p2->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="nik_atasan_langsung">NIK Atasan Langsung:</label>
            <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach ($pegawai as $p)
                    <option value="{{ $p->nik }}" {{ $p->nik == $struktur->nik_atasan_langsung ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
                    </div>
                </div>
            </div>
        </div>
<!-- End Page-content -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('nik_atasan_langsung');
            const choices = new Choices(element, {
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'bottom', // Menampilkan dropdown di bawah elemen
                shouldSort: false, // Menghindari pengurutan jika tidak diperlukan
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('nik');
            const choices = new Choices(element, {
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'bottom', // Menampilkan dropdown di bawah elemen
                shouldSort: false, // Menghindari pengurutan jika tidak diperlukan
            });

        });
</script>
@endsection