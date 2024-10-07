@extends('layouts.pages-layouts')

@section('pageTitle', 'Tambah Inventaris')

@section('content')
<div class="container-xl">
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1>Buat Permintaan Perbaikan Baru</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('permintaan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">No Permintaan</label>
                            <input type="text" class="form-control" name="no_permintaan" placeholder="Disabled..." value="{{ old('no_permintaan', $permintaan->no_permintaan ?? '') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Inventaris</label>
                            <select class="form-control js-example-basic-single" name="no_inventaris">
                                @foreach($inventaris as $item)
                                    <option value="{{ $item->no_inventaris }}" {{ isset($permintaan) && $item->no_inventaris == $permintaan->no_inventaris ? 'selected' : '' }}>
                                        {{ $item->no_inventaris }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>NIK</label>
                            <select name="nik" class="form-control">
                                @foreach($pegawai as $person)
                                    <option value="{{ $person->nik }}" {{ isset($permintaan) && $person->nik == $permintaan->nik ? 'selected' : '' }}>
                                        {{ $person->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="datetime-local" class="form-control" name="tanggal" value="{{ old('tanggal', isset($permintaan->tanggal) ? $permintaan->tanggal->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                        </div>
                        
                        <div class="mb-3">
                            <label>Deskripsi Kerusakan</label>
                            <textarea class="form-control" name="deskripsi_kerusakan">{{ old('deskripsi_kerusakan', $permintaan->deskripsi_kerusakan ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Departemen</label>
                            <select name="departemen" id="departemen" class="form-control">
                                <option value="">Pilih Departemen</option>
                                @foreach($departemens as $dep)
                                    <option value="{{ $dep->dep_id }}">{{ $dep->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pegawai</label>
                            <select name="nik" id="pegawai" class="form-control js-example-basic-single">
                                <option value="">Pilih Pegawai</option>
                                <!-- Pegawai akan diisi berdasarkan departemen yang dipilih dengan AJAX -->
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Pending" {{ isset($permintaan) && $permintaan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ isset($permintaan) && $permintaan->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ isset($permintaan) && $permintaan->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ isset($permintaan) && $permintaan->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label>Prioritas</label>
                            <select name="prioritas" class="form-control">
                                <option value="Low" {{ isset($permintaan) && $permintaan->prioritas == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ isset($permintaan) && $permintaan->prioritas == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ isset($permintaan) && $permintaan->prioritas == 'High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>
<script>
// AJAX untuk mengambil pegawai berdasarkan departemen yang dipilih
document.getElementById('departemen').addEventListener('change', function() {
    var depId = this.value;
    var pegawaiSelect = $('#pegawai');

    // Kosongkan dropdown pegawai
    pegawaiSelect.empty().append('<option value="">Pilih Pegawai</option>');

    if (depId) {
        // Kirim request AJAX
        fetch(`/get-pegawai-by-departemen/${depId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(function(pegawai) {
                    var option = new Option(pegawai.nama, pegawai.nik, false, false);
                    pegawaiSelect.append(option).trigger('change');
                });
            });
    }
});

// Inisialisasi Select2 pada Pegawai
$('.js-example-basic-single').select2({
        width: '100%' // Pastikan lebar sesuai
    });

</script>

@endsection
