<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Kamar'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan Pasien</h3>
        </div>
        <!-- Total Pasien -->
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Total Pasien: <?php echo e($dataKamarInap->total()); ?></p>
        </div>
         <div class="card-footer d-flex align-items-center">
        <form action="<?php echo e(route('kamar_inap.index')); ?>" method="GET" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="belum" value="belum" <?php echo e(request('filter') == 'belum' || !request('filter') ? 'checked' : ''); ?>>
                <label class="form-check-label" for="belum">Belum Pulang</label>
            </div>
        </div>

        <div class="col-auto">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="masuk" value="masuk" <?php echo e(request('filter') == 'masuk' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="masuk">Tgl. Masuk:</label>
            </div>
            <input type="date" name="tgl_masuk_awal" class="form-control form-control-sm d-inline-block" style="width:auto;" value="<?php echo e(request('tgl_masuk_awal')); ?>">
            <span class="mx-1">s.d</span>
            <input type="date" name="tgl_masuk_akhir" class="form-control form-control-sm d-inline-block" style="width:auto;" value="<?php echo e(request('tgl_masuk_akhir')); ?>">
        </div>

        <div class="col-auto">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="filter" id="pulang" value="pulang" <?php echo e(request('filter') == 'pulang' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="pulang">Pulang:</label>
            </div>
            <input type="date" name="tgl_keluar_awal" class="form-control form-control-sm d-inline-block" style="width:auto;" value="<?php echo e(request('tgl_keluar_awal')); ?>">
            <span class="mx-1">s.d</span>
            <input type="date" name="tgl_keluar_akhir" class="form-control form-control-sm d-inline-block" style="width:auto;" value="<?php echo e(request('tgl_keluar_akhir')); ?>">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </div>
    </div>
</form>
</div>
        <!-- Search -->
        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="text-muted">
                    Show
                    <div class="mx-2 d-inline-block">
                        <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                    </div>
                    entries
                </div>
                <div class="ms-auto text-muted">
                    Search:
                    <div class="ms-2 d-inline-block">
                        
                        <form action="<?php echo e(route('kamar_inap.index')); ?>" method="GET">
                            <input id="searchInput" name="search" type="text" class="form-control form-control-sm" aria-label="Search invoice" value="<?php echo e(request('search')); ?>">
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>No Rawat</th>
                            <th>Kamar</th>
                            <th>Diagnosa Awal</th>
                            <th>Tanggal Masuk</th>
                            <th>Lama Menginap</th>
                            <th>Nama Dokter</th>
                            <th>Jenis Bayar</th>
                            <th>Total Obat</th>
                            <th>Total Kamar</th>
                            <th>Total Tindakan</th>
                            <th>Total Lab</th>
                            <th>Total Radiologi</th>
                            <th>Total Keseluruhan</th>
                            <th>Plafon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $dataKamarInap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kamar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $no_rawat = str_replace('/', '', $kamar->no_rawat);
                        ?>
                        <tr>
                            <td data-id="<?php echo e($kamar->regPeriksa->pasien->no_rkm_medis ?? '-'); ?>">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo e($kamar->regPeriksa->pasien->no_rkm_medis ?? '-'); ?>

                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('soapie.show', ['no_rawat' => $no_rawat])); ?>">SOAP & Pemeriksaan</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('adimegizi.index', ['no_rawat' => $no_rawat])); ?>">Adime Gizi</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route('kamar_inap.show', $no_rawat)); ?>">Detail Rawat</a>
                                        </li>
                                         <li>
                                            <a class="dropdown-item" href="<?php echo e(route('discharge-note.index', $no_rawat)); ?>">Ringkasan</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td><?php echo e($kamar->regPeriksa->pasien->nm_pasien ?? '-'); ?></td>
                            <td><?php echo e($kamar->no_rawat ?? '-'); ?></td>
                            <td><?php echo e($kamar->kamar->bangsal->nm_bangsal ?? '-'); ?></td>
                            <td><?php echo e($kamar->diagnosa_awal); ?></td>
                            <td><?php echo e($kamar->tgl_masuk); ?></td>
                            <td><?php echo e($kamar->lama); ?></td>
                            <td><?php echo e($kamar->regPeriksa->dokter->nm_dokter ?? '-'); ?></td>
                            <td><?php echo e($kamar->regPeriksa->penjab->png_jawab ?? '-'); ?></td>
                            <td><?php echo e(number_format($kamar->total_obat, 0, ',', '.')); ?>

                            <br> Obat: <?php echo e(number_format(($kamar->total_obat / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.')); ?>% <?php if(($kamar->total_obat / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 30): ?> <span> ⛔</span> <?php endif; ?> </td>
                            <td><?php echo e(number_format($kamar->total_biaya_kamar, 0, ',', '.')); ?> <br> Kamar : <?php echo e(number_format(($kamar->total_biaya_kamar / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.')); ?>%
                                <?php if(($kamar->total_biaya_kamar / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 20): ?>
                                <span>⛔</span>
                                <?php endif; ?> </td>
                            <td><?php echo e(number_format($kamar->total_biaya_tindakan, 0, ',', '.')); ?> <br> Tindakan : <?php echo e(number_format(($kamar->total_biaya_tindakan / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.')); ?>%
                                <?php if(($kamar->total_biaya_tindakan / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 30): ?>
                                <span>⛔</span>
                                <?php endif; ?> </td>
                            <td><?php echo e(number_format($kamar->total_biaya_lab, 0, ',', '.')); ?> <br> Lab : <?php echo e(number_format(($kamar->total_biaya_lab / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.')); ?>%
                                <?php if(($kamar->total_biaya_lab / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 10): ?>
                                <span>⛔</span>
                                <?php endif; ?> </td>
                            <td><?php echo e(number_format($kamar->total_biaya_radiologi, 0, ',', '.')); ?> <br> Radiologi : <?php echo e(number_format(($kamar->total_biaya_radiologi / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100, 0, ',', '.')); ?>% 
                                <?php if(($kamar->total_biaya_radiologi / ($kamar->total_obat + $kamar->total_biaya_kamar + $kamar->total_biaya_tindakan + $kamar->total_biaya_lab + $kamar->total_biaya_radiologi)) * 100 > 10): ?> 
                                <span>⛔</span>
                                <?php endif; ?></td>
                            <td><?php echo e(number_format($kamar->total_keseluruhan, 0, ',', '.')); ?></td>
                            
                            <td>
                                <?php if($kamar->exceedPlafon): ?>
                                <span style="color: red;">Total cost exceeds plafon!</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex align-items-center">
    <p class="m-0 text-muted">Showing <span><?php echo e($dataKamarInap->firstItem()); ?></span> to <span><?php echo e($dataKamarInap->lastItem()); ?></span> of <span><?php echo e($dataKamarInap->total()); ?></span> entries</p>
    <ul class="pagination m-0 ms-auto">
        <?php if($dataKamarInap->onFirstPage()): ?>
            <li class="page-item disabled">
                <span class="page-link">prev</span>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo e($dataKamarInap->previousPageUrl()); ?>&search=<?php echo e(request('search')); ?>" rel="prev">prev</a>
            </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $dataKamarInap->lastPage(); $i++): ?>
            <li class="page-item <?php echo e($dataKamarInap->currentPage() == $i ? 'active' : ''); ?>">
                <a class="page-link" href="<?php echo e($dataKamarInap->url($i)); ?>&search=<?php echo e(request('search')); ?>"><?php echo e($i); ?></a>
            </li>
        <?php endfor; ?>

        <?php if($dataKamarInap->hasMorePages()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo e($dataKamarInap->nextPageUrl()); ?>&search=<?php echo e(request('search')); ?>" rel="next">next</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">next</span>
            </li>
        <?php endif; ?>
    </ul>
</div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/kamar_inap/index.blade.php ENDPATH**/ ?>