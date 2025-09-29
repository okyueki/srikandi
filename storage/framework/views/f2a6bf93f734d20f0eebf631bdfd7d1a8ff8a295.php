<?php $__env->startSection('pageTitle', $pageTitle); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title"><?php echo e($pageTitle); ?></h3>
            <a href="<?php echo e(route('inventaris-barang.create')); ?>" class="btn btn-primary">Tambah Barang</a>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <div class="table-responsive">
            <table class="table table-bordered table-hover" id="inventaris-barang-table">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Produsen</th>
                        <th>Merk</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan dimuat secara dinamis oleh DataTables -->
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan AJAX
        $('#inventaris-barang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/inventaris-barang',
            columns: [
                { data: null, searchable: false, orderable: false, render: function (data, type, row, meta) {
                    return meta.row + 1; // Menambahkan nomor urut
                }},
                { data: 'kode_barang', name: 'kode_barang' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'jml_barang', name: 'jml_barang' },
                { data: 'produsen', name: 'produsen' },
                { data: 'merk', name: 'merk' },
                { data: 'kategori', name: 'kategori' },
                { data: 'jenis', name: 'jenis' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/index_barang.blade.php ENDPATH**/ ?>