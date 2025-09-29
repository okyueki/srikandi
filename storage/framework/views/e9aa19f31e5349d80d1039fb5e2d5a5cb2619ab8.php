<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"><?php echo e($title); ?></h1>
    </div>
    <!-- End Page Header -->

    <div class="card custom-card">
        <div class="card-header">
            <div class="card-title">Detail Penilaian</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Periode Penilaian</th>
                        <td><?php echo e($penilaian->penilaian_bulan); ?></td>
                    </tr>
                    <tr>
                        <th>NIK Atasan</th>
                        <td><?php echo e($penilaian->nik_atasan); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Atasan</th>
                        <td><?php echo e($penilaian->nama_atasan); ?></td>
                    </tr>
                    <tr>
                        <th>NIK Bawahan</th>
                        <td><?php echo e($penilaian->nik_bawahan); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Bawahan</th>
                        <td><?php echo e($penilaian->nama_bawahan); ?></td>
                    </tr>
                    <tr>
                        <th>Departemen</th>
                        <td><?php echo e($penilaian->departemen); ?></td>
                    </tr>
                </table>
            </div>

            <div class="mt-4">
                <h5>Nilai Kompetensi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Aspek Penilaian</th>
                                <th>Nilai (0-5)</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kepatuhan</td>
                                <td><?php echo e($penilaian->kepatuhan); ?></td>
                                <td><?php echo e(number_format($penilaian->kepatuhan_persentase, 2)); ?>%</td>
                            </tr>
                            <tr>
                                <td>Keaktifan</td>
                                <td><?php echo e($penilaian->keaktifan); ?></td>
                                <td><?php echo e(number_format($penilaian->keaktifan_persentase, 2)); ?>%</td>
                            </tr>
                            <tr>
                                <td>Budaya Kerja</td>
                                <td><?php echo e($penilaian->budaya_kerja); ?></td>
                                <td><?php echo e(number_format($penilaian->budaya_kerja_persentase, 2)); ?>%</td>
                            </tr>
                            <tr>
                                <td>Kajian</td>
                                <td><?php echo e($penilaian->kajian); ?></td>
                                <td><?php echo e(number_format($penilaian->kajian_persentase, 2)); ?>%</td>
                            </tr>
                            <tr>
                                <td>Kegiatan RS</td>
                                <td><?php echo e($penilaian->kegiatan_rs); ?></td>
                                <td><?php echo e(number_format($penilaian->kegiatan_rs_persentase, 2)); ?>%</td>
                            </tr>
                            <tr>
                                <td>IHT</td>
                                <td><?php echo e($penilaian->iht); ?></td>
                                <td><?php echo e(number_format($penilaian->iht_persentase, 2)); ?>%</td>
                            </tr>
                            <tr class="table-primary">
                                <th>Total</th>
                                <th><?php echo e($penilaian->total_nilai); ?></th>
                                <th><?php echo e(number_format($penilaian->total_persentase, 2)); ?>%</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?php echo e(route('penilaian_individu.index')); ?>" class="btn btn-secondary">
                    <i class="ri-arrow-left-line align-middle me-1"></i>Kembali
                </a>
                <a href="<?php echo e(route('kpi.penilaian.edit', $penilaian->id)); ?>" class="btn btn-warning">
                    <i class="ri-edit-line align-middle me-1"></i>Edit
                </a>
                <form action="<?php echo e(route('kpi.penilaian.destroy', $penilaian->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="ri-delete-bin-line align-middle me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/kpi/penilaian_individu_show.blade.php ENDPATH**/ ?>