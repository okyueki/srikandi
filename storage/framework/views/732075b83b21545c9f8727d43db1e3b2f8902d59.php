<?php $__env->startSection('pageTitle', 'Detail Agenda'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h2 class="mb-4"><?php echo e($agenda->judul); ?></h2>
                    <p><strong>Deskripsi:</strong> <?php echo e($agenda->deskripsi); ?></p>
                    <p><strong>Mulai:</strong> <?php echo e(\Carbon\Carbon::parse($agenda->mulai)->format('d M Y H:i')); ?></p>
                    <p><strong>Akhir:</strong> <?php echo e($agenda->akhir ? \Carbon\Carbon::parse($agenda->akhir)->format('d M Y H:i') : '-'); ?></p>
                    <p><strong>Tempat:</strong> <?php echo e($agenda->tempat ?? '-'); ?></p>
                    <p><strong>Pimpinan Rapat:</strong> <?php echo e($agenda->pimpinan->nama ?? '-'); ?></p>
                    <p><strong>Notulen:</strong> <?php echo e($agenda->notulenPegawai->nama ?? '-'); ?></p>
                    <p><strong>Keterangan:</strong> <?php echo e($agenda->keterangan ?? '-'); ?></p>
                    
                    
                    <p><strong>Yang Terundang:</strong> 
                        <?php if($isAll): ?>
                            <span class="badge bg-success">Semua Pegawai (<?php echo e($jumlahTerundang); ?> orang)</span>
                        <?php else: ?>
                            <span class="badge bg-primary"><?php echo e($jumlahTerundang); ?> orang</span>
                        <?php endif; ?>
                    </p>

                    
                    <?php if(!$isAll && !empty($listTerundang)): ?>
                        <div class="mt-2">
                            <strong>Daftar Nama:</strong>
                            <ul class="mb-0">
                                <?php $__currentLoopData = $listTerundang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nik): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $pegawai = \App\Models\Pegawai::on('server_74')->where('nik', $nik)->first();
                                    ?>
                                    <li><?php echo e($pegawai ? $pegawai->nama : 'Pegawai tidak ditemukan (' . $nik . ')'); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php elseif($isAll): ?>
                        <div class="mt-2">
                            <em>Semua pegawai aktif diundang.</em>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/event/acara_show.blade.php ENDPATH**/ ?>