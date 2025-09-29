<?php $__env->startSection('pageTitle', 'Kalender Jadwal Budaya Kerja'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Kalender Jadwal Budaya Kerja</div>
            </div>
            <div class="card-body">
                <div id="calendar2"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar2');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id', // Bahasa Indonesia
                height: 'auto',
                events: '/jadwalbudayakerja/events', // Ambil data dari API Laravel
                dateClick: function(info) {
                    window.location.href = "<?php echo e(route('jadwalbudayakerja.create')); ?>?tanggal=" + info.dateStr;
                },
                eventClick: function(info) {
                    alert(info.event.title + "\n" + info.event.extendedProps.description);
                }
            });

            calendar.render();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/jadwal_budaya_kerja/kalender.blade.php ENDPATH**/ ?>