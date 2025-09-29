<?php $__env->startSection('pageTitle', 'Buat Tiket Helpdesk'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-title">Buat Tiket Baru </div>
                <div class="card-body">
                    <!-- Notifikasi Error -->
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('tickets.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <!-- NIK -->
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <select name="nik" id="nik" class="form-control" required>
                                <option value="">Pilih NIK</option>
                                <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->nik); ?>" <?php echo e(old('nik') == $p->nik ? 'selected' : ''); ?>>
                                        <?php echo e($p->nik); ?> - <?php echo e($p->nama); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Jenis Permintaan -->
                        <div class="form-group">
                            <label for="jenis_permintaan">Jenis Permintaan</label>
                            <select name="jenis_permintaan" class="form-control" required>
                                <option value="">Pilih Jenis Permintaan</option>
                                <?php $__currentLoopData = $jenisPermintaan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($jenis->id); ?>" <?php echo e(old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == $jenis->id ? 'selected' : ''); ?>>
                                        <?php echo e($jenis->nama_permintaan); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['jenis_permintaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="datetime-local" name="tanggal" class="form-control" value="<?php echo e(old('tanggal', $ticket->tanggal ?? now()->format('Y-m-d\TH:i'))); ?>" required>
                            <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Departemen -->
                        <div class="form-group">
                            <label for="departemen">Departemen</label>
                            <select name="departemen" id="departemen" class="form-control" required>
                                <option value="">Pilih Departemen</option>
                                <?php $__currentLoopData = $departemen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($d->dep_id); ?>" <?php echo e(old('departemen', $ticket->departemen ?? '') == $d->dep_id ? 'selected' : ''); ?>>
                                        <?php echo e($d->nama); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['departemen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Prioritas -->
                        <div class="form-group">
                            <label for="prioritas">Prioritas</label>
                            <select name="prioritas" class="form-control" required>
                                <option value="low" <?php echo e(old('prioritas') == 'low' ? 'selected' : ''); ?>>Low</option>
                                <option value="medium" <?php echo e(old('prioritas') == 'medium' ? 'selected' : ''); ?>>Medium</option>
                                <option value="high" <?php echo e(old('prioritas') == 'high' ? 'selected' : ''); ?>>High</option>
                            </select>
                            <?php $__errorArgs = ['prioritas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="open" <?php echo e(old('status') == 'open' ? 'selected' : ''); ?>>Open</option>
                                <option value="in progress" <?php echo e(old('status') == 'in progress' ? 'selected' : ''); ?>>In Progress</option>
                                <option value="in review" <?php echo e(old('status') == 'in review' ? 'selected' : ''); ?>>In Review</option>
                                <option value="close" <?php echo e(old('status') == 'close' ? 'selected' : ''); ?>>Close</option>
                                <option value="di jadwalkan" <?php echo e(old('status') == 'di jadwalkan' ? 'selected' : ''); ?>>Di Jadwalkan</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Judul -->
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" class="form-control" value="<?php echo e(old('judul')); ?>" required>
                            <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" required><?php echo e(old('deskripsi')); ?></textarea>
                            <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Deadline -->
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" value="<?php echo e(old('deadline')); ?>">
                            <?php $__errorArgs = ['deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Upload -->
                        <div class="form-group">
                            <label for="upload">Upload (Gambar)</label>
                            <input type="file" name="upload" class="form-control">
                            <?php $__errorArgs = ['upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- No Inventaris -->
                        <div class="form-group">
                            <label for="no_inventaris">No Inventaris</label>
                            <select name="no_inventaris" class="form-control">
                                <option value="">Pilih No Inventaris (Opsional)</option>
                                <?php $__currentLoopData = $inventaris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($inv->no_inventaris); ?>" <?php echo e(old('no_inventaris', $ticket->no_inventaris ?? '') == $inv->no_inventaris ? 'selected' : ''); ?>>
                                        <?php echo e($inv->no_inventaris); ?> - <?php echo e($inv->nama_barang); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['no_inventaris'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- No HP -->
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo e(old('no_hp', $ticket->no_hp ?? '')); ?>" readonly>
                            <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Tiket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Implementasi Choices.js untuk NIK dan Departemen
    const choicesNik = new Choices('#nik', {
        searchEnabled: true,
        shouldSort: false
    });

    const choicesDepartemen = new Choices('#departemen', {
        searchEnabled: true,
        shouldSort: false
    });

    // Ketika NIK dipilih
    $('#nik').change(function() {
        var nik = $(this).val(); // Ambil nilai NIK yang dipilih

        if (nik) {
            // AJAX request untuk mengambil No HP
            $.ajax({
                url: "<?php echo e(route('get.nohp')); ?>",
                type: "GET",
                data: { nik: nik },
                success: function(response) {
                    // Set value No HP di input
                    $('#no_hp').val(response.no_hp);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Debug error jika terjadi
                }
            });
        } else {
            // Kosongkan input No HP jika NIK tidak dipilih
            $('#no_hp').val('');
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/tickets/create.blade.php ENDPATH**/ ?>