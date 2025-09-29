@extends('layouts.pages-layouts')

@section('pageTitle', 'Edit Jadwal Budaya Kerja')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Jadwal Budaya Kerja</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jadwalbudayakerja.update', $jadwal->id_jadwal_budaya_kerja) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="nik">Petugas</label>
                                <select name="nik" id="nik" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    @foreach ($petugas as $p)
                                        <option value="{{ $p->nip }}" {{ $p->nip == $jadwal->nik ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_bertugas" class="form-label">Tanggal Bertugas</label>
                                <input type="date" class="form-control" id="tanggal_bertugas" name="tanggal_bertugas" value="{{ $jadwal->tanggal_bertugas }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="shift" class="form-label">Shift</label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="pagi" {{ $jadwal->shift == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                                    <option value="sore" {{ $jadwal->shift == 'Sore' ? 'selected' : '' }}>Sore</option>
                                </select>
                            </div>
                            
                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi flatpickr untuk tanggal
    flatpickr('#tanggal_bertugas', {
        dateFormat: "Y-m-d",
    });

    // Inisialisasi Choices.js untuk elemen select
    const elements = ['nik', 'shift', 'hari']; // Daftar ID untuk select fields
    elements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            new Choices(element, {
                searchEnabled: true,  // Mengaktifkan fitur pencarian
                position: 'auto',     // Menampilkan dropdown di bawah elemen
                shouldSort: false,    // Menonaktifkan pengurutan otomatis
                allowHTML: true,      // Menambahkan dukungan HTML di dalam opsi
            });
        }
    });
});
</script>

@endsection