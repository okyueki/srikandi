@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Input Types
                </div>
            </div>
            <div class="card-body">
                <div class="row gy-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cuti.update', $cuti->id_pengajuan_libur) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="jumlah_hari" id="jumlah_hari" class="form-control" value="{{ old('jumlah_hari', $pengajuanLibur->jumlah_hari ?? '') }}">

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="jenis_pengajuan_libur">Jenis Cuti:</label>
                                <select name="jenis_pengajuan_libur" id="jenis_pengajuan_libur" class="form-control">
                                    <option value="">-- Select Jenis Cuti --</option>
                                    @foreach(['Tahunan', 'Melahirkan', 'Ambil Libur', 'Menikah'] as $jenis)
                                        <option value="{{ $jenis }}" {{ (old('jenis_pengajuan_libur', $cuti->jenis_pengajuan_libur ?? '') == $jenis) ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="tanggal_awal">Tanggal: </label>
                                <div class="row">
                                    <div class="col-5 mb-3">
                                        <div class="input-group">
                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" value="{{ old('tanggal_awal', $cuti->tanggal_awal ?? '') }}">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <div class="input-group">
                                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" value="{{ old('tanggal_akhir', $cuti->tanggal_akhir ?? '') }}">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-3">
                                        <span id="jumlah_hari_badge" style="font-size: 24px;" class="badge bg-success"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="keterangan">Keterangan:</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan', $cuti->keterangan ?? '') }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat:</label>
                                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $cuti->alamat ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label for="nik_atasan_langsung">Atasan Langsung:</label>
                                <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->nik }}" {{ $cuti->nik_atasan_langsung === $p->nik ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Page-content -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize flatpickr for both date fields
            flatpickr('.flatpickr', {
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    calculateDays();
                }
            });

            function calculateDays() {
                // Get the values of the start and end dates
                const startDate = document.getElementById('tanggal_awal').value;
                const endDate = document.getElementById('tanggal_akhir').value;

                // If both dates are set, calculate the difference in days
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    if (end >= start) {
                        // Calculate the difference in days
                        const timeDiff = end.getTime() - start.getTime();
                        const dayDiff = timeDiff / (1000 * 3600 * 24) + 1; // Add 1 to include the end day
                        document.getElementById('jumlah_hari').value = dayDiff;
                        document.getElementById('jumlah_hari_badge').innerHTML = dayDiff + " Hari";
                    } else {
                        // Show SweetAlert if end date is before start date
                        Swal.fire({
                            icon: 'error',
                            title: 'Tanggal Akhir Salah',
                            text: 'Tanggal Akhir harus lebih besar dari Tanggal Awal!',
                        });
                        // Clear the end date and jumlah_hari
                        document.getElementById('tanggal_akhir').value = '';
                        document.getElementById('jumlah_hari').value = '';
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

        document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('jenis_pengajuan_libur');
            const choices = new Choices(element, {
            placeholderValue: '-- Select Jenis Cuti --',
            searchEnabled: true, // set to true if you want a search feature
         });
});
</script>
@endsection