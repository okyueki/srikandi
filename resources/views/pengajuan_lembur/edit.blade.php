@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title)

@section('content')
<style>
.flatpickr-time {
    min-width: 130px !important;
    padding: 18px 10px !important;
    text-align: center;
        max-height: 75px !important;
}
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengajuan_lembur.update', $pengajuan_lembur->id_pengajuan_lembur) }}" method="POST">
                    @csrf
                    <!-- Input Tanggal Awal -->
                    <div class="form-group mb-3">
                        <label for="tanggal_awal">Tanggal Awal: </label>
                        <div class="input-group">
                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" value="{{ old('tanggal_awal', $pengajuan_lembur->tanggal_awal ?? '') }}">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>

                    <!-- Input Tanggal Akhir -->
                    <div class="form-group mb-3">
                        <label for="tanggal_akhir">Tanggal Akhir: </label>
                        <div class="input-group">
                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" value="{{ old('tanggal_akhir', $pengajuan_lembur->tanggal_akhir ?? '') }}">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>

                    <!-- Input Jam Lembur -->
                    <div class="form-group mb-3">
                        <label for="jam_lembur">Jam Lembur: </label>
                        <div class="row">
                            <div class="col-5 mb-3">
                                <div class="input-group">
                                    <input type="text" name="jam_awal" id="jam_awal" class="form-control flatpickr-time" value="{{ old('jam_awal', $pengajuan_lembur->jam_awal) }}">
                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                </div>
                            </div>
                            <div class="col-5 mb-3">
                                <div class="input-group">
                                    <input type="text" name="jam_akhir" id="jam_akhir" class="form-control flatpickr-time" value="{{ old('jam_akhir', $pengajuan_lembur->jam_akhir) }}">
                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                </div>
                            </div>
                            <div class="col-2 mb-3">
                                <span id="jumlah_jam_badge" style="font-size: 24px;" class="badge bg-success"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Input Keterangan -->
                    <div class="form-group mb-3">
                        <label for="keterangan">Keterangan:</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan', $pengajuan_lembur->keterangan) }}">
                    </div>

                    <!-- Pilihan Atasan Langsung -->
                    <div class="form-group mb-3">
                        <label for="nik_atasan_langsung">Atasan Langsung:</label>
                        <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                            <option value="">-- Select Pegawai --</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->nik }}" {{ $pengajuan_lembur->nik_atasan_langsung == $p->nik ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize flatpickr for tanggal_awal dan tanggal_akhir
    flatpickr('.flatpickr', {
        dateFormat: "Y-m-d",
        onChange: function () {
            calculateTime();
        }
    });

    // Initialize flatpickr for jam_awal dan jam_akhir (hanya waktu)
    flatpickr('.flatpickr-time', {
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        onChange: function () {
            calculateTime();
        }
    });

    function calculateTime() {
        const tanggalAwal = document.getElementById('tanggal_awal').value;
        const tanggalAkhir = document.getElementById('tanggal_akhir').value;
        const jamAwal = document.getElementById('jam_awal').value;
        const jamAkhir = document.getElementById('jam_akhir').value;

        if (tanggalAwal && tanggalAkhir && jamAwal && jamAkhir) {
            const start = new Date(`${tanggalAwal}T${jamAwal}:00`);
            const end = new Date(`${tanggalAkhir}T${jamAkhir}:00`);

            if (end >= start) {
                const timeDiff = end.getTime() - start.getTime();
                const hours = Math.floor(timeDiff / (1000 * 3600));
                const minutes = Math.floor((timeDiff % (1000 * 3600)) / (1000 * 60));

                document.getElementById('jumlah_jam_badge').innerHTML = `${hours} Jam ${minutes} Menit`;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Waktu Salah',
                    text: 'Tanggal Akhir & Jam Akhir harus lebih besar dari Tanggal Awal & Jam Awal!',
                });
                document.getElementById('jam_akhir').value = '';
                document.getElementById('jumlah_jam_badge').innerHTML = '';
            }
        }
    }

    // Choice.js untuk dropdown atasan langsung
    const pegawaiSelect = document.getElementById('nik_atasan_langsung');
    const choices = new Choices(pegawaiSelect, {
        searchEnabled: true,
        itemSelectText: '',
        placeholderValue: 'Select Pegawai',
    });
});
</script>

@endsection
