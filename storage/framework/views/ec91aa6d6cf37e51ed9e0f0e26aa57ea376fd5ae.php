<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Tiket Helpdesk'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Daftar Tiket</div>
                <a href="<?php echo e(route('tickets.create')); ?>" class="btn btn-primary mb-3">Buat Tiket Baru</a>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Tiket</th>
                            <th>NIK</th>
                            <th>Jenis Permintaan</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($ticket->no_tiket); ?></td>
                            <td><?php echo e($ticket->nik); ?></td>
                            <td><?php echo e($ticket->jenis_permintaan); ?></td>
                            <td><?php echo e($ticket->status); ?></td>
                            <td><?php echo e($ticket->prioritas); ?></td>
                            <td>
                                <a href="<?php echo e(route('tickets.show', $ticket->id)); ?>" class="btn btn-info btn-sm">Lihat</a>
                                <a href="<?php echo e(route('tickets.edit', $ticket->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form action="<?php echo e(route('tickets.destroy', $ticket->id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus tiket ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                </div>
            </div>    
        </div>        
    </div>            
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/tickets/index.blade.php ENDPATH**/ ?>