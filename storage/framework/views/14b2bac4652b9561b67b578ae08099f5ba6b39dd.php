<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Profil'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Profil Pegawai</div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td><?php echo e($pegawai->nama); ?></td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td><?php echo e($pegawai->nik); ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td><?php echo e($pegawai->jk); ?></td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td><?php echo e($pegawai->jbtn); ?></td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td><?php echo e($pegawai->departemen_unit->nama_departemen ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td><?php echo e(\Carbon\Carbon::parse($pegawai->tgl_lahir)->format('d F Y')); ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?php echo e($pegawai->alamat); ?></td>
                        </tr>
                        <tr>
                            <th>Kota</th>
                            <td><?php echo e($pegawai->kota); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/profil/show.blade.php ENDPATH**/ ?>