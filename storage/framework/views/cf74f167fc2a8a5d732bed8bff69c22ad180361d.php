<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('app.name', 'Srikandi')); ?></title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin dashboard template, admin panel html, bootstrap dashboard, admin dashboard, html template, template dashboard html, html css, bootstrap 5 admin template, bootstrap admin template, bootstrap 5 dashboard, admin panel html template, dashboard template bootstrap, admin dashboard html template, bootstrap admin panel, simple html template, admin dashboard bootstrap">
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('backend/assets/images/brand-logos/favicon.ico')); ?>" type="image/x-icon">

    <!-- CSS Files -->
    <link id="style" href="<?php echo e(asset('backend/assets/libs/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('backend/assets/css/styles.min.css')); ?>" rel="stylesheet">

    <!-- JavaScript Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('backend/assets/js/main.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/assets/js/custom.js')); ?>"></script>

    <!-- Custom Styles -->
    <style>
        .page {
            min-height: 78vh !important;
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="loader">
        <img src="<?php echo e(asset('backend/assets/images/media/loader.svg')); ?>" alt="Loader">
    </div>

    <!-- Page Content -->
    <div class="page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No Inventaris</th>
                                    <td><?php echo e($inventaris->no_inventaris); ?></td>
                                </tr>
                                <tr>
                                    <th>Kode Barang</th>
                                    <td><?php echo e($inventaris->kode_barang); ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td><?php echo e($inventaris->barang->nama_barang ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th>Produsen</th>
                                    <td><?php echo e(optional($inventaris->barang->produsen)->nama_produsen ?? 'Tidak Diketahui'); ?></td>
                                </tr>
                                <tr>
                                    <th>Merk</th>
                                    <td><?php echo e(optional($inventaris->barang->merk)->nama_merk ?? 'Tidak Diketahui'); ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Ruang</th>
                                    <td><?php echo e(optional($inventaris->ruang)->nama_ruang ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th>Asal Barang</th>
                                    <td><?php echo e($inventaris->asal_barang); ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengadaan</th>
                                    <td><?php echo e($inventaris->tgl_pengadaan); ?></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td><?php echo e(number_format($inventaris->harga, 2)); ?></td>
                                </tr>
                                <tr>
                                    <th>Status Barang</th>
                                    <td><?php echo e($inventaris->status_barang); ?></td>
                                </tr>
                                <tr>
                                    <th>ID Ruang</th>
                                    <td><?php echo e($inventaris->id_ruang); ?></td>
                                </tr>
                                <tr>
                                    <th>No Rak</th>
                                    <td><?php echo e($inventaris->no_rak); ?></td>
                                </tr>
                                <tr>
                                    <th>No Box</th>
                                    <td><?php echo e($inventaris->no_box); ?></td>
                                </tr>
                            </table>

                            <h4>Gambar Inventaris</h4>
                            <div class="row">
                                <?php $__currentLoopData = $inventaris->gambar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gambar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3">
                                        <img src="http://192.168.10.74/webapps2/inventaris/<?php echo e($gambar->photo); ?>" class="img-fluid" alt="Gambar Inventaris">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/detail_inventaris.blade.php ENDPATH**/ ?>