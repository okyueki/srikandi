@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Full Calendar</div>
            </div>
            <div class="card-body">
                <div id="calendar2" class="fc fc-media-screen fc-direction-ltr fc-theme-standard"></div>
            </div>
        </div>
    </div>
    
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar2');

            // Pastikan data events diterjemahkan dengan benar
            var events = @json($events);

            // Cek apakah events terdefinisi
            console.log(events); // Untuk memastikan data events diterima dengan benar

            var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: events,
    height: 'auto', // Atur tinggi secara otomatis
    contentHeight: 'auto', // Sesuaikan tinggi konten
});
    </script>
@endsection