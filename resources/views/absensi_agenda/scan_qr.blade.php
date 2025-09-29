@extends('layouts.pages-layouts')

@section('pageTitle', 'Scan QR Code')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body text-center">
                <h4 class="card-title">Scan QR Code Kehadiranxxxxxxxxxxxx</h4>
                <p class="card-text">Arahkan kamera ke QR Code untuk absen.</p>

                <!-- QR Code Scanner -->
                <div id="qr-reader" style="width: 100%; max-width: 600px; margin: auto;"></div>
                <div id="qr-reader-results" class="mt-3">
                    <p id="result" style="font-weight: bold;"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
<script>
    // Pastikan CSRF token disertakan dalam semua request
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Inisialisasi QR Scanner
    const qrReader = new Html5Qrcode("qr-reader");
    let scanning = true;        // flag kontrol scanning
    let isProcessing = false;   // lock request supaya tidak ganda

    function processScannedData(decodedText) {
        // Kalau sedang proses atau scanning dimatikan → abaikan
        if (!scanning || isProcessing) return;

        try {
            console.log("Decoded QR data:", decodedText);

            // Matikan scanner supaya tidak baca ulang
            scanning = false;
            isProcessing = true;
            qrReader.stop();

            // Parsing data QR (harus format JSON)
            const data = JSON.parse(decodedText);

            // Kirim ke backend
            $.ajax({
                url: "/scan-attendance",
                type: "POST",
                data: {
                    agenda_id: data.agenda_id,
                    token: data.token
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Kehadiran berhasil dicatat: ' + response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "/absensi_agenda";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Jika sudah absen, cukup tutup jendela
                            if (response.message.includes("sudah melakukan absensi")) {
                                window.close();
                            } else {
                                // Gagal karena alasan lain → aktifkan scan ulang
                                restartScanner();
                            }
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan, coba lagi.';
                    if (xhr.status === 409) {
                        errorMessage = 'Anda sudah melakukan absensi untuk agenda ini.';
                        Swal.fire({
                            icon: 'info',
                            title: 'Info',
                            text: errorMessage,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.close();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            restartScanner();
                        });
                    }
                },
                complete: function() {
                    isProcessing = false; // unlock setelah request selesai
                }
            });

        } catch (error) {
            // Kalau QR tidak valid → hidupkan scanner lagi
            scanning = true;
            isProcessing = false;
            Swal.fire({
                icon: 'error',
                title: 'QR Code tidak valid',
                text: 'Pastikan Anda memindai kode yang benar.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                restartScanner();
            });
        }
    }

    // Fungsi untuk restart scanner
    function restartScanner() {
        scanning = true;
        isProcessing = false;
        qrReader.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 300,
                debug: false
            },
            processScannedData,
            function(error) {
                console.error("QR scanning failed:", error);
            }
        );
    }

    // Jalankan scanner pertama kali
    restartScanner();
</script>


@endsection