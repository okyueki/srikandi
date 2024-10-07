@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . ' - ' . $title : $title)

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h2 class="mb-4">{{ $title }}</h2>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>    
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // Mengambil data ulang tahun pegawai dan hari libur dari server
            var events = @json($events);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id', // Menggunakan Bahasa Indonesia
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: events, // Event dari controller
                eventDidMount: function(info) {
                    // Menambahkan atribut tooltip pada elemen event
                    var tooltipContent = `
                        <div>
                            <strong>NIK:</strong> ${info.event.extendedProps.nik ?? '-'} <br>
                            <strong>Nama:</strong> ${info.event.title} <br>
                            <strong>Jenis Kelamin:</strong> ${info.event.extendedProps.jk ?? '-'} <br>
                            <strong>Jabatan:</strong> ${info.event.extendedProps.jbtn ?? '-'}
                        </div>
                    `;

                    info.el.setAttribute('data-bs-toggle', 'tooltip');
                    info.el.setAttribute('data-bs-placement', 'top');
                    info.el.setAttribute('data-bs-html', 'true'); // Mengizinkan HTML di tooltip
                    info.el.setAttribute('title', tooltipContent);

                    // Menginisialisasi Bootstrap Tooltip dengan HTML support
                    new bootstrap.Tooltip(info.el, {
                        html: true
                    });
                }
            });

            calendar.render();
        });
    </script>
@endpush