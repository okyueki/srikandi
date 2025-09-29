<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title); ?>

<?php $__env->startSection('content'); ?>
<!-- Menyertakan CSS PDF.js -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Detail Surat Keluar</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">PDF</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#lampiran" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Lampiran</span>    
                        </a>
                    </li>           
                </ul>

                <div class="tab-content p-3">
                    <!-- Tab 1: Detail Surat -->
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item"><strong>Nomor Surat:</strong> <?php echo e($surat->nomor_surat); ?></li>
                                    <li class="list-group-item"><strong>Perihal Surat:</strong> <?php echo e($surat->perihal); ?></li>
                                    <li class="list-group-item"><strong>Pengirim:</strong> <?php echo e($surat->pegawai->nama); ?></li>
                                    <li class="list-group-item"><strong>Sifat:</strong> <?php echo e($surat->sifat_surat->nama_sifat_surat); ?></li>
                                    <li class="list-group-item"><strong>Tanggal Surat:</strong> <?php echo e($tanggalSurat); ?></li>
                                </ol>
                            </div>
                            <div class="col-12 col-md-6">
                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item"><strong>Verifikasi:</strong>
                                        <ul>
                                            <?php $__currentLoopData = $verifikasiSurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><span class="badge 
                                                <?php if($vS->status_surat == 'Dikirim'): ?> bg-warning
                                                <?php elseif($vS->status_surat == 'Dibaca'): ?> bg-success 
                                                <?php elseif($vS->status_surat == 'Disetujui'): ?> bg-success 
                                                <?php elseif($vS->status_surat == 'Ditolak'): ?> bg-danger 
                                                <?php endif; ?>"><?php echo e($vS->status_surat); ?></span> <?php echo e($vS->pegawai->nama); ?> (<?php echo e($vS->tanggal_verifikasi); ?>)</li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                    <li class="list-group-item"><strong>Disposisi:</strong>
                                        <ul>
                                            <?php $__currentLoopData = $disposisiAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><span class="badge 
                                                <?php if($dA->status_disposisi == 'Dikirim'): ?> bg-warning
                                                <?php elseif($dA->status_disposisi == 'Dibaca'): ?> bg-success 
                                                <?php elseif($dA->status_disposisi == 'Ditindaklanjuti'): ?> bg-success 
                                                <?php elseif($dA->status_disposisi == 'Selesai'): ?> bg-success 
                                                <?php endif; ?>"><?php echo e($dA->status_disposisi); ?></span> <?php echo e($dA->pegawai2->nama); ?> (<?php echo e($dA->tanggal_disposisi); ?>)</li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: PDF Viewer -->
                    <div class="tab-pane" id="profile" role="tabpanel">
                        <!-- Embed PDF.js Viewer -->
<iframe src="<?php echo e(asset('assets/libs/pdfjs/web/viewer.html?file=' . urlencode($pdfUrl) . '&v=' . time())); ?>" width="100%" height="600px"></iframe>

                    </div>

                    <!-- Tab 3: Lampiran -->
                    <div class="tab-pane" id="lampiran" role="tabpanel">
                        <?php if(!empty($surat->file_lampiran)): ?>
    <?php
        $fileName = basename($surat->file_lampiran);
        $viewerURL = asset('assets/libs/pdfjs/web/viewer.html') . '?file=' . urlencode(route('surat_keluar.show', $fileName)) . '&v=' . time();
        $downloadURL = Storage::url($surat->file_lampiran);
    ?>

    <iframe src="<?php echo e($viewerURL); ?>" width="100%" height="600px"></iframe>

    <p class="text-center mt-3">
        <a href="<?php echo e($downloadURL); ?>" class="btn btn-primary" download>Download PDF</a>
    </p>
<?php else: ?>
    <h4 class="text-center">Tidak Ada Lampiran</h4>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/surat_keluar/detail.blade.php ENDPATH**/ ?>