<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <a href="<?php echo e(route('pengajuan_lembur.create')); ?>" class="btn btn-success waves-effect waves-light mb-3">Create Pengajuan Lembur</a>
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
                        <div class="table-responsive">
                        <table class="table table-bordered pengajuan-lembur">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Lembur</th>
                                    <th>Jam Lembur</th>
                                    <th>Status</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(function () {
    
    var table = $('.pengajuan-lembur').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/pengajuan_lembur",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_pegawai', name: 'nama_pegawai'},
            {data: 'keterangan', name: 'keterangan'},
            {data: 'tanggal_lembur', name: 'tanggal_lembur'},
            {data: 'jam_lembur', name: 'jam_lembur'},
            { data: 'status', name: 'status', render: function (data, type, row) {
                    var badgeClass = '';
                    switch(data) {
                        case 'Dikirim':
                            badgeClass = 'badge bg-warning';
                            break;
                        case 'Disetujui':
                            badgeClass = 'badge bg-success';
                            break;
                        case 'Ditolak':
                            badgeClass = 'badge bg-danger';
                            break;
                        default:
                            badgeClass = 'badge bg-secondary';
                    }
                    return '<span style="font-size: 14px;" class="' + badgeClass + '">' + data + '</span>';
                }},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });

  $(document).on('click', '.delete-confirm', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/pengajuan_lembur/index.blade.php ENDPATH**/ ?>