<?php $__env->startSection('pageTitle', $title ?? 'Laporan Rawat Inap'); ?>

<?php $__env->startSection('content'); ?>
<?php
    use Carbon\Carbon;
    $currentMonth = Carbon::now()->format('Y-m');
    $months = collect();

    for ($i = 0; $i < 12; $i++) {
        $date = Carbon::now()->subMonths($i);
        $months->push([
            'value' => $date->format('Y-m'),
            'label' => $date->translatedFormat('F Y'),
        ]);
    }
?>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    <?php echo e($title ?? 'Laporan Rawat Inap'); ?>

                </div>
            </div>
            <div class="card-body">

                <!-- Filter Bulan -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="bulan">Bulan :</label>
                        <select id="bulan" name="bulan" class="form-control">
                            <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($month['value']); ?>" <?php echo e($month['value'] === $currentMonth ? 'selected' : ''); ?>>
                                    <?php echo e($month['label']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary">Filter</button>
                        <button id="reset" class="btn btn-secondary ms-2">Reset</button>
                    </div>
                </div>

                <!-- Tabel -->
               <table id="laporan-rawatjalan-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Belum</th>
                        <th>Sudah</th>
                        <th>Batal</th>
                        <th>Berkas Diterima</th>
                        <th>Dirujuk</th>
                        <th>Meninggal</th>
                        <th>Dirawat</th>
                        <th>Pulang Paksa</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
$(document).ready(function () {
    let table;

    function loadTable(bulan = '') {
        if (table) table.destroy();

        table = $('#laporan-rawatjalan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo e(route('pasienrawatjalan.index')); ?>",
                data: { bulan: bulan }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'belum', name: 'belum' },
                { data: 'sudah', name: 'sudah' },
                { data: 'batal', name: 'batal' },
                { data: 'berkas_diterima', name: 'berkas_diterima' },
                { data: 'dirujuk', name: 'dirujuk' },
                { data: 'meninggal', name: 'meninggal' },
                { data: 'dirawat', name: 'dirawat' },
                { data: 'pulang_paksa', name: 'pulang_paksa' },
            ]
        });
    }

    loadTable($('#bulan').val());

    $('#filter').on('click', function () {
        loadTable($('#bulan').val());
    });

    $('#reset').on('click', function () {
        $('#bulan').val("<?php echo e(\Carbon\Carbon::now()->format('Y-m')); ?>");
        loadTable("<?php echo e(\Carbon\Carbon::now()->format('Y-m')); ?>");
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/manajemen/rawatjalan.blade.php ENDPATH**/ ?>