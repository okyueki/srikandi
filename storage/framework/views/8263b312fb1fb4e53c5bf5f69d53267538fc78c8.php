<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <a href="<?php echo e(route('struktur_organisasi.create')); ?>" class="btn btn-success waves-effect waves-light mb-3">Create Struktur Organisasi</a>
                        
                        <?php if($message = Session::get('success')): ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: '<?php echo e($message); ?>',
                                        confirmButtonText: 'OK'
                                    });
                                });
                            </script>
                        <?php endif; ?>
                        <div class="list-group">
        <?php $__currentLoopData = $hierarchy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-1"><?php echo e($item->pegawai->nama); ?>

                        <small class="text-muted">(<?php echo e($item->pegawai->jbtn); ?>)</small>
                    </h5>
                    
                    <div>
                        <a href="<?php echo e(route('struktur_organisasi.edit', $item->id_struktur_organisasi)); ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('struktur_organisasi.destroy', $item->id_struktur_organisasi)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    </div>
                </div>

                <?php if(isset($item->children) && count($item->children)): ?>
                    <div class="sub-list mt-2">
                        <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1"><?php echo e($child->pegawai->nama); ?>

                                    <small class="text-muted">(<?php echo e($child->pegawai->jbtn); ?>)</small>
                                    </h6>
                                    <div>
                                        <a href="<?php echo e(route('struktur_organisasi.edit', $child->id_struktur_organisasi)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('struktur_organisasi.destroy', $child->id_struktur_organisasi)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>

                                <?php if(isset($child->children) && count($child->children)): ?>
                                    <div class="sub-list mt-2">
                                        <?php $__currentLoopData = $child->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grandChild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span><?php echo e($grandChild->pegawai->nama); ?>

                                                        <small class="text-muted">(<?php echo e($grandChild->pegawai->jbtn); ?>)</small>
                                                    </span>
                                                    <div>
                                                        <a href="<?php echo e(route('struktur_organisasi.edit', $grandChild->id_struktur_organisasi)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="<?php echo e(route('struktur_organisasi.destroy', $grandChild->id_struktur_organisasi)); ?>" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </div>

                                                <?php if(isset($grandChild->children) && count($grandChild->children)): ?>
                                                    <div class="sub-list mt-2">
                                                        <?php $__currentLoopData = $grandChild->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $greatGrandChild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="list-group-item">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span><?php echo e($greatGrandChild->pegawai->nama); ?>

                                                                        <small class="text-muted">(<?php echo e($greatGrandChild->pegawai->jbtn); ?>)</small>
                                                                    </span>
                                                                    <div>
                                                                        <a href="<?php echo e(route('struktur_organisasi.edit', $greatGrandChild->id_struktur_organisasi)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form action="<?php echo e(route('struktur_organisasi.destroy', $greatGrandChild->id_struktur_organisasi)); ?>" method="POST" class="d-inline">
                                                                            <?php echo csrf_field(); ?>
                                                                            <?php echo method_field('DELETE'); ?>
                                                                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                             <?php if(isset($greatGrandChild->children) && count($greatGrandChild->children)): ?>
                                                                <div class="sub-list mt-2">
                                                                    <?php $__currentLoopData = $greatGrandChild->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $greatGreatGrandChild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <div class="list-group-item">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <span><?php echo e($greatGreatGrandChild->pegawai->nama); ?>

                                                                                    <small class="text-muted">(<?php echo e($greatGreatGrandChild->pegawai->jbtn); ?>)</small>
                                                                                </span>
                                                                                <div>
                                                                                    <a href="<?php echo e(route('struktur_organisasi.edit', $greatGrandChild->id_struktur_organisasi)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </a>
                                                                                    <form action="<?php echo e(route('struktur_organisasi.destroy', $greatGrandChild->id_struktur_organisasi)); ?>" method="POST" class="d-inline">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <?php echo method_field('DELETE'); ?>
                                                                                        <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                     </div>
                                                                 <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <script>
     document.addEventListener('DOMContentLoaded', function () {
        // Attach event listeners to all delete buttons
        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default anchor click behavior
                
                const form = this.closest('form'); // Find the closest form element

                // Check if the form exists
                if (!form) {
                    console.error('Form not found!');
                    return;
                }

                // Display the SweetAlert confirmation
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/struktur_organisasi/index.blade.php ENDPATH**/ ?>