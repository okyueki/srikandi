<?php $__env->startSection('pageTitle', 'Detail Penilaian Harian'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Penilaian Harian</h4>
                    </div>
                    <div class="card-body">
                        <h5>Tanggal: <?php echo e($budayaKerja->tanggal); ?></h5>
                        <h5>Jam: <?php echo e($budayaKerja->jam); ?></h5>
                        <h5>NIK Pegawai: <?php echo e($budayaKerja->nik_pegawai); ?></h5>
                        <h5>Nama Pegawai: <?php echo e($budayaKerja->nama_pegawai); ?></h5>
                        <h5>Departemen: <?php echo e($budayaKerja->departemen); ?></h5>
                        <h5>Jabatan: <?php echo e($budayaKerja->jabatan); ?></h5>
                        <h5>Shift: <?php echo e($budayaKerja->shift); ?></h5>
                        <h5>Total Nilai: <?php echo e($budayaKerja->total_nilai); ?></h5>
                        <h5>Petugas: <?php echo e($budayaKerja->petugas); ?></h5>

                        <h5>Item Penilaian:</h5>
                        <ul>
                            <?php $__currentLoopData = ['sepatu', 'sabuk', 'make_up', 'minyak_wangi', 'jilbab', 'kuku', 'baju', 'celana', 'name_tag', 'perhiasan', 'kaos_kaki']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $item))); ?>: 
                                    <?php echo e($budayaKerja->$item == 1 ? 'Sesuai' : 'Tidak Sesuai'); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <a href="<?php echo e(route('budayakerja.index')); ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/budayakerja/show.blade.php ENDPATH**/ ?>