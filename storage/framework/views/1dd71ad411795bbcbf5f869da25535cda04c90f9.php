<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>
<!-- end page title -->
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
                <form action="<?php echo e(route('surat_keluar.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_klasifikasi_surat">Klasifikasi Surat</label>
                                <select name="id_klasifikasi_surat" class="form-control" id="id_klasifikasi_surat" required>
                                    <?php $__currentLoopData = $klasifikasiSurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $klasifikasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($klasifikasi->id_klasifikasi_surat); ?>"><?php echo e($klasifikasi->nama_klasifikasi_surat); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_sifat_surat">Sifat Surat</label>
                                <select name="id_sifat_surat" class="form-control" id="id_sifat_surat" required>
                                    <?php $__currentLoopData = $sifatSurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sifat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sifat->id_sifat_surat); ?>"><?php echo e($sifat->nama_sifat_surat); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="perihal">Perihal</label>
                                <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Masukkan perihal" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_surat">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control" id="tanggal_surat" required>
                            </div>
                            <div class="form-group">
                                <label for="lampiran">Jumlah Lampiran</label>
                                <input type="text" name="lampiran" class="form-control" id="lampiran" placeholder="Jumlah lampiran" required>
                            </div>
                            <hr>
                            <div class="form-group mb-3">
                                <label for="ttd_utama">Penandatanganan Surat Utama:</label>
                                <select name="ttd_utama" id="ttd_utama" class="form-control" required>
                                    <option value="">-- Select Pegawai --</option>
                                    <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <hr>

                            <?php for($i = 1; $i <= 3; $i++): ?>
                                <div class="form-group mb-3">
                                    <label for="ttd_<?php echo e($i); ?>">Penandatangan Surat <?php echo e($i + 1); ?> (Opsional):</label>
                                    <select name="ttd_<?php echo e($i+1); ?>" id="ttd_<?php echo e($i+1); ?>" class="form-control">
                                        <option value="">-- Select Pegawai --</option>
                                        <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_surat">Unggah Surat (PHPWord)</label>
                                <input type="file" name="file_surat" class="form-control" id="file_surat" accept=".docx" required>
                            </div>

                            <div class="form-group">
                                <label for="file_lampiran">Unggah Lampiran</label>
                                <input type="file" name="file_lampiran" class="form-control" id="file_lampiran" accept=".pdf">
                            </div> 
                            <button type="submit" class="btn btn-primary">Simpan Surat</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Page-content -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for date field
        flatpickr('#tanggal_surat', {
            dateFormat: "Y-m-d",
        });

        // Initialize Choices.js for select elements
        const elements = ['id_klasifikasi_surat', 'id_sifat_surat', 'ttd_utama', 'ttd_2', 'ttd_3', 'ttd_4'];
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
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/surat_keluar/create.blade.php ENDPATH**/ ?>