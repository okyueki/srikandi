<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle : 'Data Presensi Pegawai'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Jumlah Terlambat -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Jumlah Terlambat</p>
                        </div>
                        <h4 class="fw-bold mb-2 jumlah-terlambat"><?php echo e($jumlahTerlambat); ?> kali</h4>
                        <div class="progress progress-style progress-sm">
                            <div class="progress-bar bg-danger-gradient persen-terlambat" style="width: <?php echo e($persenTerlambat); ?>%" role="progressbar" aria-valuenow="<?php echo e($persenTerlambat); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <!-- Jumlah Tepat Waktu -->
                    <div class="col-md-6 mt-4 mt-md-0">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Jumlah Tepat Waktu</p>
                        </div>
                        <h4 class="fw-bold mb-2 jumlah-tepat-waktu"><?php echo e($jumlahTepatWaktu); ?> kali</h4>
                        <div class="progress progress-style progress-sm">
                            <div class="progress-bar bg-primary-gradient persen-tepat-waktu" style="width: <?php echo e($persenTepatWaktu); ?>%" role="progressbar" aria-valuenow="<?php echo e($persenTepatWaktu); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                   
                    <!-- Jumlah Wajib Masuk -->
                    <div class="col-md-4 mt-4">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Jumlah Wajib Masuk</p>
                        </div>
                        <h4 class="fw-bold mb-2 wajib-masuk"><?php echo e($wajibMasuk); ?> hari</h4>
                    </div>
                
                    <!-- Hari yang Tidak Hadir -->
                    <div class="col-md-4 mt-4">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Tanggal yang Tidak Hadir</p>
                        </div>
                        <h4 class="fw-bold mb-2 missed-days">
                            <?php if(!empty($missedDays)): ?>
                                <?php echo e(implode(', ', $missedDays)); ?>

                            <?php else: ?>
                                Tidak ada ketidakhadiran
                            <?php endif; ?>
                        </h4>
                    </div>
                    <!-- Hari yang Tidak Hadir -->
                      <div class="col-md-4 mt-4">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Persentase Kehadiran</p>
                        </div>
                        <h4 class="fw-bold mb-2 wajib-masuk"><?php echo e($persenHadir); ?> %</h4>
                    </div>
               
                    
                    <!-- Jadwal Kerja Section -->
                    <?php
                        $daysInIndonesian = [
                            'Monday' => 'Sen',
                            'Tuesday' => 'Sel',
                            'Wednesday' => 'Rab',
                            'Thursday' => 'Kam',
                            'Friday' => 'Jum',
                            'Saturday' => 'Sab',
                            'Sunday' => 'Ahd'
                        ];
                    ?>
                
                    <div class="col-md-12 mt-4">
                        <div class="d-flex align-items-center pb-2">
                            <p class="mb-0">Jadwal Kerja Pegawai (H1 - H<?php echo e(Carbon\Carbon::parse($bulan)->daysInMonth); ?>)</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr id="jadwal-header">
                                        <?php $__currentLoopData = range(1, Carbon\Carbon::parse($bulan)->daysInMonth); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $dayName = Carbon\Carbon::parse($bulan . '-' . $day)->format('l');
                                                $translatedDay = $daysInIndonesian[$dayName] ?? $dayName;
                                            ?>
                                            <th><?php echo e($translatedDay); ?>, <?php echo e(str_pad($day, 2, '0', STR_PAD_LEFT)); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="jadwal-kerja-row">
                                        <?php $__currentLoopData = range(1, Carbon\Carbon::parse($bulan)->daysInMonth); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $field = 'h' . $day;
                                            ?>
                                            <td><?php echo e($jadwalPegawai ? $jadwalPegawai->$field : '-'); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body">
                <!-- Filter Berdasarkan Bulan -->
                <div class="card-title mt-4">Daftar Presensi</div>
                <form action="<?php echo e(route('kepegawaian.rekap_presensi.index')); ?>" method="GET" class="mb-3">
                    <div class="form-group">
                        <label for="bulan">Pilih Bulan:</label>
                        <input type="month" id="bulan" name="bulan" class="form-control" value="<?php echo e($bulan); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>

                <!-- Tabel Presensi -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="rekap-presensi-table">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Departemen</th>
                                <th>Shift</th>
                                <th>Jam Datang</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Keterlambatan</th>
                                <th>Durasi</th>
                                <th>Keterangan</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inisialisasi DataTables dengan AJAX -->
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan AJAX
        $('#rekap-presensi-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/kepegawaian/rekap-presensi',
                data: function (d) {
                    d.bulan = $('#bulan').val();  // Kirim bulan ke server
                }
            },
            columns: [
                { data: 'nama_pegawai', name: 'pegawai.nama' },
                { data: 'departemen', name: 'pegawai.departemen' },
                { data: 'shift', name: 'shift' },
                { data: 'jam_datang', name: 'jam_datang' },
                { data: 'jam_pulang', name: 'jam_pulang' },
                { data: 'status', name: 'status' },
                { data: 'keterlambatan', name: 'keterlambatan' },
                { data: 'durasi', name: 'durasi' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'photo', name: 'photo', orderable: false, searchable: false },
            ]
        });

        // Fungsi untuk memperbarui statistik berdasarkan bulan
        function updateStatistics(bulan) {
            $.ajax({
                url: '<?php echo e(route("kepegawaian.rekap_presensi.data")); ?>',
                type: 'GET',
                data: { bulan: bulan },
                success: function(response) {
                    // Update data di halaman sesuai dengan respons dari server
                    $('.jumlah-terlambat').text(response.jumlahTerlambat + ' kali');
                    $('.persen-terlambat').css('width', response.persenTerlambat + '%').attr('aria-valuenow', response.persenTerlambat);
                    
                    $('.jumlah-tepat-waktu').text(response.jumlahTepatWaktu + ' kali');
                    $('.persen-tepat-waktu').css('width', response.persenTepatWaktu + '%').attr('aria-valuenow', response.persenTepatWaktu);

                    $('.wajib-masuk').text(response.wajibMasuk + ' hari');
                    $('.missed-days').text(response.missedDays.length > 0 ? response.missedDays.join(', ') : 'Tidak ada ketidakhadiran');

                    // Update Jadwal Kerja Section
                    let jadwalHtml = '';
                    for (let day = 1; day <= response.daysInMonth; day++) {
                        const field = 'h' + day;
                        jadwalHtml += '<td>' + (response.jadwalPegawai[field] || '-') + '</td>';
                    }
                    $('.jadwal-kerja-row').html(jadwalHtml);
                }
            });
        }

        // Ketika filter bulan diubah, refresh data tabel dan perbarui statistik
        $('#bulan').on('change', function() {
            let bulan = $(this).val();
            updateStatistics(bulan);  // Update statistik
            $('#rekap-presensi-table').DataTable().ajax.reload(); // Reload DataTable
        });

        // Inisialisasi pertama kali untuk bulan saat ini
        updateStatistics($('#bulan').val());
    });
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/presensi/rekap_presensi.blade.php ENDPATH**/ ?>