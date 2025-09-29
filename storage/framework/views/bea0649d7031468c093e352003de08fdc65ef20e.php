<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Data Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pegawai</h3>
        </div>

        <div class="card-body">
            <!-- Form Pencarian dan Filter -->
            <form method="GET" action="<?php echo e(route('pegawai.index')); ?>" class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari NIK, Nama, Departemen" value="<?php echo e(request()->input('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="stts_aktif" class="form-control">
                        <option value="">Pilih Status Aktif</option>
                        <option value="AKTIF" <?php echo e(request()->input('stts_aktif') == 'AKTIF' ? 'selected' : ''); ?>>AKTIF</option>
                        <option value="CUTI" <?php echo e(request()->input('stts_aktif') == 'CUTI' ? 'selected' : ''); ?>>CUTI</option>
                        <option value="KELUAR" <?php echo e(request()->input('stts_aktif') == 'KELUAR' ? 'selected' : ''); ?>>KELUAR</option>
                        <option value="TENAGA LUAR" <?php echo e(request()->input('stts_aktif') == 'TENAGA LUAR' ? 'selected' : ''); ?>>TENAGA LUAR</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="departemen" class="form-control" placeholder="Departemen" value="<?php echo e(request()->input('departemen')); ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Cari</button>
                </div>
            </form>

            <!-- Jumlah Pegawai -->
            <p>Total Pegawai: <strong><?php echo e($totalPegawai); ?></strong></p>

            <!-- Tabel Pegawai -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>NPWP</th>
                        <th>Status Aktif</th>
                        <th>No KTP</th>
                        <th>Jumlah Pemeriksaan</th> <!-- Kolom baru -->
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pgw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($pgw->id); ?></td>
                            <td><?php echo e($pgw->nik); ?></td>
                            <td><?php echo e($pgw->nama); ?></td>
                            <td><?php echo e($pgw->jbtn); ?></td>
                            <td><?php echo e($pgw->indexinsDepartemen->nama ?? 'Tidak Diketahui'); ?></td> <!-- Tampilkan nama departemen berdasarkan indexins -->
                            <td><?php echo e($pgw->npwp); ?></td>
                            <td><?php echo e($pgw->stts_aktif); ?></td>
                            <td><?php echo e($pgw->no_ktp); ?></td>
                            <td><?php echo e($pgw->pemeriksaan_ralan_count); ?></td> <!-- Jumlah pemeriksaan -->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data yang ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                <?php echo e($pegawai->links('vendor.pagination.tabler')); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/presensi/pegawai.blade.php ENDPATH**/ ?>