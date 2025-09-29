<?php $__env->startSection('pageTitle', 'Tambah Agenda Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <h2 class="mb-4">Tambah Agenda Baru</h2>
                <form action="<?php echo e(route('acara_store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Mulai</label>
                        <input type="datetime-local" name="mulai" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Akhir</label>
                        <input type="datetime-local" name="akhir" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Pimpinan Rapat</label>
                        <select name="pimpinan_rapat" class="form-control" required>
                            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notulen</label>
                        <select name="notulen" class="form-control" required>
                            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Yang Terundang</label>
                        <select name="yang_terundang[]" id="yang_terundang" class="form-control" multiple required>
                            <option value="all">Pilih Semua</option> <!-- Opsi Pilih Semua -->
                            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto[]" class="form-control" multiple>
                    </div>

                    <div class="form-group">
                        <label>Materi</label>
                        <input type="file" name="materi[]" class="form-control" multiple>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr for both date fields
        flatpickr('input[name="mulai"]', {
            enableTime: true,
            dateFormat: "Y-m-d H:i"
        });
        flatpickr('input[name="akhir"]', {
            enableTime: true,
            dateFormat: "Y-m-d H:i"
        });

        const yangTerundangSelect = document.getElementById('yang_terundang');

        yangTerundangSelect.addEventListener('change', function() {
            // Cek apakah opsi "Pilih Semua" dipilih
            const isSelectAll = Array.from(this.selectedOptions).some(option => option.value === 'all');

            if (isSelectAll) {
                // Jika "Pilih Semua" dipilih, pilih semua opsi
                for (let i = 0; i < this.options.length; i++) {
                    this.options[i].selected = true;
                }
            } else {
                // Jika ada opsi lain yang dipilih, pastikan "Pilih Semua" tidak terpilih
                const selectAllOption = Array.from(this.options).find(option => option.value === 'all');
                if (selectAllOption) {
                    selectAllOption.selected = false;
                }
            }
        });

        // Initialize Choices.js for dropdowns
        new Choices('select[name="pimpinan_rapat"]', {
            searchEnabled: true
        });
        new Choices('select[name="notulen"]', {
            searchEnabled: true
        });
        new Choices('select[name="yang_terundang[]"]', {
            searchEnabled: true,
            removeItemButton: true
        });

        // Tanggal Akhir validation
        const mulaiInput = document.querySelector('input[name="mulai"]');
        const akhirInput = document.querySelector('input[name="akhir"]');

        akhirInput.addEventListener('change', function() {
            const mulaiDate = new Date(mulaiInput.value);
            const akhirDate = new Date(akhirInput.value);

            if (akhirDate < mulaiDate) {
                alert('Tanggal Akhir tidak boleh lebih awal dari Tanggal Mulai!');
                akhirInput.value = ''; // Reset input akhir jika invalid
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/event/acara_create.blade.php ENDPATH**/ ?>