<?php $__env->startSection('pageTitle', 'Tambah Jadwal Budaya Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Tambah Jadwal Budaya Kerja</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('jadwalbudayakerja.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label for="nik" class="form-label">Pilih Petugas</label>
                                <select class="form-control" id="nik" name="nik">
                                    <option value="">-- Pilih Petugas --</option>
                                    <?php $__currentLoopData = $petugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->nip); ?>"><?php echo e($p->nama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_bertugas" class="form-label">Tanggal Bertugas</label>
                                <input type="date" class="form-control" id="tanggal_bertugas" name="tanggal_bertugas" 
                                    value="<?php echo e($tanggal_bertugas); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="shift" class="form-label">Shift</label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="Pagi">Pagi</option>
                                    <option value="Sore">Sore</option>
                                </select>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function () {
        flatpickr('#tanggal_bertugas', { dateFormat: "Y-m-d" });

        const elements = ['nik', 'shift']; 
        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                new Choices(element, {
                    searchEnabled: true,
                    position: 'auto',
                    shouldSort: false,
                    allowHTML: true,
                });
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/jadwal_budaya_kerja/create.blade.php ENDPATH**/ ?>