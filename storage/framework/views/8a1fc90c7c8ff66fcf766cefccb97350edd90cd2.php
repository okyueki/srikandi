<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?php echo e(config('app.name', 'SIKAT')); ?> || Sistem Informasi Kepegawaian dan Arsip Surat</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin dashboard template,admin panel html,bootstrap dashboard,admin dashboard,html template,template dashboard html,html css,bootstrap 5 admin template,bootstrap admin template,bootstrap 5 dashboard,admin panel html template,dashboard template bootstrap,admin dashboard html template,bootstrap admin panel,simple html template,admin dashboard bootstrap">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('backend/assets/images/brand-logos/favicon.ico')); ?>" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="<?php echo e(asset('backend/assets/libs/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" >
    <!-- Style Css -->
    <link href="<?php echo e(asset('backend/assets/css/styles.min.css')); ?>" rel="stylesheet" >
</head>
<body>
    <div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="text-center font-weight-bold mb-4">DISCHARGE NOTE'S</h4>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Pasien:</strong> <?php echo e($asuhan->regPeriksa->pasien->nm_pasien ?? '-'); ?></p>
                    <p><strong>No. RM:</strong> <?php echo e($asuhan->regPeriksa->pasien->no_rkm_medis ?? '-'); ?></p>
                    <p><strong>Jenis Kelamin:</strong> <?php echo e($asuhan->regPeriksa->pasien->jk === 'L' ? 'Laki-laki' : 'Perempuan'); ?></p>
                    <p><strong>Alamat:</strong> <?php echo e($asuhan->regPeriksa->pasien->alamat ?? '-'); ?></p>
                    <p><strong>Dokter Penanggung Jawab:</strong> <?php echo e($asuhan->dokter->nm_dokter ?? '-'); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>No. Rawat:</strong> <?php echo e($asuhan->no_rawat); ?></p>
                    <p><strong>Ruang/Kelas:</strong> <?php echo e($kamarinap->kamar->bangsal->nm_bangsal ?? '-'); ?> / <?php echo e($kamarinap->kamar->kelas ?? '-'); ?></p>
                    <p><strong>Tanggal Masuk:</strong> <?php echo e($asuhan->tgl_masuk); ?></p>
                    <p><strong>Tanggal Pulang:</strong> <?php echo e($asuhan->tgl_keluar); ?></p>
                    <p><strong>Kondisi Saat Pulang:</strong> <?php echo e($asuhan->kondisi_pulang); ?></p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4">DIAGNOSIS</h5>
            <div class="row">
                <div class="col-md-6"><strong>Diagnosis Saat Masuk:</strong><br><?php echo e($asuhan->diagnosa_awal); ?></div>
                <div class="col-md-6"><strong>Diagnosis Saat Pulang:</strong><br><?php echo e($asuhan->diagnosa_akhir); ?></div>
            </div>

            <h5 class="mt-4">TINDAKAN YANG DIBERIKAN DI RS</h5>
            <?php $__currentLoopData = $asuhan->tindakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tdk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p>Tindakan <?php echo e($i+1); ?>: <?php echo e($tdk->tindakan); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <h5 class="mt-4">PENGOBATAN YANG DITERIMA</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Nama Generik</th>
                            <th>Dosis</th>
                            <th>Cara Pakai</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $asuhan->obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $obat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><?php echo e($obat->nama_obat); ?></td>
                            <td><?php echo e($obat->nama_obat); ?></td>
                            <td><?php echo e($obat->dosis); ?></td>
                            <td><?php echo e($obat->cara_pakai); ?></td>
                            <td>
                                Frekuensi: <?php echo e($obat->frekuensi ?? '-'); ?>, 
                                Fungsi: <?php echo e($obat->fungsi_obat ?? '-'); ?>,
                                Dosis Terakhir: <?php echo e($obat->dosis_terakhir ?? '-'); ?>,
                                Keterangan: <?php echo e($obat->keterangan ?? '-'); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <h5 class="mt-4">PEMANTAUAN YANG DIPERLUKAN</h5>
            <p><strong>Total waktu tidur:</strong> <?php echo e($asuhan->total_waktu_tidur); ?> jam | 
            <strong>Kualitas tidur:</strong> <?php echo e($asuhan->kualitas_tidur); ?></p>

            <p><strong>Waktu luang:</strong> <?php echo e($asuhan->waktu_luang); ?><br>
<strong>Aktivitas di waktu luang:</strong>
<?php if(is_array($asuhan->aktifitas_luang)): ?>
    <?php echo e(implode(', ', $asuhan->aktifitas_luang)); ?>

<?php elseif(is_string($asuhan->aktifitas_luang)): ?>
    <?php echo e($asuhan->aktifitas_luang); ?>

<?php else: ?>
    -
<?php endif; ?>
<br>
            <strong>Catatan khusus:</strong> <?php echo e($asuhan->catatan_khusus); ?></p>

            <p><strong>Makan:</strong> <?php echo e($asuhan->kalori_makan); ?>x<br>
            <strong>Minum:</strong> <?php echo e($asuhan->nutrisi_minum); ?></p>

            <p><strong>Duduk:</strong> <?php echo e($asuhan->duduk); ?> |
            <strong>Berdiri:</strong> <?php echo e($asuhan->berdiri); ?> |
            <strong>Bergerak:</strong> <?php echo e($asuhan->bergerak); ?></p>

            <p><strong>BAK:</strong> <?php echo e($asuhan->bak); ?> |
            <strong>BAB:</strong> <?php echo e($asuhan->bab); ?></p>

            <p><strong>Kondisi Umum:</strong> <?php echo e($asuhan->kesehatan_umum); ?> |
            <strong>Tensi:</strong> <?php echo e($asuhan->tensi); ?> |
            <strong>RR:</strong> <?php echo e($asuhan->rr); ?> |
            <strong>SPO2:</strong> <?php echo e($asuhan->spo2); ?> |
            <strong>Temp:</strong> <?php echo e($asuhan->temp); ?></p>

            <p><strong>Catatan Tambahan:</strong> <?php echo e($asuhan->catatan_tambahan); ?></p>

            <p class="text-muted mt-4">Laporan dibuat pada: <?php echo e($asuhan->created_at->format('d/m/Y')); ?></p>
        </div>
    </div>
</div>
</body>
</html><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/pages/dischargenote-show.blade.php ENDPATH**/ ?>