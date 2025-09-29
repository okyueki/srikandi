<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
           
            <div class="card-body">
                <div class="row gy-4">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <h4><strong>Nama Pegawai:</strong> <?php echo e($Pegawai->nama); ?> <br>
                    <strong>NIK:</strong> <?php echo e($Pegawai->nik); ?></h4>

    <form action="<?php echo e(route('berkas_pegawai.update', $Pegawai->nik)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="accordion" id="accordionExample">
            <?php $__currentLoopData = $jenisBerkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo e($key); ?>">
                        <button class="accordion-button <?php echo e($key !== 0 ? 'collapsed' : ''); ?>" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse<?php echo e($key); ?>" 
                                aria-expanded="<?php echo e($key === 0 ? 'true' : 'false'); ?>" 
                                aria-controls="collapse<?php echo e($key); ?>">
                            <?php echo e($jenis->jenis_berkas); ?>

                        </button>
                    </h2>
                    <div id="collapse<?php echo e($key); ?>" 
                         class="accordion-collapse collapse <?php echo e($key === 0 ? 'show' : ''); ?>" 
                         aria-labelledby="heading<?php echo e($key); ?>" 
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php
                                $berkas = $berkasPegawai->firstWhere('id_jenis_berkas', $jenis->id);
                            ?>

                            <!-- Nomor Berkas -->
                            <div class="mb-3">
                                <label for="nomor_berkas_<?php echo e($jenis->id); ?>" class="form-label">Nomor Berkas</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nomor_berkas_<?php echo e($jenis->id); ?>" 
                                       name="nomor_berkas[<?php echo e($jenis->id); ?>]" 
                                       value="<?php echo e($berkas->nomor_berkas ?? ''); ?>">
                            </div>

                            <!-- Existing File Information -->
                            <?php if($berkas && $berkas->file): ?>
                                <p><strong>Berkas Saat Ini:</strong></p>
                                <a href="<?php echo e(asset('storage/' . $berkas->file)); ?>" target="_blank">Download</a>
                            <?php else: ?>
                                <p><strong>Berkas Saat Ini:</strong> Belum ada berkas</p>
                            <?php endif; ?>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <label for="file_<?php echo e($jenis->id); ?>" class="form-label">Unggah Berkas Baru</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="file_<?php echo e($jenis->id); ?>" 
                                       name="file[<?php echo e($jenis->id); ?>]">
                            </div>

                            <!-- Status Berkas -->
                            <div class="mb-3">
                                <label for="status_berkas_<?php echo e($jenis->id); ?>" class="form-label">Status Berkas</label>
                                <select class="form-control" 
                                        id="status_berkas_<?php echo e($jenis->id); ?>" 
                                        name="status_berkas[<?php echo e($jenis->id); ?>]">
                                    <option value="valid" <?php echo e(($berkas->status_berkas ?? '') == 'Masih Berlaku' ? 'selected' : ''); ?>>Masih Berlaku</option>
                                    <option value="invalid" <?php echo e(($berkas->status_berkas ?? '') == 'Tidak Berlaku' ? 'selected' : ''); ?>>Tidak Berlaku</option>
                                    <option value="pending" <?php echo e(($berkas->status_berkas ?? '') == 'Proses Pengajuan' ? 'selected' : ''); ?>>Proses Pengajuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo e(route('berkas_pegawai.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/berkas_pegawai/edit.blade.php ENDPATH**/ ?>