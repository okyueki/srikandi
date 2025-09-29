

<?php $__env->startSection('pageTitle', 'Edit Agenda'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <h2 class="mb-4">Edit Agenda</h2>
                <form action="<?php echo e(route('acara_update', $agenda->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" value="<?php echo e($agenda->judul); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"><?php echo e($agenda->deskripsi); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Mulai</label>
                        <input type="datetime-local" name="mulai" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($agenda->mulai)->format('Y-m-d\TH:i')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Akhir</label>
                        <input type="datetime-local" name="akhir" class="form-control" value="<?php echo e(\Carbon\Carbon::parse($agenda->akhir)->format('Y-m-d\TH:i')); ?>">
                    </div>
                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control" value="<?php echo e($agenda->tempat); ?>">
                    </div>
                    <div class="form-group">
                        <label>Pimpinan Rapat</label>
                        <select name="pimpinan_rapat" class="form-control">
                            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->nik); ?>" <?php echo e($agenda->pimpinan_rapat == $p->nik ? 'selected' : ''); ?>>
                                    <?php echo e($p->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Notulen</label>
                        <select name="notulen" class="form-control">
                            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->nik); ?>" <?php echo e($agenda->notulen == $p->nik ? 'selected' : ''); ?>>
                                    <?php echo e($p->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Yang Terundang</label>
                        <select name="yang_terundang[]" class="form-control" multiple>
                            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->nik); ?>" <?php echo e(in_array($p->nik, $agenda->yang_terundang) ? 'selected' : ''); ?>>
                                    <?php echo e($p->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Materi</label>
                        <input type="file" name="materi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"><?php echo e($agenda->keterangan); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/event/acara_edit.blade.php ENDPATH**/ ?>