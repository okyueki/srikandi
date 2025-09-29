<?php $__env->startSection('pageTitle', 'Hasil Generate QR Code'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body text-center">
                <?php if($agendaBerakhir): ?>
                    <h4 class="card-title text-danger">Agenda Telah Berakhir</h4>
                    <p class="card-text">Agenda <strong><?php echo e($agenda->judul); ?></strong> telah selesai pada <strong><?php echo e(\Carbon\Carbon::parse($agenda->akhir)->format('d M Y, H:i')); ?></strong>.</p>
                    <a href="<?php echo e(route('backend_acara')); ?>" class="btn btn-primary mt-3">Kembali ke Daftar Agenda</a>

                <?php elseif($belumWaktunya): ?>
                    <h4 class="card-title text-warning">Belum Waktunya Absensi</h4>
                    <p class="card-text">
                        QR Code untuk agenda <strong><?php echo e($agenda->judul); ?></strong> belum aktif.<br>
                        Absensi akan dibuka <strong>45 menit sebelum agenda dimulai</strong>.
                    </p>
                    <p class="text-muted">
                        Agenda dimulai: <?php echo e(\Carbon\Carbon::parse($agenda->mulai)->format('d M Y, H:i')); ?><br>
                        QR Code aktif mulai: <?php echo e($waktuBukaQR->format('d M Y, H:i')); ?>

                    </p>
                    <a href="<?php echo e(route('backend_acara')); ?>" class="btn btn-primary mt-3">Kembali ke Daftar Agenda</a>

                <?php else: ?>
                    <h4 class="card-title">QR Code Berhasil Dibuat</h4>
                    <p class="card-text">Berikut adalah QR Code untuk agenda Anda:</p>

                    <div class="my-3">
                        <img id="qrCodeImage" src="<?php echo e($qrCodeUrl); ?>?timestamp=<?php echo e(time()); ?>" alt="QR Code" class="img-fluid">
                    </div>

                    <p><strong>Token:</strong> <span id="token"><?php echo e($token); ?></span></p>
                    <a href="<?php echo e(route('backend_acara')); ?>" class="btn btn-primary mt-3">Kembali ke Daftar Agenda</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<?php if(!$agendaBerakhir && !$belumWaktunya): ?>
<script>
    var agendaId = <?php echo e($agendaId); ?>;
    var currentToken = "<?php echo e($token); ?>";

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
            url: "<?php echo e(route('check.token.status')); ?>",
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
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/event/generate_qr_code.blade.php ENDPATH**/ ?>