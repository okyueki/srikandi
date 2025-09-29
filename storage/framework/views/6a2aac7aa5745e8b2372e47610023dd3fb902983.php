<?php $__env->startSection('pageTitle', 'Edit Jadwal Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<article class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Jadwal Presensi</h3>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="<?php echo e(route('jadwal.index')); ?>" role="tab">Jadwal</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
              <form name="jadwaledit" action="<?php echo e(route('jadwal.update', [$jadwalPegawai->id, $bulan, $tahun])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama</label>
                            <select name="id" id="id" class="form-control selectator">
                                <option value="<?php echo e($jadwalPegawai->pegawai->id); ?>" selected><?php echo e($jadwalPegawai->pegawai->nama); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="tahun" id="tahun" class="form-control selectator">
                                <option value="<?php echo e($tahun); ?>" selected><?php echo e($tahun); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select name="bulan" id="bulan" class="form-control selectator">
                                <option value="<?php echo e($bulan); ?>" selected><?php echo e(date('F', mktime(0, 0, 0, $bulan, 10))); ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <label for="">Tanggal</label>
                <div class="row clearfix">
                  <?php for($i = 1; $i <= 31; $i++): ?>
                    <?php
                        $hari = 'h'.$i;
                    ?>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label><?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></label>
                        <select name="h<?php echo e($i); ?>" id="h<?php echo e($i); ?>" class="form-control selectator">
                            <option value="">Pilih Shift</option> <!-- Ini adalah nilai default jika tidak ada shift yang dipilih -->
                            <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($shift->shift); ?>" 
                                    <?php echo e(old('h'.$i, $jadwalPegawai->$hari) == $shift->shift ? 'selected' : ''); ?>>
                                    <?php echo e($shift->shift); ?> - <?php echo e($shift->jam_masuk); ?> s/d <?php echo e($shift->jam_pulang); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>
                    </div>
                  <?php endfor; ?>
                </div>
                <div class="form-group">
                  <input type="submit" name="save" class="btn btn-primary" value="Simpan" />
                </div>
              </form>
            </div>
        </div>
    </div>
</article>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/presensi/edit_jadwal.blade.php ENDPATH**/ ?>