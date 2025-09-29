<div class="form-group">
    <label for="kode_barang">Kode Barang</label>
    <input type="text" name="kode_barang" id="kode_barang" class="form-control" value="<?php echo e(old('kode_barang', $barang->kode_barang ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="nama_barang">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="<?php echo e(old('nama_barang', $barang->nama_barang ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="jml_barang">Jumlah Barang</label>
    <input type="number" name="jml_barang" id="jml_barang" class="form-control" value="<?php echo e(old('jml_barang', $barang->jml_barang ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="kode_produsen" class="form-label">Produsen</label>
    <select id="kode_produsen" name="kode_produsen" class="form-control" required>
        <option value="">Pilih Produsen</option>
        <?php $__currentLoopData = $produsen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->kode_produsen); ?>" <?php echo e(old('kode_produsen', $barang->kode_produsen ?? '') == $item->kode_produsen ? 'selected' : ''); ?>>
                <?php echo e($item->nama_produsen); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="id_merk" class="form-label">Merk</label>
    <select name="id_merk" id="id_merk" class="form-control" required>
        <option value="">Pilih Merk</option>
        <?php $__currentLoopData = $merk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id_merk); ?>" <?php echo e(old('id_merk', $barang->id_merk ?? '') == $item->id_merk ? 'selected' : ''); ?>>
                <?php echo e($item->nama_merk); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="id_kategori" class="form-label">Kategori</label>
    <select name="id_kategori" id="id_kategori" class="form-control" required>
        <option value="">Pilih Kategori</option>
        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id_kategori); ?>" <?php echo e(old('id_kategori', $barang->id_kategori ?? '') == $item->id_kategori ? 'selected' : ''); ?>>
                <?php echo e($item->nama_kategori); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="id_jenis" class="form-label">Jenis</label>
    <select name="id_jenis" id="id_jenis" class="form-control" required>
        <option value="">Pilih Jenis</option>
        <?php $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id_jenis); ?>" <?php echo e(old('id_jenis', $barang->id_jenis ?? '') == $item->id_jenis ? 'selected' : ''); ?>>
                <?php echo e($item->nama_jenis); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="form-group">
    <label for="thn_produksi">Tahun Produksi</label>
    <input type="number" name="thn_produksi" id="thn_produksi" class="form-control" value="<?php echo e(old('thn_produksi', $barang->thn_produksi ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="isbn">ISBN</label>
    <input type="text" name="isbn" id="isbn" class="form-control" value="<?php echo e(old('isbn', $barang->isbn ?? '')); ?>">
</div><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/inventaris/form_barang.blade.php ENDPATH**/ ?>