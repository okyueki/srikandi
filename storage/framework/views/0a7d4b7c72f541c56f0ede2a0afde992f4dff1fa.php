<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>

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

                        <form action="<?php echo e(route('users.update', $user->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <select id="pegawai-select" name="pegawai_id" class="form-control">
                                <option value="">-- Select Pegawai --</option>
                                <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->nik); ?>,<?php echo e($p->nama); ?>" <?php echo e($user->username === $p->nik ? 'selected' : ''); ?>>
                                        <?php echo e($p->nama); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username"  id="username"  class="form-control" placeholder="Enter Username" value="<?php echo e($user->username); ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank if not changing">
                            </div>

                            <div class="form-group mb-3">
                                <label for="level">Level:</label>
                                <select name="level" class="form-control">
                                    <option value="Direktur" <?php echo e($user->level == 'Direktur' ? 'selected' : ''); ?>>Direktur</option>
                                    <option value="Kabag" <?php echo e($user->level == 'Kabag' ? 'selected' : ''); ?>>Kabag</option>
                                    <option value="Kabid" <?php echo e($user->level == 'Kabag' ? 'selected' : ''); ?>>Kabid</option>
                                    <option value="Kasie" <?php echo e($user->level == 'Kasie' ? 'selected' : ''); ?>>Kasie</option>
                                    <option value="Koordinator" <?php echo e($user->level == 'Koordinator' ? 'selected' : ''); ?>>Koordinator</option>
                                    <option value="Pelaksana" <?php echo e($user->level == 'Pelaksana' ? 'selected' : ''); ?>>Pelaksana</option>
                                    <option value="Komite" <?php echo e($user->level == 'Komite' ? 'selected' : ''); ?>>Komite</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
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
            
            // Initialize Choices.js
            const choices = new Choices(pegawaiSelect, {
                searchEnabled: true,
                itemSelectText: '',
                placeholderValue: 'Select Pegawai',
            });

            // Update username input field when selection changes
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
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/users/edit.blade.php ENDPATH**/ ?>