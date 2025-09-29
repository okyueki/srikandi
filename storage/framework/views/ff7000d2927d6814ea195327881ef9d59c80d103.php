<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Create Inventaris'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Inventaris</h3>
        </div>
        <div class="card-body">
            <!-- Form utama, pastikan enctype ditambahkan -->
            <form action="<?php echo e(route('inventaris.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <!-- Include bagian form dari file terpisah -->
                <?php echo $__env->make('inventaris.form_inventaris', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Choices.js untuk semua dropdown
        const kodeBarang = new Choices('#kode_barang', {
            searchEnabled: true,
            shouldSort: false,
        });

        const asalBarang = new Choices('#asal_barang', {
            searchEnabled: true,
            shouldSort: false,
        });

        const statusBarang = new Choices('#status_barang', {
            searchEnabled: true,
            shouldSort: false,
        });

        const idRuang = new Choices('#id_ruang', {
            searchEnabled: true,
            shouldSort: false,
        });
    });

    // Mengambil data barang berdasarkan pilihan kode_barang
    $(document).ready(function() {
        $('#kode_barang').change(function() {
            var kode_barang = $(this).val();
            if (kode_barang) {
                $.ajax({
                    url: '/get-barang-info/' + kode_barang,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#produsen').val(data.produsen);
                        $('#merk').val(data.merk);
                    }
                });
            } else {
                $('#produsen').val('Tidak Diketahui');
                $('#merk').val('Tidak Diketahui');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/create_inventaris.blade.php ENDPATH**/ ?>