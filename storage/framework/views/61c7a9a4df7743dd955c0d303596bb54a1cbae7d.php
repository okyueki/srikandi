<?php $__env->startSection('pageTitle', 'Detail Inventaris'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Inventaris</h3>
            <a href="<?php echo e(route('inventaris.index')); ?>" class="btn btn-secondary float-right">Kembali</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>No Inventaris</th>
                    <td><?php echo e($inventaris->no_inventaris); ?></td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td><?php echo e($inventaris->kode_barang); ?></td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td><?php echo e($inventaris->barang->nama_barang ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>Produsen</th>
                    <td><?php echo e(optional($inventaris->barang->produsen)->nama_produsen ?? 'Tidak Diketahui'); ?></td>
                </tr>
                <tr>
                    <th>Merk</th>
                    <td><?php echo e(optional($inventaris->barang->merk)->nama_merk ?? 'Tidak Diketahui'); ?></td>
                </tr>
                <tr>
                    <th>Nama Ruang</th>
                    <td><?php echo e(optional($inventaris->ruang)->nama_ruang ?? '-'); ?></td>
                </tr>
                <tr>
                    <th>Asal Barang</th>
                    <td><?php echo e($inventaris->asal_barang); ?></td>
                </tr>
                <tr>
                    <th>Tanggal Pengadaan</th>
                    <td><?php echo e($inventaris->tgl_pengadaan); ?></td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td><?php echo e(number_format($inventaris->harga, 2)); ?></td>
                </tr>
                <tr>
                    <th>Status Barang</th>
                    <td><?php echo e($inventaris->status_barang); ?></td>
                </tr>
                <tr>
                    <th>ID Ruang</th>
                    <td><?php echo e($inventaris->id_ruang); ?></td>
                </tr>
                <tr>
                    <th>No Rak</th>
                    <td><?php echo e($inventaris->no_rak); ?></td>
                </tr>
                <tr>
                    <th>No Box</th>
                    <td><?php echo e($inventaris->no_box); ?></td>
                </tr>
            </table>

            <h4>Gambar Inventaris</h4>
            <div class="row">
                <?php $__currentLoopData = $inventaris->gambar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gambar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <img src="http://192.168.10.74/webapps2/inventaris/<?php echo e($gambar->photo); ?>" class="img-fluid" alt="Gambar Inventaris">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/show_inventaris.blade.php ENDPATH**/ ?>