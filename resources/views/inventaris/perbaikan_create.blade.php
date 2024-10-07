@extends('layouts.pages-layouts')

@section('pageTitle', 'Tambah Perbaikan Inventaris')

@section('content')
<h1>Tambah Perbaikan Inventaris</h1>

<form action="{{ route('perbaikan.store') }}" method="POST">
    @csrf

    <!-- No Permintaan, otomatis terisi jika berasal dari permintaan perbaikan -->
    <div class="mb-3">
        <label for="no_permintaan">No Permintaan</label>
        <input type="text" name="no_permintaan" class="form-control" value="{{ $permintaan->no_permintaan ?? '' }}" readonly>
    </div>

    <!-- Tanggal perbaikan (default: hari ini) -->
    <div class="mb-3">
        <label for="tanggal">Tanggal Perbaikan</label>
        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->format('Y-m-d')) }}">
    </div>

    <!-- Uraian Kegiatan -->
    <div class="mb-3">
        <label for="uraian_kegiatan">Uraian Kegiatan</label>
        <textarea name="uraian_kegiatan" class="form-control">{{ old('uraian_kegiatan') }}</textarea>
    </div>

    <!-- NIP Petugas -->
    <div class="mb-3">
        <label for="nip">NIP Teknisi</label>
        <select name="nip" class="form-control">
            @foreach($petugas as $petugasItem)
                <option value="{{ $petugasItem->nip }}">{{ $petugasItem->nama }}</option>
            @endforeach
        </select>
    </div>

    <!-- Pelaksana -->
    <div class="mb-3">
        <label for="pelaksana">Pelaksana</label>
        <select name="pelaksana" class="form-control">
            <option value="Teknisi Rumah Sakit">Teknisi Rumah Sakit</option>
            <option value="Teknisi Rujukan">Teknisi Rujukan</option>
            <option value="Pihak ke III">Pihak ke III</option>
        </select>
    </div>

    <!-- Biaya -->
    <div class="mb-3">
        <label for="biaya">Biaya</label>
        <input type="number" name="biaya" class="form-control" value="{{ old('biaya') }}">
    </div>

    <!-- Keterangan -->
    <div class="mb-3">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
    </div>

    <!-- Prioritas, diambil dari permintaan perbaikan jika ada -->
    <div class="mb-3">
        <label for="prioritas">Prioritas</label>
        <select name="prioritas" class="form-control">
            <option value="rendah" {{ old('prioritas', $permintaan->prioritas ?? '') == 'rendah' ? 'selected' : '' }}>Rendah</option>
            <option value="sedang" {{ old('prioritas', $permintaan->prioritas ?? '') == 'sedang' ? 'selected' : '' }}>Sedang</option>
            <option value="tinggi" {{ old('prioritas', $permintaan->prioritas ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
            <option value="kritis" {{ old('prioritas', $permintaan->prioritas ?? '') == 'kritis' ? 'selected' : '' }}>Kritis</option>
        </select>
    </div>
<!-- Status -->
<div class="mb-3">
    <label for="status">Status</label>
    <select name="status" class="form-control" required>
        <option value="Bisa Diperbaiki">Bisa Diperbaiki</option>
        <option value="Tidak Bisa Diperbaiki">Tidak Bisa Diperbaiki</option>
    </select>
</div>

<!-- Waktu Mulai -->
<div class="mb-3">
    <label for="waktu_mulai">Waktu Mulai Perbaikan</label>
    <input type="datetime-local" name="waktu_mulai" class="form-control" value="{{ old('waktu_mulai', now()->format('Y-m-d\TH:i')) }}" required>
</div>

<!-- Waktu Selesai -->
<div class="mb-3">
    <label for="waktu_selesai">Waktu Selesai Perbaikan (opsional)</label>
    <input type="datetime-local" name="waktu_selesai" class="form-control" value="{{ old('waktu_selesai') }}">
</div>

    <button type="submit">Simpan</button>
</form>
@endsection
