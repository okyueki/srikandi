

<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('surat_masuk.update', $surat->id_surat)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat" required>
                                    <?php $__currentLoopData = $klasifikasiSurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $klasifikasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($klasifikasi->id_klasifikasi_surat); ?>" <?php echo e($klasifikasi->id_klasifikasi_surat == $surat->id_klasifikasi_surat ? 'selected' : ''); ?>><?php echo e($klasifikasi->nama_klasifikasi_surat); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_sifat_surat">Sifat Surat</label>
                                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat" required>
                                    <?php $__currentLoopData = $sifatSurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sifat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sifat->id_sifat_surat); ?>" <?php echo e($sifat->id_sifat_surat == $surat->id_sifat_surat ? 'selected' : ''); ?>><?php echo e($sifat->nama_sifat_surat); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nomor_surat">Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control" id="nomor_surat" value="<?php echo e($surat->nomor_surat); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="pengirim_external">Pengirim External</label>
                                <input type="text" name="pengirim_external" class="form-control" id="pengirim_external" value="<?php echo e($surat->pengirim_external); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="perihal">Perihal</label>
                                <input type="text" name="perihal" class="form-control" id="perihal" value="<?php echo e($surat->perihal); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_surat">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control" id="tanggal_surat" value="<?php echo e($surat->tanggal_surat); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_surat_diterima">Tanggal Surat Diterima</label>
                                <input type="date" name="tanggal_surat_diterima" class="form-control" id="tanggal_surat_diterima" value="<?php echo e($surat->tanggal_surat_diterima); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="lampiran">Jumlah Lampiran</label>
                                <input type="text" name="lampiran" class="form-control" id="lampiran" value="<?php echo e($surat->lampiran); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="file_surat">Unggah Surat (PHPWord)</label>
                            <input type="file" name="file_surat" class="form-control" id="file_surat" accept=".docx">
                                <?php if($surat->file_surat): ?>
                                    <small>File saat ini:</small>
                                    <a href="<?php echo e(asset('storage/' . $surat->file_surat)); ?>" class="btn btn-sm btn-primary" download>
                                        Download Surat
                                    </a>
                                <?php else: ?>
                                    <small>Tidak ada file surat</small>
                                <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="file_lampiran">Unggah Lampiran</label>
                            <input type="file" name="file_lampiran" class="form-control" id="file_lampiran" accept=".pdf, .docx">
                                <?php if($surat->file_lampiran): ?>
                                    <small>File saat ini:</small>
                                    <a href="<?php echo e(asset('storage/' . $surat->file_lampiran)); ?>" class="btn btn-sm btn-primary" download>
                                        Download Lampiran
                                    </a>
                                <?php else: ?>
                                    <small>Tidak ada lampiran</small>
                                <?php endif; ?>
                        </div>
                         <button type="submit" class="btn btn-primary">Update Surat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for date field
        flatpickr('#tanggal_surat', {
            dateFormat: "Y-m-d",
        });

        flatpickr('#tanggal_surat_diterima', {
            dateFormat: "Y-m-d",
        });
        // Initialize Choices.js for select elements
        const elements = ['id_klasifikasi_surat', 'id_sifat_surat', 'ttd_utama', 'ttd_1', 'ttd_2', 'ttd_3'];
        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                const choices = new Choices(element, {
                    searchEnabled: true,
                    position: 'bottom',
                    shouldSort: false,
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/surat_masuk/edit.blade.php ENDPATH**/ ?>