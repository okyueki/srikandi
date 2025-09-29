@extends('layouts.pages-layouts')

@section('pageTitle', 'Kalender Agenda')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h2 class="mb-4">Kalender Agenda</h2>
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
        var events = @json($events);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            events: events,
            
            eventDidMount: function(info) {
                var tooltipContent = `
                    <div>
                        <strong>Judul:</strong> ${info.event.title} <br>
                        <strong>Deskripsi:</strong> ${info.event.extendedProps.deskripsi ?? '-'} <br>
                        <strong>Tempat:</strong> ${info.event.extendedProps.tempat ?? '-'} <br>
                        <strong>Pimpinan Rapat:</strong> ${info.event.extendedProps.pimpinan_rapat ?? '-'} <br>
                        <strong>Notulen:</strong> ${info.event.extendedProps.notulen ?? '-'} <br>
                        <strong>Keterangan:</strong> ${info.event.extendedProps.keterangan ?? '-'} <br>
                        <strong>Yang Terundang:</strong> ${info.event.extendedProps.yang_terundang ?? '-'}
                    </div>
                `;
                info.el.setAttribute('data-bs-toggle', 'tooltip');
                info.el.setAttribute('data-bs-html', 'true');
                info.el.setAttribute('title', tooltipContent);

                new bootstrap.Tooltip(info.el);
            },
            
            // Event click listener
            eventClick: function(info) {
                // Redirect to the event detail page
                window.location.href = '/agenda/show/' + info.event.id; // Use event's ID to redirect
            }
        });

        calendar.render();
    });
</script>
@endpush

