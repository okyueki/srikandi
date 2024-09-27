@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
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

                        <form action="{{ route('ijin.update', $pengajuanLibur->id_pengajuan_libur) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="jumlah_hari" id="jumlah_hari" class="form-control" value="{{ old('jumlah_hari', $pengajuanLibur->jumlah_hari) }}">

                            <div class="form-group mb-3">
                                <label for="tanggal_awal">Tanggal: </label>
                                <div class="row">
                                    <div class="col-5 mb-3">
                                        <div class="input-group">
                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" value="{{ old('tanggal_awal', $pengajuanLibur->tanggal_awal) }}">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <div class="input-group">
                                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" value="{{ old('tanggal_akhir', $pengajuanLibur->tanggal_akhir) }}">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-3">
                                        <span id="jumlah_hari_badge" style="font-size: 24px;" class="badge bg-success"></span>
                                    <div>
                                </div>
                            </div>

                                <div class="form-group mb-3">
                                    <label for="keterangan">Keterangan:</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan', $pengajuanLibur->keterangan) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="foto">Upload Foto Bukti:</label>
                                    <input type="file" name="file" id="myDropify" 
                                    data-default-file="{{ $pengajuanLibur->foto ? asset('storage/' . $pengajuanLibur->foto) : '' }}"/>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nik_atasan_langsung">Atasan Langsung:</label>
                                    <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
                                        <option value="">-- Select Pegawai --</option>
                                        @foreach ($pegawai as $p)
                                            <option value="{{ $p->nik }}" {{ $p->nik == old('nik_atasan_langsung', $pengajuanLibur->nik_atasan_langsung) ? 'selected' : '' }}>
                                                {{ $p->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- End Page-content -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
            $('#myDropify').dropify({
        messages: {
            'default': 'Pilih file',
            'replace': 'Ganti',
            'remove': 'Hapus',
            'error': 'Oops, something wrong appended.'
        },
        error: {
            'fileSize': 'Ukuran file terlalu besar (maks: 2MB).',
            'fileExtension': 'Jenis file tidak diizinkan (hanya jpeg, jpg, png, pdf).'
        }
    });
});
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