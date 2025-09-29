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
                                                    <ul>
                                                        @foreach ($disposisiAll as $dA)
                                                        <li>
                                                        <span style="font-size: 14px;" class="badge 
                                                                    @if($dA->status_disposisi == 'Dikirim') bg-warning
                                                                    @elseif($dA->status_disposisi == 'Dibaca') bg-success 
                                                                    @elseif($dA->status_disposisi == 'Ditindaklanjuti') bg-success 
                                                                    @elseif($dA->status_disposisi == 'Selesai') bg-success 
                                                                    @endif">
                                                                    {{ $dA->status_disposisi }}
                                                                </span>
                                                        {{$dA->pegawai2->nama}} {{$dA->tanggal_disposisi}}
                                                        <p><span style="font-weight: 900;">Catatan : </span>{{$dA->catatan_disposisi ?? 'Tidak Ada Catatan'}}</p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="col-lg-12">
                                    <form action="{{ route('surat_masuk.tindaklanjutProses', $disposisiTerbaru->id_disposisi_surat) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="status_disposisi">Status Disposisi</label>
                                                @if(in_array($disposisiTerbaru->status_disposisi, ['Dikirim', 'Dibaca']))
                                                    <!-- Jika status Dikirim atau Dibaca, tampilkan dropdown untuk memilih -->
                                                    <select name="status_disposisi" class="form-control" id="status_surat">
                                                        <option value="Ditindaklanjuti">Ditindaklanjuti</option>
                                                        <option value="Selesai">Selesai</option>
                                                    </select>
                                                @else
                                                    <!-- Jika status sudah Disetujui atau Ditolak, tetap tampilkan status dalam dropdown -->
                                                    <select name="status_disposisi" class="form-control" id="status_surat">
                                                        <option value="Ditindaklanjuti" {{ $disposisiTerbaru->status_disposisi == 'Ditindaklanjuti' ? 'selected' : '' }}>Disetujui</option>
                                                        <option value="Selesai" {{ $disposisiTerbaru->status_disposisi == 'Selesai' ? 'selected' : '' }}>Ditolak</option>
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="form-group" id="nik_penerima_container">
                                                <label for="nik_penerima">Pilih Pegawai:</label>
                                                <select name="nik_penerima[]" id="nik_penerima" class="form-control" multiple>
                                                <option value="">-- Select Pegawai --</option>
                                                @foreach ($pegawai as $p)
                                                    <option value="{{ $p->nik }}" }}>{{ $p->nama }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group" id="catatan_container">
                                                <label for="catatan">Catatan Tindak Lanjut:</label>
                                                <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Kirim Tindak Lanjut</button>
                                        </form>
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
            const element = document.getElementById('nik_penerima');
            const choices = new Choices(element, {
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'top', // Display dropdown below the element
                shouldSort: false, // Avoid sorting if not necessary
                removeItemButton: true, // Allows users to remove selected items
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_surat');
            const nikPenerimaContainer = document.getElementById('nik_penerima_container');

            // Fungsi untuk mengatur visibilitas elemen berdasarkan status
            function toggleFields() {
                if (statusSelect.value === 'Selesai') {
                    nikPenerimaContainer.style.display = 'none'; // Sembunyikan nik_penerima
                } else {
                    nikPenerimaContainer.style.display = 'block'; // Tampilkan nik_penerima
                }
            }
        
            // Jalankan fungsi saat halaman dimuat
            toggleFields();
        
            // Tambahkan event listener untuk perubahan dropdown
            statusSelect.addEventListener('change', toggleFields);
        });
        </script>
@endsection