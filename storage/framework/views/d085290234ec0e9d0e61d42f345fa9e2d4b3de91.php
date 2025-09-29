<?php $__env->startSection('pageTitle', 'Daftar Agenda'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body"> 
                    <h1>Daftar Agenda</h1>

                    <!-- Tombol Tambah Agenda -->
                    <a href="<?php echo e(route('acara_create')); ?>" class="btn btn-success mb-3">Tambah Agenda</a>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                
                    <table class="table table-bordered" id="agendaTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Tempat</th>
                                <th>Pimpinan Rapat</th>
                                <th>Notulen</th>
                                <th>Jumlah Terundang</th> 
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#agendaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/backend-acara',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'judul', name: 'judul' },
                    { data: 'mulai', name: 'mulai' },
                    { data: 'akhir', name: 'akhir' },
                    { data: 'tempat', name: 'tempat' },
                    { data: 'pimpinan_nama', name: 'pimpinan.nama' },
                    { data: 'notulen_nama', name: 'notulenPegawai.nama' },
                    { data: 'jumlah_terundang', name: 'jumlah_terundang', searchable: false }, // Tambahkan ini
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/event/backend_acara.blade.php ENDPATH**/ ?>