<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Adime Gizi'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Adime Gizi</h3>
            <div>
                <a href="<?php echo e(route('adimegizi.create',['no_rawat' => $no_rawat])); ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tambah Baru
                </a>
            </div>
        </div>

        <div class="card-body">
            <?php if(count($adimeGizi) > 0): ?>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Tanggal</th>
                            <th>Asesmen</th>
                            <th>Diagnosis</th>
                            <th>Petugas</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $adimeGizi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><span class="text-muted"><?php echo e($index + 1); ?></span></td>
                            <td><?php echo e($item->tanggal); ?></td>
                            <td><?php echo e(Str::limit($item->asesmen, 30)); ?></td>
                            <td><?php echo e(Str::limit($item->diagnosis, 30)); ?></td>
                            <td><?php echo e($item->pegawai->nama); ?></td>
                            <td class="text-end">
                                <div class="btn-list flex-nowrap">
                                    <a href="<?php echo e(route('adimegizi.edit', [$no_rawat, $item->formatted_tanggal])); ?>" class="btn btn-sm btn-info">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('adimegizi.destroy', [$no_rawat, $item->formatted_tanggal])); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            Hapus
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-detail-<?php echo e($index); ?>">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Detail Modal -->
                        <div class="modal fade" id="modal-detail-<?php echo e($index); ?>" tabindex="-1" role="dialog" aria-labelledby="modal-detail-<?php echo e($index); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Adime Gizi - <?php echo e($item->tanggal); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">No. Rawat</label>
                                                <input type="text" class="form-control" value="<?php echo e($item->no_rawat); ?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal</label>
                                                <input type="text" class="form-control" value="<?php echo e($item->tanggal); ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Asesmen</label>
                                            <textarea class="form-control" rows="3" readonly><?php echo e($item->asesmen); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Diagnosis</label>
                                            <textarea class="form-control" rows="3" readonly><?php echo e($item->diagnosis); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Intervensi</label>
                                            <textarea class="form-control" rows="3" readonly><?php echo e($item->intervensi); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Monitoring</label>
                                            <textarea class="form-control" rows="3" readonly><?php echo e($item->monitoring); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Evaluasi</label>
                                            <textarea class="form-control" rows="3" readonly><?php echo e($item->evaluasi); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Instruksi</label>
                                            <textarea class="form-control" rows="3" readonly><?php echo e($item->instruksi); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Petugas</label>
                                            <input type="text" class="form-control" value="<?php echo e($item->pegawai->nama); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty">
                <div class="empty-img">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 8l0 4" />
                        <path d="M12 16l.01 0" />
                    </svg>
                </div>
                <p class="empty-title">No data found</p>
                <p class="empty-subtitle text-muted">
                    No Adime Gizi records found for this patient. Click the button below to add new record.
                </p>
                <div class="empty-action">
                    <a href="<?php echo e(route('adimegizi.create',['no_rawat' => $no_rawat])); ?>" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Baru
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if(count($adimeGizi) > 0): ?>
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Showing <span>1</span> to <span><?php echo e(count($adimeGizi)); ?></span> entries</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/adimegizi/index.blade.php ENDPATH**/ ?>