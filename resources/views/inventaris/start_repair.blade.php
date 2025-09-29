@extends('layouts.pages-layouts')

@section('pageTitle', 'Mulai Perbaikan Inventaris')

@section('content')
<div class="container-xl">
    <div class="card">
        <div class="card-body">
            <h3>Mulai Perbaikan untuk Permintaan No: {{ $permintaan->no_permintaan }}</h3>

            <form action="{{ route('perbaikan.start', $permintaan->no_permintaan) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Uraian Kegiatan</label>
                    <textarea name="uraian_kegiatan" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIP Teknisi</label>
                    <input type="text" name="nip" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pelaksana</label>
                    <select name="pelaksana" class="form-select" required>
                        <option value="Teknisi Rumah Sakit">Teknisi Rumah Sakit</option>
                        <option value="Teknisi Rujukan">Teknisi Rujukan</option>
                        <option value="Pihak Ketiga">Pihak Ketiga</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya</label>
                    <input type="number" name="biaya" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Mulai Perbaikan</button>
            </form>
        </div>
    </div>
</div>
@endsection
