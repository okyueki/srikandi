<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Helpdesk Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card border border-primary custom-card">
                <div class="card-body">
                    <!-- Judul Tiket -->
                    <h5 class="card-title"><?php echo e($ticket->judul); ?></h5>

                    <!-- No Tiket dan Icon -->
                    <p class="fs-14 fw-semibold mb-2 lh-1">
                        Ticket No: <?php echo e($ticket->no_tiket); ?>

                        <a href="javascript:void(0);" class="float-end text-primary">
                            <i class="bi bi-ticket-perforated"></i>
                        </a>
                    </p>

                    <!-- Nama Pegawai dan Departemen -->
                    <p class="mb-2"><strong>Nama Pegawai:</strong> <?php echo e($ticket->pegawai->nama ?? 'N/A'); ?></p>
                    <p class="mb-2"><strong>Departemen:</strong> <?php echo e($ticket->pegawai->departemen ?? 'N/A'); ?></p>

                    <!-- Informasi Inventaris -->
                    <p class="mb-2"><strong>No Inventaris:</strong> <?php echo e($ticket->no_inventaris); ?></p>
                    <p class="mb-2"><strong>Nama Barang:</strong> <?php echo e($ticket->inventaris->barang->nama_barang ?? 'N/A'); ?></p>

                    <!-- Tanggal dan Deadline -->
                    <p class="mb-2"><strong>Tanggal:</strong> <?php echo e($ticket->tanggal); ?></p>
                    <p class="mb-2"><strong>Deadline:</strong> <?php echo e($ticket->deadline); ?></p>

                    <p class="mb-2">
                        <strong>Prioritas:</strong>
                        <?php if($ticket->prioritas == 'High'): ?>
                            <span class="badge bg-danger"><?php echo e(ucfirst($ticket->prioritas)); ?></span>
                        <?php elseif($ticket->prioritas == 'Medium'): ?>
                            <span class="badge bg-warning"><?php echo e(ucfirst($ticket->prioritas)); ?></span>
                        <?php else: ?>
                            <span class="badge bg-success"><?php echo e(ucfirst($ticket->prioritas)); ?></span>
                        <?php endif; ?>
                    </p>


                    <!-- Status dengan Badge -->
                    <p class="mb-2">
                        <strong>Status:</strong>
                        <?php if($ticket->status == 'open'): ?>
                            <span class="badge bg-danger"><?php echo e(ucfirst($ticket->status)); ?></span>
                        <?php elseif($ticket->status == 'in progress'): ?>
                            <span class="badge bg-warning text-dark"><?php echo e(ucfirst($ticket->status)); ?></span>
                        <?php elseif($ticket->status == 'in review'): ?>
                            <span class="badge bg-primary"><?php echo e(ucfirst($ticket->status)); ?></span>
                        <?php elseif($ticket->status == 'close'): ?>
                            <span class="badge bg-light text-dark"><?php echo e(ucfirst($ticket->status)); ?></span>
                        <?php elseif($ticket->status == 'pending'): ?>
                            <span class="badge bg-secondary"><?php echo e(ucfirst($ticket->status)); ?></span>
                        <?php elseif($ticket->status == 'di jadwalkan'): ?>
                            <span class="badge bg-dark"><?php echo e(ucfirst($ticket->status)); ?></span>
                        <?php else: ?>
                            <span class="badge bg-light text-dark">Unknown</span>
                        <?php endif; ?>
                    </p>
                    <p class="mb-2"><strong>respon tiket:</strong> <?php echo e($ticket->response_time ?? 'Belum ada respon'); ?> </p>
                    <p class="mb-2"><strong>waktu penyelesaian:</strong> <?php echo e($ticket->completion_time ?? 'Belum selesai'); ?> </p>
                    <!-- Teknisi -->
                    <p class="mb-2"><strong>Nama Teknisi:</strong> <?php echo e($ticket->teknisi->nama ?? 'N/A'); ?></p>

                    <!-- Dropdown Action Button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <!-- Item Detail -->
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('helpdesk.ticket.show', $ticket->id)); ?>">Detail</a>
                            </li>
                            <!-- Item Respon -->
                            <li>
                            <a class="dropdown-item" href="<?php echo e(route('responKerja.create', $ticket->id)); ?>">Respon</a>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/helpdesk/dashboard.blade.php ENDPATH**/ ?>