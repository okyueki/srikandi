<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <br><br>
                    <img width="225" src="{{ $kop_surat; }}" alt="Siti Fatimah Logo">
               
                    <h4 style="text-align:center;text-decoration:underline;">PERINTAH LEMBUR</h4>
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
                                <td>{{ $pengajuan->pegawai2->nama }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai2->nik }}</td>
                            </tr>
                            <tr>
                                <td>Unit Kerja</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai2->departemen_unit->nama }}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai2->jbtn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <p>Memberikan perintah/instruksi lembur karena: <b>{{ $pengajuan->keterangan }}</b></p>
                </div>
                <div class="col-12">
                    <p>Pada Tanggal <b>{{ $tanggal_awal }}</b> <u>Jam {{ $pengajuan->jam_awal }}</u> s/d Tanggal <b>{{ $tanggal_awal }}</b> <u>{{ $pengajuan->jam_akhir }}</u> kepada:</p>
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
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $pengajuan->pegawai->jbtn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <p>Kepada yang diberi perintah/instruksi untuk melaksanakan lembur dengan sebaik-baiknya.</p>
                    <p>Demikian surat perintah ini dan harap maklum adanya.</p>
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
                                <td style="text-align:center; padding:0px;">Menyetujui Atasan Langsung</td>
                                <td style="text-align:center; padding:0px;">Pemohon</td>
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
                                <td style="text-align:center; padding:0px;">{{ $pengajuan->pegawai2->nama }}</td>
                                <td style="text-align:center; padding:0px;">{{ $pengajuan->pegawai->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>