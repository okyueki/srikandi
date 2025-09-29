<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Tiket Helpdesk'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Detail Tiket</div>
                <table class="table table-bordered">
                    <tr>
                        <th>No Tiket</th>
                        <td><?php echo e($ticket->no_tiket); ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td><?php echo e($ticket->nik); ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Permintaan</th>
                        <td><?php echo e($ticket->jenis_permintaan); ?></td>
                    </tr>
                    <tr>
                        <th>Prioritas</th>
                        <td><?php echo e($ticket->prioritas); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo e($ticket->status); ?></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td><?php echo e($ticket->deskripsi); ?></td>
                    </tr>
                    <?php if($ticket->upload): ?>
                    <tr>
                        <th>Upload</th>
                        <td><img src="<?php echo e(asset('uploads/' . $ticket->upload)); ?>" width="100"></td>
                    </tr>
                    <?php endif; ?>
                </table>
                <div>
                <a href="<?php echo e(route('tickets.index')); ?>" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/tickets/show.blade.php ENDPATH**/ ?>