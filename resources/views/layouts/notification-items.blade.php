@forelse ($notifications as $item)
    @if ($item instanceof \App\Models\VerifikasiSurat)
        {{-- Notifikasi Verifikasi Surat --}}
        <li class="dropdown-item">
            <div class="d-flex messages">
                <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                    <img src="{{ asset('backend/assets/images/faces/12.jpg') }}" alt="img">
                </span>
                <div>
                    <div class="d-flex">
                        <a href="{{ route('surat_masuk.index') }}">
                            <h6 class="mb-1 name">[Verifikasi Surat] {{ $item->surat->perihal ?? 'Tanpa Perihal' }}</h6>
                        </a>
                    </div>
                    <p class="mb-0 fs-12 desc">Dari: {{ $item->surat->pegawai->nama ?? '-' }}</p>
                </div>
            </div>
        </li>
    @elseif ($item instanceof \App\Models\DisposisiSurat)
        {{-- Notifikasi Disposisi Surat --}}
        <li class="dropdown-item">
            <div class="d-flex messages">
                <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                    <img src="{{ asset('backend/assets/images/faces/4.jpg') }}" alt="img">
                </span>
                <div>
                    <div class="d-flex">
                        <a href="{{ route('surat_masuk.index') }}">
                            <h6 class="mb-1 name">[Disposisi Surat] {{ $item->surat->perihal ?? 'Tanpa Perihal' }}</h6>
                        </a>
                    </div>
                    <p class="mb-0 fs-12 desc">Dari: {{ $item->surat->pegawai->nama ?? '-' }}</p>
                </div>
            </div>
        </li>
    @elseif ($item instanceof \App\Models\PengajuanLibur)
        {{-- Notifikasi Pengajuan Libur --}}
        <li class="dropdown-item">
            <div class="d-flex messages">
                <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                    <img src="{{ asset('backend/assets/images/faces/1.jpg') }}" alt="img">
                </span>
                <div>
                    <div class="d-flex">
                        <a href="{{ route('verifikasi_pengajuan_libur.index') }}">
                            <h6 class="mb-1 name">[Pengajuan Libur] {{ $item->pegawai->nama ?? '-' }}</h6>
                        </a>
                    </div>
                    <p class="mb-0 fs-12 desc">Tanggal: {{ \Carbon\Carbon::parse($item->tanggal_awal)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_akhir)->format('d M') }}</p>
                </div>
            </div>
        </li>
    @endif
@empty
    <li class="dropdown-item text-center">Tidak ada notifikasi</li>
@endforelse