<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('users.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <select id="pegawai-select" name="pegawai_id" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->nik); ?>,<?php echo e($p->nama); ?>"><?php echo e($p->nama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" value="<?php echo e(old('username')); ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="form-group mb-3">
                                <label for="level">Level:</label>
                                <select name="level" class="form-control">
                                <option value="Direktur">Direktur</option>
                                    <option value="Kabag">Kabag</option>
                                    <option value="Kabid">Kabid</option>
                                    <option value="Kasie">Kasie</option>
                                    <option value="Koordinator">Koordinator</option>
                                    <option value="Pelaksana">Pelaksana</option>
                                    <option value="Komite">Komite</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const pegawaiSelect = document.getElementById('pegawai-select');
            const usernameInput = document.getElementById('username');
            
            const choices = new Choices(pegawaiSelect, {
                searchEnabled: true,
                itemSelectText: '',
                placeholderValue: 'Select Pegawai',
            });

            pegawaiSelect.addEventListener('change', function () {
                const selectedValue = pegawaiSelect.value;
                if (selectedValue) {
                    // Split the value to extract nik and nama
                    const [nik, nama] = selectedValue.split(',');
                    usernameInput.value = nik;
                } else {
                    usernameInput.value = '';
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/users/create.blade.php ENDPATH**/ ?>