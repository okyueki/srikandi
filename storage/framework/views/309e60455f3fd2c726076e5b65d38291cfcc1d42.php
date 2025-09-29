<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Temporary Presensi'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-xl-12">
    <div class="card custom-card">
        <div class="card-body">
            <h3 class="card-title">Temporary Presensi</h3>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="<?php echo e(route('presensi.index')); ?>">
                <div class="row">
                    <!-- Filter Jabatan -->
                    <div class="col-md-3">
                        <select name="jabatan" class="js-example-basic-single4 form-control">
                            <option value="">Semua Jabatan</option>
                            <?php $__currentLoopData = $allJabatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jabatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($jabatan); ?>" <?php echo e(request('jabatan') == $jabatan ? 'selected' : ''); ?>>
                                    <?php echo e($jabatan); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <!-- Filter Departemen -->
                    <div class="col-md-3">
                        <label for="departemen" class="form-label">Departemen</label>
                        <select id="departemen" name="departemen" class="js-example-basic-single2 form-control">
                            <option value="">-- Pilih Departemen --</option>
                            <?php $__currentLoopData = $allDepartemen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departemen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($departemen); ?>" <?php echo e(request('departemen') == $departemen ? 'selected' : ''); ?>>
                                    <?php echo e($departemen); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Input Pencarian Nama -->
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama" value="<?php echo e(request('search')); ?>">
                    </div>

                    <!-- Tombol Cari -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

            <h3>Presensi Masuk</h3>
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>Shift</th>
                        <th>Ruangan</th>
                        <th>Jam Datang</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $presensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data->pegawai->id); ?></td>
                        <td><?php echo e($data->pegawai->nama); ?></td>
                        <td><?php echo e($data->pegawai->jbtn); ?></td>
                        <td><?php echo e($data->pegawai->departemen); ?></td>
                        <td><?php echo e($data->shift); ?></td>
                        <td><?php echo e($data->pegawai->bidang); ?></td>
                        <td><?php echo e($data->jam_datang); ?></td>
                        <td>
                            <a href="<?php echo e(route('presensi.verifikasi', $data->id)); ?>" class="btn btn-success btn-xs">
                                <i class="fa fa-home"></i> <span class="hidden-xs">Verif</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($presensi->links('vendor.pagination.tabler')); ?>

</div>

<script>
    $(document).ready(function() {
    // Inisialisasi Select2 untuk Jabatan dan Departemen
    $('.js-example-basic-single4').select2();
    $('.js-example-basic-single5').select2();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/presensi/index.blade.php ENDPATH**/ ?>