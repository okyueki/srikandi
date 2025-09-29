<?php $__env->startSection('pageTitle', 'Presensi Datang'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <h1>Presensi Pegawai</h1>
            
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
            
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            
                <form action="<?php echo e(route('absensi.handle')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="jam_masuk">Jam Masuk</label>
                        <select name="jam_masuk" id="jam_masuk" class="form-control">
                            <option value="">Pilih Jam Masuk</option>
                            <?php $__currentLoopData = $jamJaga; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($jam->jam_masuk); ?>"><?php echo e($jam->jam_masuk); ?> sd <?php echo e($jam->jam_pulang); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="barcode">Nmr.Kartu</label>
                        <input type="text" name="barcode" id="barcode" class="form-control">
                    </div>
            
                    <div class="form-group">
                        <div id="my_camera"></div>
                        <input type="hidden" name="image" class="image-tag">
                    </div>
            
                    <button type="button" onclick="take_snapshot()" class="btn btn-primary">Ambil Foto</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            
                <div id="results">Hasil foto akan muncul di sini...</div>
            </div>
        </div>
    </div>            
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    Webcam.set({
        width: 370,
        height: 300,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            document.querySelector('.image-tag').value = data_uri;
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/presensi/form.blade.php ENDPATH**/ ?>