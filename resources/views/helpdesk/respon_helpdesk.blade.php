@extends('layouts.pages-layouts')

@section('pageTitle', 'Respon Ticket - ' . $ticket->no_tiket)

@section('content')
<div class="row">
    <div class="col-xl-8">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    <h4>{{ isset($responKerja) ? 'Update Respon untuk' : 'Tambah Respon untuk' }} Ticket: {{ $ticket->no_tiket }}</h4>
                </div>
            </div>
                <div class="card-body">
                <!-- Tambahkan navigasi tab -->
                <ul class="nav nav-tabs" id="responTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="respon-tab" data-bs-toggle="tab" href="#respon" role="tab" aria-controls="respon" aria-selected="true">Respon</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="komentar-tab" data-bs-toggle="tab" href="#komentar" role="tab" aria-controls="komentar" aria-selected="false">Komentar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="teknisi-tab" data-bs-toggle="tab" href="#teknisi" role="tab" aria-controls="teknisi" aria-selected="false">Teknisi</a>
                    </li>
                </ul>
                <div class="tab-content" id="responTabContent">
                    <!-- Tab Respon -->
                    <div class="tab-content" id="responTabContent">
                        <!-- Tab Respon -->
                        <div class="tab-pane fade show active" id="respon" role="tabpanel" aria-labelledby="respon-tab">
                            <form action="{{ isset($responKerja) ? route('responKerja.update', $responKerja->id) : route('responKerja.store', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($responKerja))
                                    @method('PUT') <!-- Tambahkan method PUT untuk update -->
                                @endif
                    
                                <!-- Teknisi Dropdown -->
                                <div class="mb-3">
                                    <label for="teknisi_id" class="form-label">Teknisi</label>
                                    <select name="teknisi_id" class="form-select" required>
                                        <option value="" disabled {{ !isset($responKerja) ? 'selected' : '' }}>Pilih Teknisi</option>
                                        @foreach($pegawai as $teknisi)
                                            <option value="{{ $teknisi->nik }}" {{ isset($responKerja) && $responKerja->teknisi_id == $teknisi->nik ? 'selected' : '' }}>
                                                {{ $teknisi->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <!-- Deskripsi Hasil -->
                                <div class="mb-3">
                                    <label for="deskripsi_hasil" class="form-label">Deskripsi Hasil</label>
                                    <textarea name="deskripsi_hasil" class="form-control" rows="5" required>{{ $responKerja->deskripsi_hasil ?? '' }}</textarea>
                                </div>
                    
                                <!-- Status Akhir Respon -->
                                <div class="mb-3">
                                    <label for="status_akhir" class="form-label">Status Akhir</label>
                                    <select name="status_akhir" class="form-select" required>
                                        <option value="selesai" {{ isset($responKerja) && $responKerja->status_akhir == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="minta bantuan pihak ketiga" {{ isset($responKerja) && $responKerja->status_akhir == 'minta bantuan pihak ketiga' ? 'selected' : '' }}>Minta Bantuan Pihak Ketiga</option>
                                        <option value="lanjut" {{ isset($responKerja) && $responKerja->status_akhir == 'lanjut' ? 'selected' : '' }}>Lanjut</option>
                                    </select>
                                </div>
                    
                                <!-- Tingkat Kesulitan -->
                                <div class="mb-3">
                                    <label for="tingkat_kesulitan" class="form-label">Tingkat Kesulitan</label>
                                    <select name="tingkat_kesulitan" class="form-select" required>
                                        <option value="mudah" {{ isset($responKerja) && $responKerja->tingkat_kesulitan == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                        <option value="sedang" {{ isset($responKerja) && $responKerja->tingkat_kesulitan == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="sulit" {{ isset($responKerja) && $responKerja->tingkat_kesulitan == 'sulit' ? 'selected' : '' }}>Sulit</option>
                                    </select>
                                </div>
                    
                                <!-- Biaya -->
                                <div class="mb-3">
                                    <label for="biaya" class="form-label">Biaya (Opsional)</label>
                                    <input type="number" name="biaya" step="0.01" class="form-control" value="{{ $responKerja->biaya ?? '' }}">
                                </div>
                    
                                <!-- Petunjuk Penyelesaian -->
                                <div class="mb-3">
                                    <label for="petunjuk_penyelesaian" class="form-label">Petunjuk Penyelesaian (Opsional)</label>
                                    <textarea name="petunjuk_penyelesaian" class="form-control" rows="3">{{ $responKerja->petunjuk_penyelesaian ?? '' }}</textarea>
                                </div>
                    
                                <!-- Foto Hasil -->
                                <div class="mb-3">
                                    <label for="foto_hasil" class="form-label">Upload Foto Hasil (Opsional)</label>
                                    <input type="file" name="foto_hasil" class="form-control">
                                </div>
                    
                                <!-- Status Tiket -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Tiket</label>
                                    <select name="status" class="form-select" required>
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in progress" {{ $ticket->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="in review" {{ $ticket->status == 'in review' ? 'selected' : '' }}>In Review</option>
                                        <option value="close" {{ $ticket->status == 'close' ? 'selected' : '' }}>Close</option>
                                        <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="di jadwalkan" {{ $ticket->status == 'di jadwalkan' ? 'selected' : '' }}>Di Jadwalkan</option>
                                    </select>
                                </div>
                    
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-success">{{ isset($responKerja) ? 'Perbarui Respon' : 'Simpan Respon' }}</button>
                            </form>
                        </div>
                    </div>
                    <!-- Tab Komentar -->
                    <div class="tab-pane fade" id="komentar" role="tabpanel" aria-labelledby="komentar-tab">
                        <!-- Form untuk menambahkan komentar -->
                        <form action="{{ route('komentar.store', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="komentar" class="form-label">Komentar</label>
                                <textarea name="komentar" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambahkan Komentar</button>
                        </form>
    
                        <hr>
    
                        <!-- Menampilkan daftar komentar yang ada -->
                        <h5>Daftar Komentar</h5>
                        @if($ticket->komentar->isEmpty())
                            <p>Belum ada komentar untuk tiket ini.</p>
                        @else
                            <ul class="list-group">
                                @foreach($ticket->komentar as $komentar)
                                    <li class="list-group-item">
                                        <strong>{{ $komentar->email }}:</strong> <br>
                                        {{ $komentar->komentar }}
                                        <br>
                                        <small class="text-muted">Ditambahkan pada: {{ $komentar->created_at->format('d-m-Y H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="teknisi" role="tabpanel" aria-labelledby="teknisi-tab">
                        <!-- Form untuk menambahkan teknisi tambahan -->
                        <form action="{{ route('teknisi.store', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="teknisi_id" class="form-label">Pilih Teknisi</label>
                                <select name="teknisi_id" class="form-select" required>
                                    <option value="" disabled selected>Pilih Teknisi</option>
                                    @foreach($pegawai as $teknisi)
                                        <option value="{{ $teknisi->nik }}">{{ $teknisi->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambahkan Teknisi</button>
                        </form>
    
                        <hr>
    
                        <!-- Menampilkan daftar teknisi tambahan yang ada -->
                        <h5>Daftar Teknisi Tambahan</h5>
                        @if($ticket->teknisiMenangani->isEmpty())
                            <p>Belum ada teknisi tambahan untuk tiket ini.</p>
                        @else
                            <ul class="list-group">
                                @foreach($ticket->teknisiMenangani as $teknisi)
                                    <li class="list-group-item">
                                        <strong>{{ $teknisi->pengguna->nama }}:</strong>
                                        <small class="text-muted">Ditambahkan pada: {{ $teknisi->created_at->format('d-m-Y H:i') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('helpdesk.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
    <div class="card custom-card collapse-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
                Ticket Details
            </div>
            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#ticketDetails" aria-expanded="false" aria-controls="ticketDetails">
                <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
            </a>
        </div>
        <div class="collapse show" id="ticketDetails">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>No Tiket:</strong> {{ $ticket->no_tiket }}</p>
                        <p><strong>NIK:</strong> {{ $ticket->nik }}</p>
                        <p><strong>No Inventaris:</strong> {{ $ticket->no_inventaris }}</p>
                        <p><strong>Tanggal:</strong> {{ $ticket->tanggal }}</p>
                        <p><strong>Prioritas:</strong> 
                            @if($ticket->prioritas == 'High')
                                <span class="badge bg-danger">High</span>
                            @elseif($ticket->prioritas == 'Medium')
                                <span class="badge bg-warning">Medium</span>
                            @else
                                <span class="badge bg-success">Low</span>
                            @endif
                        </p>
                        <p class="mb-2">
                        <strong>Status:</strong>
                        @if($ticket->status == 'open')
                            <span class="badge bg-danger">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'in progress')
                            <span class="badge bg-warning text-dark">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'in review')
                            <span class="badge bg-primary">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'close')
                            <span class="badge bg-light text-dark">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'pending')
                            <span class="badge bg-secondary">{{ ucfirst($ticket->status) }}</span>
                        @elseif($ticket->status == 'di jadwalkan')
                            <span class="badge bg-dark">{{ ucfirst($ticket->status) }}</span>
                        @else
                            <span class="badge bg-light text-dark">Unknown</span>
                        @endif
                    </p>

                    </div>
                    <div class="col-md-6">
                        <p><strong>Deadline:</strong> {{ $ticket->deadline }}</p>
                        <p><strong>Judul:</strong> {{ $ticket->judul }}</p>
                        <p><strong>Departemen:</strong> {{ $ticket->departemen }}</p>
                        <p><strong>NIK Teknisi:</strong> {{ $ticket->nik_teknisi }}</p>
                        <p><strong>No HP:</strong> {{ $ticket->no_hp }}</p>
                        <p><strong>Jenis Permintaan:</strong> {{ $ticket->jenis_permintaan }}</p>
                    </div>
                </div>
                <hr>
                <p><strong>Deskripsi:</strong></p>
                <p>{{ $ticket->deskripsi }}</p>
                @if($ticket->upload)
                    <hr>
                    <p><strong>Upload:</strong> 
                        <a href="{{ asset('storage/uploads/' . $ticket->upload) }}" target="_blank">Lihat Lampiran</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

                
</div>
@endsection
