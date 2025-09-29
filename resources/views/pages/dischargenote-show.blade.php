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
</head>
<body>
    <div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="text-center font-weight-bold mb-4">DISCHARGE NOTE'S</h4>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Pasien:</strong> {{ $asuhan->regPeriksa->pasien->nm_pasien ?? '-' }}</p>
                    <p><strong>No. RM:</strong> {{ $asuhan->regPeriksa->pasien->no_rkm_medis ?? '-' }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $asuhan->regPeriksa->pasien->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    <p><strong>Alamat:</strong> {{ $asuhan->regPeriksa->pasien->alamat ?? '-' }}</p>
                    <p><strong>Dokter Penanggung Jawab:</strong> {{ $asuhan->dokter->nm_dokter ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>No. Rawat:</strong> {{ $asuhan->no_rawat }}</p>
                    <p><strong>Ruang/Kelas:</strong> {{ $kamarinap->kamar->bangsal->nm_bangsal ?? '-' }} / {{ $kamarinap->kamar->kelas ?? '-' }}</p>
                    <p><strong>Tanggal Masuk:</strong> {{ $asuhan->tgl_masuk }}</p>
                    <p><strong>Tanggal Pulang:</strong> {{ $asuhan->tgl_keluar }}</p>
                    <p><strong>Kondisi Saat Pulang:</strong> {{ $asuhan->kondisi_pulang }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4">DIAGNOSIS</h5>
            <div class="row">
                <div class="col-md-6"><strong>Diagnosis Saat Masuk:</strong><br>{{ $asuhan->diagnosa_awal }}</div>
                <div class="col-md-6"><strong>Diagnosis Saat Pulang:</strong><br>{{ $asuhan->diagnosa_akhir }}</div>
            </div>

            <h5 class="mt-4">TINDAKAN YANG DIBERIKAN DI RS</h5>
            @foreach($asuhan->tindakan as $i => $tdk)
                <p>Tindakan {{ $i+1 }}: {{ $tdk->tindakan }}</p>
            @endforeach

            <h5 class="mt-4">PENGOBATAN YANG DITERIMA</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Nama Generik</th>
                            <th>Dosis</th>
                            <th>Cara Pakai</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asuhan->obat as $key => $obat)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->dosis }}</td>
                            <td>{{ $obat->cara_pakai }}</td>
                            <td>
                                Frekuensi: {{ $obat->frekuensi ?? '-' }}, 
                                Fungsi: {{ $obat->fungsi_obat ?? '-' }},
                                Dosis Terakhir: {{ $obat->dosis_terakhir ?? '-' }},
                                Keterangan: {{ $obat->keterangan ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h5 class="mt-4">PEMANTAUAN YANG DIPERLUKAN</h5>
            <p><strong>Total waktu tidur:</strong> {{ $asuhan->total_waktu_tidur }} jam | 
            <strong>Kualitas tidur:</strong> {{ $asuhan->kualitas_tidur }}</p>

            <p><strong>Waktu luang:</strong> {{ $asuhan->waktu_luang }}<br>
<strong>Aktivitas di waktu luang:</strong>
@if(is_array($asuhan->aktifitas_luang))
    {{ implode(', ', $asuhan->aktifitas_luang) }}
@elseif(is_string($asuhan->aktifitas_luang))
    {{ $asuhan->aktifitas_luang }}
@else
    -
@endif
<br>
            <strong>Catatan khusus:</strong> {{ $asuhan->catatan_khusus }}</p>

            <p><strong>Makan:</strong> {{ $asuhan->kalori_makan }}x<br>
            <strong>Minum:</strong> {{ $asuhan->nutrisi_minum }}</p>

            <p><strong>Duduk:</strong> {{ $asuhan->duduk }} |
            <strong>Berdiri:</strong> {{ $asuhan->berdiri }} |
            <strong>Bergerak:</strong> {{ $asuhan->bergerak }}</p>

            <p><strong>BAK:</strong> {{ $asuhan->bak }} |
            <strong>BAB:</strong> {{ $asuhan->bab }}</p>

            <p><strong>Kondisi Umum:</strong> {{ $asuhan->kesehatan_umum }} |
            <strong>Tensi:</strong> {{ $asuhan->tensi }} |
            <strong>RR:</strong> {{ $asuhan->rr }} |
            <strong>SPO2:</strong> {{ $asuhan->spo2 }} |
            <strong>Temp:</strong> {{ $asuhan->temp }}</p>

            <p><strong>Catatan Tambahan:</strong> {{ $asuhan->catatan_tambahan }}</p>

            <p class="text-muted mt-4">Laporan dibuat pada: {{ $asuhan->created_at->format('d/m/Y') }}</p>
        </div>
    </div>
</div>
</body>
</html>