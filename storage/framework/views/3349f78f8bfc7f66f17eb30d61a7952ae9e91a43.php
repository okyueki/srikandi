<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Jadwal Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kelola Jadwal Presensi</h3>
                        <ul class="nav nav-tabs l_tinynav1">
                            <li class="active">
                                <a href="<?php echo e(route('jadwal.index')); ?>" role="tab">Jadwal</a>
                            </li>
                            <li class="">
                                <a href="#">Tambah</a>
                            </li>
                        </ul>
                    </div>
            
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col col-md-6">
                                <h3 style="margin-top:5px;margin-bottom:15px;">Jumlah: <?php echo e($jadwalPegawai->total()); ?> || Bulan: <?php echo e(strtoupper(date('M', mktime(0, 0, 0, $bulan, 1)))); ?></h3>
                            </div>
            
                            <div class="row mb-4">
                                <form method="GET" action="<?php echo e(route('jadwal.index')); ?>" class="row mb-4">
                                <div class="col-md-3">
                                    <select name="b" id="bulan" class="form-control">
                                        <option value="">Bulan</option>
                                        <?php $__currentLoopData = ['01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php echo e($key == $bulan ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            
                                <div class="col-md-4">
                                    <input type="text" name="s" value="<?php echo e($phrase); ?>" class="form-control" placeholder="Cari Nama Pegawai">
                                </div>
                            
                                <div class="col-md-3">
                                    <select name="d" id="departemen" class="form-control">
                                        <option value="">Departemen</option>
                                        <?php $__currentLoopData = $departemenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e($id == $departemen ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            
                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
            
                        <div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-striped margin" style="min-width: 1200px;">
        <thead>
            <tr>
                <th>Nama</th>
                <?php for($i = 1; $i <= 31; $i++): ?>
                    <th><?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $jadwalPegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($jadwal->pegawai->nama); ?></td>
                    <?php for($i = 1; $i <= 31; $i++): ?>
                        <?php
                            $hari = 'h'.$i;
                        ?>
                        <td><?php echo e($jadwal->$hari); ?></td>
                    <?php endfor; ?>
                    <td class="text-right">
                        <a href="<?php echo e(route('jadwal.edit', [$jadwal->id, $bulan, $tahun])); ?>" class="btn btn-success btn-xs">
                            <i class="fa fa-pencil"></i> <span class="hidden-xs">Ganti</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

            
                        <!-- Pagination -->
                       <?php echo e($jadwalPegawai->withQueryString()->links('vendor.pagination.tabler')); ?>

                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/presensi/jadwal_pegawai.blade.php ENDPATH**/ ?>