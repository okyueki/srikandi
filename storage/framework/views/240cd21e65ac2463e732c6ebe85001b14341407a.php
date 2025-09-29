<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="form-group">
    <label for="no_inventaris">No Inventaris</label>
    <input type="text" name="no_inventaris" id="no_inventaris" class="form-control" value="<?php echo e(old('no_inventaris', $inventaris->no_inventaris ?? '')); ?>" required readonly>
</div>

<div class="form-group">
    <label for="kode_barang" class="form-label" >Kode Barang</label>
    <select name="kode_barang" id="kode_barang" class="form-control" required>
        <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->kode_barang); ?>" <?php echo e(old('kode_barang', $inventaris->kode_barang ?? '') == $item->kode_barang ? 'selected' : ''); ?>>
                <?php echo e($item->nama_barang); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="asal_barang">Asal Barang</label>
    <select name="asal_barang" id="asal_barang" class="form-control" required>
        <option value="Beli" <?php echo e(old('asal_barang', $inventaris->asal_barang ?? '') == 'Beli' ? 'selected' : ''); ?>>Beli</option>
        <option value="Bantuan" <?php echo e(old('asal_barang', $inventaris->asal_barang ?? '') == 'Bantuan' ? 'selected' : ''); ?>>Bantuan</option>
        <option value="Hibah" <?php echo e(old('asal_barang', $inventaris->asal_barang ?? '') == 'Hibah' ? 'selected' : ''); ?>>Hibah</option>
        <option value="-" <?php echo e(old('asal_barang', $inventaris->asal_barang ?? '') == '-' ? 'selected' : ''); ?>>-</option>
    </select>
</div>

<div class="form-group">
    <label for="tgl_pengadaan">Tanggal Pengadaan</label>
    <input type="date" name="tgl_pengadaan" id="tgl_pengadaan" class="form-control" value="<?php echo e(old('tgl_pengadaan', $inventaris->tgl_pengadaan ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="harga">Harga</label>
    <input type="number" step="0.01" name="harga" id="harga" class="form-control" value="<?php echo e(old('harga', $inventaris->harga ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="status_barang">Status Barang</label>
    <select name="status_barang" id="status_barang" class="form-control" required>
        <option value="Ada" <?php echo e(old('status_barang', $inventaris->status_barang ?? '') == 'Ada' ? 'selected' : ''); ?>>Ada</option>
        <option value="Rusak" <?php echo e(old('status_barang', $inventaris->status_barang ?? '') == 'Rusak' ? 'selected' : ''); ?>>Rusak</option>
        <option value="Hilang" <?php echo e(old('status_barang', $inventaris->status_barang ?? '') == 'Hilang' ? 'selected' : ''); ?>>Hilang</option>
        <option value="Perbaikan" <?php echo e(old('status_barang', $inventaris->status_barang ?? '') == 'Perbaikan' ? 'selected' : ''); ?>>Perbaikan</option>
        <option value="Dipinjam" <?php echo e(old('status_barang', $inventaris->status_barang ?? '') == 'Dipinjam' ? 'selected' : ''); ?>>Dipinjam</option>
        <option value="-" <?php echo e(old('status_barang', $inventaris->status_barang ?? '') == '-' ? 'selected' : ''); ?>>-</option>
    </select>
</div>

<div class="form-group">
    <label for="id_ruang" class="form-label">Nama Ruang</label>
    <select name="id_ruang" id="id_ruang" class="form-control" required>
        <?php $__currentLoopData = $ruang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r->id_ruang); ?>" <?php echo e(old('id_ruang', $inventaris->id_ruang ?? '') == $r->id_ruang ? 'selected' : ''); ?>>
                <?php echo e($r->nama_ruang); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="no_rak">No Rak</label>
    <input type="text" name="no_rak" id="no_rak" class="form-control" value="<?php echo e(old('no_rak', $inventaris->no_rak ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="no_box">No Box</label>
    <input type="text" name="no_box" id="no_box" class="form-control" value="<?php echo e(old('no_box', $inventaris->no_box ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="gambar">Upload Gambar Inventaris</label>
    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
</div>

<?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/form_inventaris.blade.php ENDPATH**/ ?>