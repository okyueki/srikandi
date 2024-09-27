<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
       <style>
        @page {
            size: A4;
            margin: 0 1.5cm;
        }
        .container-fluid {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y, 0));
            margin-right: calc(-0.5 * var(--bs-gutter-x, 0));
            margin-left: calc(-0.5 * var(--bs-gutter-x, 0));
        }

        .col-12 {
            flex: 0 0 auto;
            width: 100%;
        }
        .text-center {
            text-align: center !important;
        }

        .text-decoration-underline {
            text-decoration: underline !important;
        }
        .mt-4 {
            margin-top: 1.5rem !important;
        }
        .br-4 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        p, h3 {
            padding : 0;
            margin : 0;
        }
        .table-bordered, .table-borderless {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table-borderless, th, td {
            border: 0px;
        }
        .table-borderless th, .table-borderless td {
            border: 0px solid #dee2e6 !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered  tr th, .table-bordered tr td {
            padding: 0.75rem;
            vertical-align: top;
            text-align: center;
        }

        .table-bordered thead tr th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

    </style>
</head>
<body>
    <div class="a4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <img width="280" src="{{ $kop_surat }}" alt="Siti Fatimah Logo">
                   
                    <h4 style="text-align:center;text-decoration:underline;">PERMOHONAN IJIN</h4>
                </div>
                <div class="col-12">
                    <br>
                    <p>Kepada Yth.: Direktur</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di Rumah Sakit ‘Aisyiyah Siti Fatimah Tulangan</p>
                </div>
                <div class="col-12">
                    <p>Assalamu ‘alaikum Warahmatullahi Wabarakaatuh</p>
                </div>
                <div class="col-12">
                    <p>Yang bertanda tangan dibawah ini, saya :</p>
                </div>
                <div class="col-12">
                    <table class="table table-borderless no-padding">
                    <tbody>
                            <tr>
                                <td style="width:200px;">Nama Lengkap</td>
                                <td style="width:30px;">:</td>
                                <td>{{ $pengajuan->pegawai->nama }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai->nik }}</td>
                            </tr>
                            <tr>
                                <td>Unit Kerja</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai->departemen_unit->nama }}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai->jbtn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <p>Dengan ini mengajukan permohonan :</p>
                </div>
                <div class="col-12">
                    <h3 style="text-align:center;text-decoration:underline;">Ijin {{ $pengajuan->keterangan }}</h3>
                </div>
                <div class="col-12">
                    <p>Selama <b>{{ $pengajuan->jumlah_hari }} Hari</b> <u>Pada Hari {{  $tanggal_awal }}</u> dan bekerja kembali pada Hari <u>{{ $tanggal_akhir }}</u> Selama izin saya dapat dihubungi di:</p>
                </div>
                <div class="col-12">
                    <table class="table table-borderless no-padding">
                        <tbody>
                            <tr>
                                <td style="width:200px;">Alamat</td>
                                <td style="width:30px;">:</td>
                                <td style="white-space: wrap;width:500px;">{{ $pengajuan->pegawai->alamat }}</td>
                            </tr>
                            <tr>
                                <td style="width:200px;">No. Hp</td>
                                <td style="width:30px;">:</td>
                                <td>{{ $pengajuan->petugas->no_telp }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <p>Demikian permohonan ini, atas perhatiannya disampaikan terima kasih.</p>
                    <p>Wassalamu ‘alaikum Warahmatullahi Wabarakaatuh</p>
                </div>
                <div class="col-12">
                    <table class="table table-borderless no-padding">
                        <tbody>
                            <tr>
                                <td></td>
                                <td style="text-align:center;">Sidoarjo, {{ $tanggal_dibuat }}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Menyetujui Atasan Langsung</td>
                                <td style="text-align:center;">Pemohon</td>
                            </tr>
                            <tr>
                            <td align="center">
                                    @if($pengajuan->status == 'Disetujui')
                                    <img style="width:150px; padding:0px;" src="{{ $qrcode }}" alt="QR Code Pemohon">
                                    @endif
                                </td>
                                <td align="center">
                                    <img style="width:150px; padding:0px;" src="{{ $qrcode }}" alt="QR Code Pemohon">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">{{ $pengajuan->pegawai2->nama }}</td>
                                <td style="text-align:center;">{{ $pengajuan->pegawai->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>