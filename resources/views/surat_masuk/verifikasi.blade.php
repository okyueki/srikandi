@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Detail Surat Keluar</span>    
                                </a>
                             </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">PDF</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#lampiran" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Lampiran</span>    
                                </a>
                            </li>             
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ol class="list-group list-group-numbered">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Nomor Surat</div>
                                                    {{ $surat->nomor_surat }}
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Perihal Surat</div>
                                                    {{ $surat->perihal }}
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                <div class="fw-bold">Pengirim</div>
                                                    @if($surat->nik_pengirim=="")
                                                        {{ $surat->pengirim_external }}
                                                    @else
                                                        {{ $surat->pegawai->nama }}
                                                    @endif
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Sifat</div>
                                                    {{ $surat->sifat_surat->nama_sifat_surat }}
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Tanggal Surat</div>
                                                    {{ $tanggalSurat }}
                                                </div>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="col-lg-6">
                                        <ol class="list-group list-group-numbered">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Verifikasi</div>
                                                    <ul>
                                                        @foreach ($verifikasiSurat as $vS)
                                                        <li>
                                                        <span style="font-size: 14px;" class="badge 
                                                                    @if($vS->status_surat == 'Dikirim') bg-warning
                                                                    @elseif($vS->status_surat == 'Dibaca') bg-success 
                                                                    @elseif($vS->status_surat == 'Disetujui') bg-success 
                                                                    @elseif($vS->status_surat == 'Ditolak') bg-danger 
                                                                    @endif">
                                                                    {{ $vS->status_surat }}
                                                                </span>
                                                        {{$vS->pegawai->nama}} {{$vS->tanggal_verifikasi}}
                                                        <p><span style="font-weight: 900;">Catatan : </span>{{$vS->catatan ?? 'Tidak Ada Catatan'}}</p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Disposisi</div>
                                                    <!-- Tambahkan konten disposisi di sini -->
                                                </div>
                                            </li>
                                        </ol>
                                        <a class="btn btn-info waves-effect waves-light edit" href="{{ route('surat_masuk.edit', $surat->id_surat) }}"><i class="far fa-edit"></i> Edit Surat</a>
                                        <form action="{{ route('surat_masuk.destroy', $surat->id_surat) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger waves-effect waves-light deletesurat">
                                                <i class="far fa-trash-alt"></i> Hapus Surat
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                    @if ($surat->verifikasi)
    <form action="{{ route('surat_masuk.verifikasiProses', $surat->verifikasi->id_verifikasi_surat) }}" method="POST">
        @csrf
        @method('PUT')
                                        <div class="form-group">
                                            <label for="status_surat">Status Verifikasi</label>
                                            @if(in_array($surat->verifikasi->status_surat, ['Dikirim', 'Dibaca']))
                                                <!-- Jika status Dikirim atau Dibaca, tampilkan dropdown untuk memilih -->
                                                <select name="status_surat" class="form-control" id="status_surat">
                                                    <option value="Disetujui">Disetujui</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            @else
                                                <!-- Jika status sudah Disetujui atau Ditolak, tetap tampilkan status dalam dropdown -->
                                                <select name="status_surat" class="form-control" id="status_surat">
                                                    <option value="Disetujui" {{ $surat->verifikasi->status_surat == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                    <option value="Ditolak" {{ $surat->verifikasi->status_surat == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="status_surat">Catatan Verifikasi</label>
                                            <textarea class="form-control" name="catatan" id="text-area" rows="3">{{ $surat->verifikasi->catatan ?? '' }}</textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="nik_atasan_langsung">Atasan Langsung:</label>
                                            <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                                                <option value="">-- Select Pegawai --</option>
                                                @foreach ($pegawai as $p)
                                                    <option value="{{ $p->nik }}"
                                                    @if($atasanLangsung && $atasanLangsung->nik_verifikator == $p->nik)
                                                            selected
                                                        @endif
                                                    >{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Kirim</button>
                                    </form>
                                    @endif
                                    </div>
                                </div>
                            </div>
                                     <!-- Tab 2: PDF Viewer -->
                            <div class="tab-pane" id="profile" role="tabpanel">
                                <!-- Embed PDF.js Viewer -->
                                <iframe src="{{ asset('assets/libs/pdfjs/web/viewer.html?file=' . urlencode($pdfUrl). '?v=' . time()) }}" width="100%" height="600px"></iframe>
        
                            </div>
        
                            <!-- Tab 3: Lampiran -->
                            <div class="tab-pane" id="lampiran" role="tabpanel">
                                @if(!empty($surat->file_lampiran))
    @php
        $fileName = basename($surat->file_lampiran);
        $viewerURL = asset('assets/libs/pdfjs/web/viewer.html') . '?file=' . urlencode(route('surat_masuk.show', $fileName)) . '&v=' . time();
        $downloadURL = Storage::url($surat->file_lampiran);
    @endphp

    <iframe src="{{ $viewerURL }}" width="100%" height="600px"></iframe>

    <p class="text-center mt-3">
        <a href="{{ $downloadURL }}" class="btn btn-primary" download>Download PDF</a>
    </p>
@else
    <h4 class="text-center">Tidak Ada Lampiran</h4>
@endif
                            </div>
                        </div>                                  
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('nik_atasan_langsung');
            const choices = new Choices(element, {
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'top', // Menampilkan dropdown di bawah elemen
                shouldSort: false, // Menghindari pengurutan jika tidak diperlukan
            });

        });
        </script>
@endsection