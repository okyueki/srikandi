@extends('layouts.pages-layouts')

@section('pageTitle', 'Hasil Generate QR Code')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body text-center">
                @if($agendaBerakhir)
                    <h4 class="card-title text-danger">Agenda Telah Berakhir</h4>
                    <p class="card-text">Agenda <strong>{{ $agenda->judul }}</strong> telah selesai pada <strong>{{ \Carbon\Carbon::parse($agenda->akhir)->format('d M Y, H:i') }}</strong>.</p>
                    <a href="{{ route('backend_acara') }}" class="btn btn-primary mt-3">Kembali ke Daftar Agenda</a>

                @elseif($belumWaktunya)
                    <h4 class="card-title text-warning">Belum Waktunya Absensi</h4>
                    <p class="card-text">
                        QR Code untuk agenda <strong>{{ $agenda->judul }}</strong> belum aktif.<br>
                        Absensi akan dibuka <strong>45 menit sebelum agenda dimulai</strong>.
                    </p>
                    <p class="text-muted">
                        Agenda dimulai: {{ \Carbon\Carbon::parse($agenda->mulai)->format('d M Y, H:i') }}<br>
                        QR Code aktif mulai: {{ $waktuBukaQR->format('d M Y, H:i') }}
                    </p>
                    <a href="{{ route('backend_acara') }}" class="btn btn-primary mt-3">Kembali ke Daftar Agenda</a>

                @else
                    <h4 class="card-title">QR Code Berhasil Dibuat</h4>
                    <p class="card-text">Berikut adalah QR Code untuk agenda Anda:</p>

                    <div class="my-3">
                        <img id="qrCodeImage" src="{{ $qrCodeUrl }}?timestamp={{ time() }}" alt="QR Code" class="img-fluid">
                    </div>

                    <p><strong>Token:</strong> <span id="token">{{ $token }}</span></p>
                    <a href="{{ route('backend_acara') }}" class="btn btn-primary mt-3">Kembali ke Daftar Agenda</a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Hanya load script jika QR aktif --}}
{{-- Hanya load script jika QR aktif --}}
@if(!$agendaBerakhir && !$belumWaktunya)
<script>
    var agendaId = {{ $agendaId }};
    var currentToken = "{{ $token }}";

    // Fungsi untuk generate QR baru
    function updateQRCode() {
        $.ajax({
            url: '/generate-qrcode',
            type: 'GET',
            data: { agenda_id: agendaId },
            success: function(data) {
                if (data.qrCodeUrl) {
                    $('#qrCodeImage').attr('src', data.qrCodeUrl + '?timestamp=' + new Date().getTime());
                }
                if (data.token) {
                    $('#token').text(data.token);
                    currentToken = data.token; // update token aktif
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal memperbarui QR Code:", error);
            }
        });
    }

    // Cek apakah token sudah dipakai
    function checkTokenStatus() {
        $.ajax({
            url: "{{ route('check.token.status') }}",
            type: 'GET',
            data: { agenda_id: agendaId, token: currentToken },
            success: function(res) {
                if (res.used) {
                    updateQRCode(); // kalau sudah dipakai → ganti QR baru
                }
            },
            error: function(err) {
                console.error("Gagal cek token:", err);
            }
        });
    }

    // Refresh otomatis setiap 3 menit
    setInterval(updateQRCode, 180000);

    // Cek token tiap 5 detik
    setInterval(checkTokenStatus, 5000);
</script>
@endif
@endsection