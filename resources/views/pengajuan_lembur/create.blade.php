@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <!-- end page title -->
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

                    <form action="{{ route('pengajuan_lembur.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="jumlah_hari" id="jumlah_hari" class="form-control" value="{{ old('jumlah_hari') }}">
                            <div class="form-group mb-3">
                                <label for="tanggal_lembur">Tanggal: </label>
                                <div class="input-group">
                                    <input type="text" name="tanggal_lembur" id="tanggal_lembur" class="form-control tanggal_lembur" value="{{ old('tanggal_lembur') }}">
                                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="jam_lembur">Jam Lembur: </label>
                                <div class="row">
                                    <div class="col-5 mb-3">
                                        <div class="input-group">
                                            <input type="text" name="jam_awal" id="jam_awal" class="form-control flatpickr" value="{{ old('jam_awal') }}">
                                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <div class="input-group">
                                            <input type="text" name="jam_akhir" id="jam_akhir" class="form-control flatpickr" value="{{ old('jam_akhir') }}">
                                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-3">
                                        <span id="jumlah_jam_badge" style="font-size: 24px;" class="badge bg-success"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="keterangan">Keterangan:</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="nik_atasan_langsung">Atasan Langsung:</label>
                                <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->nik }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- End Page-content -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize flatpickr for both date fields
            flatpickr('.tanggal_lembur', {
                dateFormat: "Y-m-d",
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
    // Initialize flatpickr for both time fields
    flatpickr('.flatpickr', {
        enableTime: true,
        noCalendar: true, // Disable the calendar, only show time
        time_24hr: true,  // Enable 24-hour format
        dateFormat: "H:i", // Only display hours and minutes
        onChange: function(selectedDates, dateStr, instance) {
            calculateTime();
        }
    });

    function calculateTime() {
        // Get the values of the start and end times
        const startTime = document.getElementById('jam_awal').value;
        const endTime = document.getElementById('jam_akhir').value;

        // If both times are set, calculate the difference in hours and minutes
        if (startTime && endTime) {
            const start = new Date(`1970-01-01T${startTime}:00`);
            const end = new Date(`1970-01-01T${endTime}:00`);

            if (end >= start) {
                // Calculate the difference in time
                const timeDiff = end.getTime() - start.getTime();
                
                // Calculate hours and remaining minutes
                const hourDiff = Math.floor(timeDiff / (1000 * 3600)); // Full hours
                const minuteDiff = Math.floor((timeDiff % (1000 * 3600)) / (1000 * 60)); // Remaining minutes

                // Display the result in hours and minutes
                document.getElementById('jumlah_jam_badge').innerHTML = `${hourDiff} Jam ${minuteDiff} Menit`;
            } else {
                // Show SweetAlert if end time is before start time
                Swal.fire({
                    icon: 'error',
                    title: 'Jam Akhir Salah',
                    text: 'Jam Akhir harus lebih besar dari Jam Awal!',
                });
                // Clear the end time and jumlah_jam
                document.getElementById('jam_akhir').value = '';
                document.getElementById('jumlah_jam').innerHTML = '';
            }
        }
    }
});
        document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('nik_atasan_langsung');
            const choices = new Choices(element, {
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'top', // Menampilkan dropdown di bawah elemen
                shouldSort: false, // Menghindari pengurutan jika tidak diperlukan
            });

        });
</script>
@endsection