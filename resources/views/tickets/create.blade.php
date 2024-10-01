@extends('layouts.pages-layouts')

@section('pageTitle', 'Buat Tiket Helpdesk')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Buat Tiket Baru </div>
                <div class="card-body">
                    <!-- Notifikasi Error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- NIK -->
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <select name="nik" id="nik" class="form-control" required>
                                <option value="">Pilih NIK</option>
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->nik }}" {{ old('nik') == $p->nik ? 'selected' : '' }}>
                                        {{ $p->nik }} - {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nik')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Permintaan -->
                        <div class="form-group">
                            <label for="jenis_permintaan">Jenis Permintaan</label>
                            <select name="jenis_permintaan" class="form-control" required>
                                <option value="">Pilih Jenis Permintaan</option>
                                @foreach($jenisPermintaan as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_permintaan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_permintaan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="datetime-local" name="tanggal" class="form-control" value="{{ old('tanggal', $ticket->tanggal ?? now()->format('Y-m-d\TH:i')) }}" required>
                            @error('tanggal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departemen -->
                        <div class="form-group">
                            <label for="departemen">Departemen</label>
                            <select name="departemen" id="departemen" class="form-control" required>
                                <option value="">Pilih Departemen</option>
                                @foreach($departemen as $d)
                                    <option value="{{ $d->dep_id }}" {{ old('departemen', $ticket->departemen ?? '') == $d->dep_id ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departemen')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prioritas -->
                        <div class="form-group">
                            <label for="prioritas">Prioritas</label>
                            <select name="prioritas" class="form-control" required>
                                <option value="low" {{ old('prioritas') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('prioritas') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('prioritas') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('prioritas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in progress" {{ old('status') == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="in review" {{ old('status') == 'in review' ? 'selected' : '' }}>In Review</option>
                                <option value="close" {{ old('status') == 'close' ? 'selected' : '' }}>Close</option>
                                <option value="di jadwalkan" {{ old('status') == 'di jadwalkan' ? 'selected' : '' }}>Di Jadwalkan</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" value="{{ old('deadline') }}">
                            @error('deadline')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload -->
                        <div class="form-group">
                            <label for="upload">Upload (Gambar)</label>
                            <input type="file" name="upload" class="form-control">
                            @error('upload')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Inventaris -->
                        <div class="form-group">
                            <label for="no_inventaris">No Inventaris</label>
                            <select name="no_inventaris" class="form-control">
                                <option value="">Pilih No Inventaris (Opsional)</option>
                                @foreach($inventaris as $inv)
                                    <option value="{{ $inv->no_inventaris }}" {{ old('no_inventaris', $ticket->no_inventaris ?? '') == $inv->no_inventaris ? 'selected' : '' }}>
                                        {{ $inv->no_inventaris }} - {{ $inv->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('no_inventaris')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $ticket->no_hp ?? '') }}" readonly>
                            @error('no_hp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Tiket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Implementasi Choices.js untuk NIK dan Departemen
    const choicesNik = new Choices('#nik', {
        searchEnabled: true,
        shouldSort: false
    });

    const choicesDepartemen = new Choices('#departemen', {
        searchEnabled: true,
        shouldSort: false
    });

    // Ketika NIK dipilih
    $('#nik').change(function() {
        var nik = $(this).val(); // Ambil nilai NIK yang dipilih

        if (nik) {
            // AJAX request untuk mengambil No HP
            $.ajax({
                url: "{{ route('get.nohp') }}",
                type: "GET",
                data: { nik: nik },
                success: function(response) {
                    // Set value No HP di input
                    $('#no_hp').val(response.no_hp);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Debug error jika terjadi
                }
            });
        } else {
            // Kosongkan input No HP jika NIK tidak dipilih
            $('#no_hp').val('');
        }
    });
</script>
@endsection
