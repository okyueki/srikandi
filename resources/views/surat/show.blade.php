<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ config('app.name', 'Srikandi') }} </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin dashboard template,admin panel html,bootstrap dashboard,admin dashboard,html template,template dashboard html,html css,bootstrap 5 admin template,bootstrap admin template,bootstrap 5 dashboard,admin panel html template,dashboard template bootstrap,admin dashboard html template,bootstrap admin panel,simple html template,admin dashboard bootstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/assets/images/brand-logos/favicon.ico'); }}" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('backend/assets/libs/bootstrap/css/bootstrap.min.css'); }}" rel="stylesheet" >
    <!-- Style Css -->
    <link href="{{ asset('backend/assets/css/styles.min.css'); }}" rel="stylesheet" >
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Main Theme Js -->
    <script src="{{ asset('backend/assets/js/main.js'); }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js'); }}"></script>
    <style>
        .page{
            min-height: 78vh !important;
        }
    </style>
</head>
<body>
      <!-- Loader -->
      <div id="loader" >
        <img src="{{ asset('backend/assets/images/media/loader.svg'); }}" alt="">
    </div>
    <!-- Loader -->
    <div class="page">
    
<div class="container">
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
                                </div>
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel">
                            @if(!empty($surat->file_lampiran))
    @php
        $fileName = basename($surat->file_lampiran);
        $viewerURL = asset('assets/libs/pdfjs/web/viewer.html') . '?file=' . urlencode(route('surat.show', $fileName)) . '&v=' . time();
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

    </div>
    </div>
</body>
<script src="{{ asset('backend/assets/js/custom.js'); }}"></script>
</html>