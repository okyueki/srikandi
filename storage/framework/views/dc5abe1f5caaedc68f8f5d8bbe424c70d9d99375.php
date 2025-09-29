<?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php if($item instanceof \App\Models\VerifikasiSurat): ?>
        
        <li class="dropdown-item">
            <div class="d-flex messages">
                <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                    <img src="<?php echo e(asset('backend/assets/images/faces/12.jpg')); ?>" alt="img">
                </span>
                <div>
                    <div class="d-flex">
                        <a href="<?php echo e(route('surat_masuk.index')); ?>">
                            <h6 class="mb-1 name">[Verifikasi Surat] <?php echo e($item->surat->perihal ?? 'Tanpa Perihal'); ?></h6>
                        </a>
                    </div>
                    <p class="mb-0 fs-12 desc">Dari: <?php echo e($item->surat->pegawai->nama ?? '-'); ?></p>
                </div>
            </div>
        </li>
    <?php elseif($item instanceof \App\Models\DisposisiSurat): ?>
        
        <li class="dropdown-item">
            <div class="d-flex messages">
                <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                    <img src="<?php echo e(asset('backend/assets/images/faces/4.jpg')); ?>" alt="img">
                </span>
                <div>
                    <div class="d-flex">
                        <a href="<?php echo e(route('surat_masuk.index')); ?>">
                            <h6 class="mb-1 name">[Disposisi Surat] <?php echo e($item->surat->perihal ?? 'Tanpa Perihal'); ?></h6>
                        </a>
                    </div>
                    <p class="mb-0 fs-12 desc">Dari: <?php echo e($item->surat->pegawai->nama ?? '-'); ?></p>
                </div>
            </div>
        </li>
    <?php elseif($item instanceof \App\Models\PengajuanLibur): ?>
        
        <li class="dropdown-item">
            <div class="d-flex messages">
                <span class="avatar avatar-md me-2 online avatar-rounded flex-shrink-0">
                    <img src="<?php echo e(asset('backend/assets/images/faces/1.jpg')); ?>" alt="img">
                </span>
                <div>
                    <div class="d-flex">
                        <a href="<?php echo e(route('verifikasi_pengajuan_libur.index')); ?>">
                            <h6 class="mb-1 name">[Pengajuan Libur] <?php echo e($item->pegawai->nama ?? '-'); ?></h6>
                        </a>
                    </div>
                    <p class="mb-0 fs-12 desc">Tanggal: <?php echo e(\Carbon\Carbon::parse($item->tanggal_awal)->format('d M')); ?> - <?php echo e(\Carbon\Carbon::parse($item->tanggal_akhir)->format('d M')); ?></p>
                </div>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <li class="dropdown-item text-center">Tidak ada notifikasi</li>
<?php endif; ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/layouts/notification-items.blade.php ENDPATH**/ ?>