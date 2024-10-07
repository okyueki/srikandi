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
                                                    <div class="fw-bold">Nama Pegawai</div>
                                                    {{ $surat->pegawai->nama }}
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
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel">
                            <object data="{{ $pdfUrl }}" type="application/pdf" width="100%" height="400px">
                                <!-- Pesan fallback jika PDF tidak dapat dimuat -->
                                <p>Your browser does not support PDFs. Please download the PDF to view it: <a href="{{ $pdfUrl }}">Download PDF</a>.</p>
                            </object> 
                            @if(!empty($surat->file_lampiran))
                                <a href="{{ asset('storage/' . $surat->file_lampiran) }}" target="_blank" class="btn btn-primary">Download</a>
                            @endif
                            </div>
                        </div>                                  
                    </div>
                </div>
            </div>
        </div>
@endsection