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
                                    <form action="{{ route('surat_masuk.verifikasiDisposisiProses', $surat->verifikasi->id_verifikasi_surat) }}" method="POST">
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
                                            <label for="status_surat">Catatan</label>
                                            <textarea class="form-control" name="catatan" id="text-area" rows="3">{{ $surat->verifikasi->catatan ?? '' }}</textarea>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="CheckDisposisi">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Disposisi
                                            </label>
                                        </div>

                                        <div class="form-group mb-3" id="NikDisposisi">
                                            <label for="nik_penerima">Disposisi Ke:</label>
                                            <select name="nik_penerima" id="nik_penerima" class="form-control">
                                                <option value="">-- Select Pegawai --</option>
                                                @foreach ($pegawai as $p)
                                                    <option value="{{ $p->nik }}" {{ isset($disposisi) && $p->nik == $disposisi->nik_penerima ? 'selected' : '' }}>{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="CatatanDisposisi">
                                            <label for="catatan_disposisi">Catatan Disposisi</label>
                                            <textarea class="form-control" name="catatan_disposisi" id="catatan_disposisi" rows="3">{{ isset($disposisi) ? $disposisi->catatan_disposisi : '' }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success waves-effect waves-light">Kirim</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel">
                            <object data="{{ $pdfUrl }}" type="application/pdf" width="100%" height="400px">
                                <!-- Pesan fallback jika PDF tidak dapat dimuat -->
                                <p>Your browser does not support PDFs. Please download the PDF to view it: <a href="{{ $pdfUrl }}">Download PDF</a>.</p>
                            </object> 
                        
                            </div>
                            <div class="tab-pane" id="lampiran" role="tabpanel">
                            @if(!empty($surat->file_lampiran))
                                <object data="{{ Storage::url($surat->file_lampiran) }}" type="application/pdf" width="100%" height="400px">
                                    <!-- Pesan fallback jika PDF tidak dapat dimuat -->
                                    <p>Your browser does not support PDFs. Please download the PDF to view it: <a href="{{ Storage::url($surat->file_lampiran) }}">Download PDF</a>.</p>
                                </object>
                            @else
                                <h4>Tidak Ada Lampiran</h4>
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
                position: 'top', // Menampilkan dropdown di bawah elemen
                shouldSort: false, // Menghindari pengurutan jika tidak diperlukan
            });

        });
        document.addEventListener('DOMContentLoaded', function () {
            const CheckDisposisi = document.getElementById('CheckDisposisi');
            const NikDisposisi = document.getElementById('NikDisposisi');
            const CatatanDisposisi = document.getElementById('CatatanDisposisi');

            // Fungsi untuk mengatur visibilitas elemen berdasarkan status
            function toggleFields() {
                if (CheckDisposisi.checked) {
                    NikDisposisi.style.display = 'block'; // Sembunyikan nik_penerima
                    CatatanDisposisi.style.display = 'block'; // Sembunyikan catatan
                } else {
                    NikDisposisi.style.display = 'none'; // Tampilkan nik_penerima
                    CatatanDisposisi.style.display = 'none'; // Tampilkan catatan
                }
            }

            // Jalankan fungsi saat halaman dimuat
            toggleFields();

            // Tambahkan event listener untuk perubahan dropdown
            CheckDisposisi.addEventListener('change', toggleFields);
        });
        </script>
@endsection