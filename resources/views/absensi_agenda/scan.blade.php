@extends('layouts.pages-layouts')

@section('pageTitle', 'Scan QR Code')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body text-center">
                <h3>Scan QR Code</h3>
                <div id="qr-reader" style="width: 100%; max-width: 600px; margin: auto;"></div>
                <div id="qr-reader-results" class="mt-3">
                    <p id="result" style="font-weight: bold;"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- html5-qrcode Library -->
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
    // Pastikan CSRF token disertakan dalam semua request
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Pastikan elemen #qr-reader ada sebelum inisialisasi
    const qrReader = new Html5Qrcode("qr-reader");
    let scanning = true;        // kontrol apakah kita menerima scan
    let isProcessing = false;   // lock untuk AJAX agar tidak ganda
    let scannerRunning = false; // status start/stop scanner

    // Fungsi utama yang dipanggil saat QR terbaca
    async function processScannedData(decodedText) {
        if (!scanning || isProcessing) return;

        console.log("[QR] decoded:", decodedText);
        isProcessing = true;   // lock segera
        scanning = false;

        // Pastikan kita hentikan scanner dulu (tunggu sampai benar-benar berhenti)
        try {
            if (scannerRunning) {
                await qrReader.stop();
                scannerRunning = false;
                // qrReader.clear() tidak selalu diperlukan, tapi bisa dipanggil bila perlu:
                // await qrReader.clear();
            }
        } catch (err) {
            console.warn("[QR] stop() gagal:", err);
            // lanjutkan saja — mungkin scanner sudah berhenti
        }

        // Parsing QR (harus JSON sesuai asumsi). Jika tidak JSON → tampil pesan & restart
        let data;
        try {
            data = JSON.parse(decodedText);
        } catch (err) {
            console.error("[QR] parse error:", err);
            isProcessing = false;
            scanning = true;
            Swal.fire({
                icon: 'error',
                title: 'QR Code tidak valid',
                text: 'QR tidak dalam format JSON yang diharapkan. Pastikan scan kode yang benar.',
                timer: 2500,
                showConfirmButton: false
            }).then(() => {
                setTimeout(restartScanner, 700);
            });
            return;
        }

        // Kirim ke backend menggunakan await agar mudah di-handle
        try {
            const response = await $.ajax({
                url: "/scan-attendance",
                method: "POST",
                data: {
                    agenda_id: data.agenda_id,
                    token: data.token
                },
                dataType: 'json',
                timeout: 15000 // 15 detik
            });

            // Response sukses dari server
            if (response && response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Kehadiran berhasil dicatat: ' + (response.message || ''),
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/absensi_agenda";
                });
                return;
            } else {
                // Server merespon tetapi flag success false
                const msg = (response && response.message) ? response.message : 'Gagal mencatat kehadiran';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Jika pesan menyebut "sudah melakukan absensi" → tutup, jika tidak → restart
                    if (msg.toLowerCase().includes("sudah melakukan absensi")) {
                        window.close();
                    } else {
                        setTimeout(restartScanner, 700);
                    }
                });
                return;
            }

        } catch (xhr) {
            // AJAX gagal (network / status error)
            console.error("[AJAX] error:", xhr);

            // Coba ambil pesan dari server (jika ada)
            let serverMsg = null;
            try {
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) serverMsg = xhr.responseJSON.message;
            } catch (e) { /* ignore */ }

            if (xhr && xhr.status === 409) {
                // Conflict: sudah absen
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: serverMsg || 'Anda sudah melakukan absensi untuk agenda ini.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/absensi_agenda";
                });
            } else if (xhr && xhr.status === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi gagal',
                    text: 'Tidak dapat terhubung ke server. Periksa jaringan atau server backend.',
                    timer: 2500,
                    showConfirmButton: false
                }).then(() => setTimeout(restartScanner, 1000));
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: serverMsg || 'Terjadi kesalahan, silakan coba lagi.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => setTimeout(restartScanner, 700));
            }
        } finally {
            isProcessing = false;
        }
    }

    // Restart/start scanner dengan proteksi agar tidak dipanggil ganda
    async function restartScanner() {
        if (scannerRunning || isProcessing) {
            console.log("[QR] restartScanner: dibatalkan (sudah running atau processing)");
            return;
        }

        // Pastikan element ada dan pengguna memberi izin kamera
        try {
            await qrReader.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 300,
                    debug: false
                },
                processScannedData,
                function(errorMessage) {
                    // callback on scan error (per-frame), tidak fatal
                    // console.debug("[QR] frame error:", errorMessage);
                }
            );
            scannerRunning = true;
            scanning = true;
            console.log("[QR] scanner started");
        } catch (err) {
            console.error("[QR] start() gagal:", err);
            // error bisa karena izin kamera ditolak, device tidak ada, atau konflik
            let msg = "Gagal mengaktifkan kamera. Pastikan izin kamera diberikan dan tidak ada aplikasi lain yang menggunakan kamera.";
            if (err && err.name === "NotAllowedError") {
                msg = "Akses kamera ditolak. Izinkan akses kamera pada pop-up browser.";
            }
            Swal.fire({
                icon: 'error',
                title: 'Tidak dapat mengakses kamera',
                text: msg,
                showConfirmButton: true
            });
        }
    }

    // Pastikan memulai scanner saat halaman siap
    $(document).ready(function() {
        restartScanner();
    });

    // (Opsional) jika ingin stop manual dari UI, panggil:
    // async function stopScannerNow() {
    //   if (scannerRunning) {
    //     await qrReader.stop();
    //     scannerRunning = false;
    //   }
    // }
</script>

@endsection
