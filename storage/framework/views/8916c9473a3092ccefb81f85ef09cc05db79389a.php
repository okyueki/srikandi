<?php $__env->startSection('pageTitle', $pageTitle); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo e($pageTitle); ?></h3>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('inventaris-barang.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo $__env->make('inventaris.form_barang', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Choices.js untuk dropdown
        const kodeProdusen = new Choices('#kode_produsen', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idMerk = new Choices('#id_merk', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idKategori = new Choices('#id_kategori', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idJenis = new Choices('#id_jenis', {
            searchEnabled: true,
            shouldSort: false,
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/create_barang.blade.php ENDPATH**/ ?>