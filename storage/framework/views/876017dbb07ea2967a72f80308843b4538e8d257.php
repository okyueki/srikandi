<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
        
                        <div class="table-responsive">
                         <table id="asuhan-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No. Rawat</th>
                                        <th>Nama Pasien</th>
                                        <th>Kamar</tht>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->
<script>
$(function () {
    $('#asuhan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?php echo e(route('datadischargenote.index')); ?>',
        columns: [
            { data: 'no_rawat', name: 'no_rawat' },
            { data: 'nama_pasien', name: 'regPeriksa.pasien.nm_pasien' },
            { data: 'nm_bangsal', name: 'kamrInap.kamar.bangsal.nm_bangsal' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/pages/datadischargenote.blade.php ENDPATH**/ ?>