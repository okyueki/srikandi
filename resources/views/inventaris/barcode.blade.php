<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Sikat') }}</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin dashboard template,admin panel html,bootstrap dashboard,admin dashboard,html template,template dashboard html,html css,bootstrap 5 admin template,bootstrap admin template,bootstrap 5 dashboard,admin panel html template,dashboard template bootstrap,admin dashboard html template,bootstrap admin panel,simple html template,admin dashboard bootstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('backend/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

   <style>
    /* Styling untuk memastikan ukuran 7x4 cm */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f7f7f7;
    }

    .container {
        width: 7cm;
        height: 4cm;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #fff;
        box-sizing: border-box;
        padding: 5px;
    }

    .content {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        height: 100%;
    }

    .barcode-container {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50%;
    }

    .barcode-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .text-container {
        flex: 1;
        padding-left: 5px;
        text-align: left;
        font-size: 10px;
        line-height: 1.2;
    }

    .text-container .text-label {
        font-size: 16px;
    }

    @media print {
        .container {
            width: 7cm;
            height: 4cm;
        }

        .barcode-container img {
            max-width: 100%;
            max-height: 100%;
        }
    }
</style>


</head>

<body>
    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('backend/assets/images/media/loader.svg') }}" alt="">
    </div>

   <div class="container">
    <div class="content">
        <!-- Menampilkan Barcode -->
        <div class="barcode-container">
            <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Barcode">
        </div>

        <!-- Menampilkan Tulisan di Sebelah Kanan -->
        <div class="text-container">
             <div class="text-label">
                 <strong>No Inventaris:</strong>
                {{ $no_inventaris }}
            </div>
            <div class="text-label">
                 <div><strong>Nama Barang:</strong>
                {{ $inventaris->barang->nama_barang }}
            </div>
            <div class="text-label">
                <strong>Lokasi:</strong>
               {{ $inventaris->ruang->nama_ruang }}
            </div>
        </div>
    </div>
</div>

    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
</body>
</html>
