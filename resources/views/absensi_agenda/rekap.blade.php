@extends('layouts.pages-layouts')

@section('pageTitle', 'Rekap Absensi Agenda')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card custom-card">
            <div class="card-body">
                <h4 class="card-title">Rekap Absensi Agenda</h4>

                <!-- Tempat tampil rekap -->
                <div id="rekapContainer" class="mb-3"></div>

                <!-- Filter by Agenda -->
                <form id="filterForm" class="mb-3">
                    <div class="form-group">
                        <label for="agenda_id">Pilih Agenda</label>
                        <select class="form-control" id="agenda_id" name="agenda_id">
                            <option value="">Semua Agenda</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <!-- DataTables -->
                <div class="table-responsive">
                    <table id="rekapTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Jabatan</th>
                                <th>Departemen</th>
                                <th>Agenda</th>
                                <th>Waktu Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var table = $('#rekapTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/rekap-absensi',
            data: function (d) {
                d.agenda_id = $('#agenda_id').val();
            }
        },
        columns: [
            { data: 'no', name: 'no', orderable: false, searchable: false },
            { data: 'pegawai', name: 'pegawai' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'departemen', name: 'departemen' },
            { data: 'agenda', name: 'agenda' },
            { data: 'waktu_kehadiran', name: 'waktu_kehadiran' }
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }
        ]
    });

    // Update rekap setiap kali data di-load ulang
    table.on('xhr.dt', function (e, settings, json, xhr) {
        if (json && json.rekap) {
            let r = json.rekap;
            $('#rekapContainer').html(`
            <div class="row g-3">
                <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-warning-gradient">
                        <div class="px-3 pt-3 pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">Jumlah Undangan</h6>
                            </div>
                            <div>
                                <h4 class="fs-20 fw-bold mb-1 text-fixed-white">${r.jumlah_undangan ?? 0} orang</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-primary-gradient">
                        <div class="px-3 pt-3 pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">Jumlah Hadir</h6>
                            </div>
                            <div>
                                <h4 class="fs-20 fw-bold mb-1 text-fixed-white">${r.jumlah_hadir ?? 0} orang</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-danger-gradient">
                        <div class="px-3 pt-3 pb-2 pt-0">
                            <div>
                                <h6 class="mb-3 fs-12 text-fixed-white">Jumlah Tidak Hadir</h6>
                            </div>
                            <div>
                                <h4 class="fs-20 fw-bold mb-1 text-fixed-white">${r.jumlah_tidak_hadir ?? 0} orang</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `);
        } else {
            $('#rekapContainer').html('');
        }
    });

    // Reload DataTable saat ganti agenda
    $('#agenda_id').change(function () {
        table.ajax.reload();
    });
});
</script>
@endsection
