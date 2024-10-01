@extends('layouts.pages-layouts')

@section('pageTitle', 'Daftar Tiket')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Detail Tiket</div>
            </div>
            <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tab Navigation -->
            <nav class="nav nav-style-1 nav-pills mb-3" role="tablist">
                <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#detail" aria-selected="true">Detail Tiket</a>
                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#update" aria-selected="false">Update Tiket</a>
                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#respon" aria-selected="false">Respon Kerja</a>
            </nav>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Tab Detail Tiket -->
                <div class="tab-pane fade show active" id="detail" role="tabpanel">
                    <h5>No Tiket: {{ $ticket->no_tiket }}</h5>
                    <p><strong>Judul:</strong> {{ $ticket->judul }}</p>
                    <p><strong>Deskripsi:</strong> {{ $ticket->deskripsi }}</p>
                    <p><strong>Prioritas:</strong> {{ ucfirst($ticket->prioritas) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                    <p><strong>Deadline:</strong> 
                        {{ $ticket->deadline ? \Carbon\Carbon::parse($ticket->deadline)->format('d-m-Y') : '-' }}
                    </p>
                </div>

                <!-- Tab Update Tiket -->
                <div class="tab-pane fade" id="update" role="tabpanel">
                    <form action="{{ route('teknisi.tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        <!-- Judul Tiket -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Tiket</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ $ticket->judul }}" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $ticket->deskripsi }}</textarea>
                        </div>

                        <!-- Prioritas -->
                        <div class="mb-3">
                            <label for="prioritas" class="form-label">Prioritas</label>
                            <select class="form-control" id="prioritas" name="prioritas" required>
                                <option value="low" {{ $ticket->prioritas == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $ticket->prioritas == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $ticket->prioritas == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in progress" {{ $ticket->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="in review" {{ $ticket->status == 'in review' ? 'selected' : '' }}>In Review</option>
                                <option value="close" {{ $ticket->status == 'close' ? 'selected' : '' }}>Close</option>
                            </select>
                        </div>

                        <!-- Deadline -->
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" 
                                   value="{{ $ticket->deadline ? \Carbon\Carbon::parse($ticket->deadline)->format('Y-m-d') : '' }}">
                        </div>

                        <!-- No Inventaris -->
                        <div class="mb-3">
                            <label for="no_inventaris" class="form-label">No Inventaris</label>
                            <select class="form-control" id="no_inventaris" name="no_inventaris" required>
                                <option value="">-- Pilih No Inventaris --</option>
                                @foreach($inventaris as $item)
                                    <option value="{{ $item->no_inventaris }}" {{ $ticket->no_inventaris == $item->no_inventaris ? 'selected' : '' }}>
                                        {{ $item->no_inventaris }} - {{ $item->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NIK Teknisi -->
                        <div class="mb-3">
                            <label for="nik_teknisi" class="form-label">NIK Teknisi</label>
                            <select class="form-control" id="nik_teknisi" name="nik_teknisi" required>
                                <option value="">-- Pilih Teknisi --</option>
                                @foreach($pegawai as $pgw)
                                    <option value="{{ $pgw->nik }}" {{ $ticket->nik_teknisi == $pgw->nik ? 'selected' : '' }}>
                                        {{ $pgw->nik }} - {{ $pgw->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Tiket</button>
                    </form>
                </div>

                <!-- Tab Respon Kerja -->
                <div class="tab-pane fade" id="respon" role="tabpanel">
                    <form action="{{ route('teknisi.respon_kerja.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <!-- Foto Hasil -->
                        <div class="mb-3">
                            <label for="foto_hasil" class="form-label">Foto Hasil</label>
                            <input type="file" class="form-control" id="foto_hasil" name="foto_hasil">
                        </div>
                        
                        <!-- NIK Teknisi -->
                        <div class="mb-3">
                            <label for="nik_teknisi" class="form-label">NIK Teknisi</label>
                            <select class="form-control" id="nik_teknisi" name="nik_teknisi" required>
                                <option value="">-- Pilih Teknisi --</option>
                                @foreach($pegawai as $pgw)
                                    <option value="{{ $pgw->nik }}" {{ $ticket->nik_teknisi == $pgw->nik ? 'selected' : '' }}>
                                        {{ $pgw->nik }} - {{ $pgw->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Deskripsi Hasil -->
                        <div class="mb-3">
                            <label for="deskripsi_hasil" class="form-label">Deskripsi Hasil</label>
                            <textarea class="form-control" id="deskripsi_hasil" name="deskripsi_hasil" rows="4"></textarea>
                        </div>

                        <!-- Status Akhir -->
                        <div class="mb-3">
                            <label for="status_akhir" class="form-label">Status Akhir</label>
                            <select class="form-control" id="status_akhir" name="status_akhir" required>
                                <option value="selesai">Selesai</option>
                                <option value="minta bantuan pihak ketiga">Minta Bantuan Pihak Ketiga</option>
                            </select>
                        </div>

                        <!-- Biaya -->
                        <div class="mb-3">
                            <label for="biaya" class="form-label">Biaya</label>
                            <input type="number" class="form-control" id="biaya" name="biaya" placeholder="Contoh: 150000">
                        </div>

                        <!-- Tingkat Kesulitan -->
                        <div class="mb-3">
                            <label for="tingkat_kesulitan" class="form-label">Tingkat Kesulitan</label>
                            <select class="form-control" id="tingkat_kesulitan" name="tingkat_kesulitan">
                                <option value="mudah">Mudah</option>
                                <option value="sedang">Sedang</option>
                                <option value="sulit">Sulit</option>
                            </select>
                        </div>

                        <!-- Petunjuk Penyelesaian -->
                        <div class="mb-3">
                            <label for="petunjuk_penyelesaian" class="form-label">Petunjuk Penyelesaian</label>
                            <textarea class="form-control" id="petunjuk_penyelesaian" name="petunjuk_penyelesaian" rows="4"></textarea>
                        </div>

                        <!-- Teknisi Tambahan -->
                        <div class="mb-3">
                            <label for="teknisi_tambahan" class="form-label">Teknisi Tambahan</label>
                            <select class="form-control" id="teknisi_tambahan" name="teknisi_tambahan[]" multiple>
                                <option value="">-- Pilih Teknisi Tambahan --</option>
                                @foreach($pegawai as $pgw)
                                    <option value="{{ $pgw->nik }}">{{ $pgw->nik }} - {{ $pgw->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Teknisi tambahan jika dibutuhkan.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Respon Kerja</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
