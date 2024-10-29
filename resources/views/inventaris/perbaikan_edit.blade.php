@extends('layouts.pages-layouts')

@section('pageTitle', 'Edit Perbaikan Inventaris')

@section('content')
<h1>Edit Perbaikan Inventaris</h1>

<form action="{{ route('perbaikan.update', $perbaikan->no_permintaan) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>No Permintaan</label>
        <input type="text" name="no_permintaan" value="{{ old('no_permintaan', $perbaikan->no_permintaan) }}" readonly>
    </div>

    <div>
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', $perbaikan->tanggal) }}">
    </div>

    <div>
        <label>Uraian Kegiatan</label>
        <input type="text" name="uraian_kegiatan" value="{{ old('uraian_kegiatan', $perbaikan->uraian_kegiatan) }}">
    </div>

    <div>
        <label>NIP Pelaksana</label>
        <select name="nip">
            @foreach($petugas as $person)
                <option value="{{ $person->nip }}" {{ old('nip', $perbaikan->nip) == $person->nip ? 'selected' : '' }}>
                    {{ $person->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Pelaksana</label>
        <select name="pelaksana">
            <option value="Teknisi Rumah Sakit" {{ old('pelaksana', $perbaikan->pelaksana) == 'Teknisi Rumah Sakit' ? 'selected' : '' }}>Teknisi Rumah Sakit</option>
            <option value="Teknisi Rujukan" {{ old('pelaksana', $perbaikan->pelaksana) == 'Teknisi Rujukan' ? 'selected' : '' }}>Teknisi Rujukan</option>
            <option value="Pihak ke III" {{ old('pelaksana', $perbaikan->pelaksana) == 'Pihak ke III' ? 'selected' : '' }}>Pihak ke III</option>
        </select>
    </div>

    <div>
        <label>Biaya</label>
        <input type="number" name="biaya" value="{{ old('biaya', $perbaikan->biaya) }}">
    </div>

    <div>
        <label>Keterangan</label>
        <input type="text" name="keterangan" value="{{ old('keterangan', $perbaikan->keterangan) }}">
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="Bisa Diperbaiki" {{ old('status', $perbaikan->status) == 'Bisa Diperbaiki' ? 'selected' : '' }}>Bisa Diperbaiki</option>
            <option value="Tidak Bisa Diperbaiki" {{ old('status', $perbaikan->status) == 'Tidak Bisa Diperbaiki' ? 'selected' : '' }}>Tidak Bisa Diperbaiki</option>
        </select>
    </div>

    <button type="submit">Update</button>
</form>

@endsection
