<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ config('app.name', 'SIKAT') }} || Sistem Informasi Kepegawaian dan Arsip Surat</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin dashboard template,admin panel html,bootstrap dashboard,admin dashboard,html template,template dashboard html,html css,bootstrap 5 admin template,bootstrap admin template,bootstrap 5 dashboard,admin panel html template,dashboard template bootstrap,admin dashboard html template,bootstrap admin panel,simple html template,admin dashboard bootstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/assets/images/brand-logos/favicon.ico'); }}" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('backend/assets/libs/bootstrap/css/bootstrap.min.css'); }}" rel="stylesheet" >
    <!-- Style Css -->
    <link href="{{ asset('backend/assets/css/styles.min.css'); }}" rel="stylesheet" >
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.css'); }}" rel="stylesheet" >
    <link href="{{ asset('backend/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Node Waves Css -->
    <link href="{{ asset('backend/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">
    <!-- Simplebar Css -->
    <link href="{{ asset('backend/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@simonwep/pickr/themes/nano.min.css') }}"> 
    <!-- Full Calender Css -->
    <link href="{{ asset('vendor/fullcalendar/dist/index.global.js') }}" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- DataTables CSS -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />   
    <!-- Sweetalerts CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Sweetalerts JS -->
    <script src="{{ asset('backend/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Apex Charts JS -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Choices JS -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <!-- Main Theme Js -->
    <script src="{{ asset('backend/assets/js/main.js'); }}"></script>
    <!-- DataTables JS -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Dropify -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/dropify/dist/dropify.min.css') }}">
    <script src="{{ asset('backend/assets/libs/dropify/dist/dropify.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/flatpickr/flatpickr.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/libs/@simonwep/pickr/pickr.es5.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/date&time_pickers.js'); }}"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
     
<style>
   .choices__inner {
        min-height: 44px; /* Sesuaikan dengan kebutuhan */
        max-height: 200px; /* Membatasi tinggi maksimal dropdown */
    }

    .choices__list--dropdown .choices__item {
        white-space: nowrap; /* Mencegah teks terpotong jika terlalu panjang */
    }
    .dz-progress {
        display: none !important;
    }
    .flatpickr-time input {
        padding: 15px;
    }
    table.dataTable {
        margin-top: 15px !important;
        margin-bottom: 15px !important;
        border-collapse: collapse !important;
    }

    .list-group-item {
            border: none;
            position: relative;
        }
        .sub-list {
            padding-left: 30px;
            border-left: 2px solid #007bff;
        }
    .table-responsive {
    overflow-x: auto !important; /* Tambahkan !important untuk memaksa */
    
}
#header-cart-items-scroll, #header-notification-scroll, #header-shortcut-scroll {
    max-height: 32rem !important;
}
    
</style>
</head>

<body>
    <div class="container">
    <h4>Daftar Discharge Note</h4>
    <table id="asuhan-table" class="table table-bordered">
        <thead>
            <tr>
                <th>No. Rawat</th>
                <th>Nama Pasien</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Dokter</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>
 <script src="{{ asset('vendor/fullcalendar/dist/index.global.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/@popperjs/core/umd/popper.min.js'); }}"></script>
<script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>
<script src="{{ asset('backend/assets/js/defaultmenu.min.js'); }}"></script>
<script src="{{ asset('backend/assets/libs/node-waves/waves.min.js'); }}"></script>
<script src="{{ asset('backend/assets/js/sticky.js'); }}"></script>
<script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js'); }}"></script>
<script src="{{ asset('backend/assets/js/simplebar.js'); }}"></script>
<script src="{{ asset('backend/assets/js/custom-switcher.min.js'); }}"></script>
<script src="{{ asset('backend/assets/js/custom.js'); }}"></script>
<script>
$(function () {
    $('#asuhan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('dischargenotepublic.index') }}',
         columns: [
            { data: 'no_rawat', name: 'no_rawat' },
            { data: 'nama_pasien', name: 'regPeriksa.pasien.nm_pasien' },
            { data: 'tgl_masuk', name: 'tgl_masuk' },
            { data: 'tgl_keluar', name: 'tgl_keluar' },
            { data: 'dokter', name: 'dokter.nm_dokter' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
</body>

</html>