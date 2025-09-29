<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    <?php echo e($title); ?>

                </div>
                <div class="prism-toggle">
                    <button class="btn btn-sm btn-primary-light" onclick="window.location='<?php echo e(route('penilaian_individu.create')); ?>'">
                        <i class="ri-add-line align-middle me-1"></i>Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Bulan Penilaian</th>
                                <th scope="col">NIK Atasan</th>
                                <th scope="col">Nama Atasan</th>
                                <th scope="col">NIK Bawahan</th>
                                <th scope="col">Nama Bawahan</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Total Nilai</th>
                                <th scope="col">Total Persentase</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $penilaians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $penilaian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <th scope="row"><?php echo e($index + 1); ?></th>
                                    <td><?php echo e($penilaian->tanggal); ?></td>
                                    <td><?php echo e($penilaian->penilaian_bulan); ?></td>
                                    <td><?php echo e($penilaian->nik_atasan); ?></td>
                                    <td><?php echo e($penilaian->nama_atasan); ?></td>
                                    <td><?php echo e($penilaian->nik_bawahan); ?></td>
                                    <td><?php echo e($penilaian->nama_bawahan); ?></td>
                                    <td><?php echo e($penilaian->departemen); ?></td>
                                    <td><?php echo e($penilaian->total_nilai); ?></td>
                                    <td><?php echo e($penilaian->total_persentase); ?>%</td>
                                    <td>
                                        <div class="btn-list">
                                            <a href="<?php echo e(route('kpi.penilaian.show', $penilaian->id)); ?>" class="btn btn-sm btn-info btn-wave waves-effect waves-light">
                                                <i class="ri-eye-line align-middle me-2 d-inline-block"></i>Detail
                                            </a>
                                            <a href="<?php echo e(route('kpi.penilaian.edit', $penilaian->id)); ?>" class="btn btn-sm btn-warning btn-wave waves-effect waves-light">
                                                <i class="ri-edit-line align-middle me-2 d-inline-block"></i>Edit
                                            </a>
                                            <form action="<?php echo e(route('kpi.penilaian.destroy', $penilaian->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger btn-wave waves-effect waves-light">
                                                    <i class="ri-delete-bin-line align-middle me-2 d-inline-block"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada data penilaian.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/kpi/penilaian_individu_index.blade.php ENDPATH**/ ?>