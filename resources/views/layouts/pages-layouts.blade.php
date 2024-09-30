<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ config('app.name', 'Srikandi') }} </title>
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
</style>
</head>

<body>

@include('layouts.backend.swithcer')
    <!-- Loader -->
    <div id="loader" >
        <img src="{{ asset('backend/assets/images/media/loader.svg'); }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
         <!-- app-header -->
@include('layouts.backend.header')
        <!-- /app-header -->
@include('layouts.backend.modal')
         <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="index.html" class="header-logo">
                    <img src="{{ asset('backend/assets/images/brand-logos/desktop-logo.png'); }}" alt="logo" class="desktop-logo">
                    <img src="{{ asset('backend/assets/images/brand-logos/toggle-logo.png'); }}" alt="logo" class="toggle-logo">
                    <img src="{{ asset('backend/assets/images/brand-logos/desktop-white.png'); }}" alt="logo" class="desktop-white">
                    <img src="{{ asset('backend/assets/images/brand-logos/toggle-white.png'); }}" alt="logo" class="toggle-white">
                </a>
            </div>
            <!-- End::main-sidebar-header -->

            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">

                <!-- Start::nav -->
@include('layouts.backend.navbar')
                <!-- End::nav -->

            </div>
            <!-- End::main-sidebar -->

        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
         <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">@yield('pageTitle')</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <!-- Breadcrumb dynamic section, customize as needed -->
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @yield('pageHeader')
                </li>
            </ol>
        </nav>
    </div>
    
    <div class="d-flex my-xl-auto right-content align-items-center">
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-info btn-icon me-2 btn-b">
                <i class="mdi mdi-filter-variant"></i>
            </button>
        </div>
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-danger btn-icon me-2">
                <i class="mdi mdi-star"></i>
            </button>
        </div>
        <div class="pe-1 mb-xl-0">
            <button type="button" class="btn btn-warning btn-icon me-2">
                <i class="mdi mdi-refresh"></i>
            </button>
        </div>
        <div class="mb-xl-0">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-expanded="false">
                    14 Aug 2019
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuDate">
                    <li><a class="dropdown-item" href="javascript:void(0);">2015</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2016</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2017</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">2018</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

                <!-- End Page Header -->
                @yield('content')
            </div>
        </div>

        <footer>
        @include('layouts.backend.footer')
        </footer>
    </div>

    
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="las la-angle-double-up"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <script src="{{ asset('vendor/fullcalendar/dist/index.global.min.js') }}"></script>
@stack('scripts')
    <script src="{{ asset('backend/assets/libs/@popperjs/core/umd/popper.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/defaultmenu.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/sticky.js'); }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/simplebar.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/custom-switcher.min.js'); }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js'); }}"></script>

</body>

</html>