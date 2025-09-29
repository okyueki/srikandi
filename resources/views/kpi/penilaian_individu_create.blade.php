@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title : $title)

@section('content')
<div class="row">
    <!-- Card Data Pegawai -->
    
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title">Data Pegawai</h3>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('penilaian_individu.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-floating mb-3">
                                <input type="text" id="nik_atasan" name="nik_atasan" value="{{ $nikAtasan }}" class="form-control" disabled>
                                <label for="nik_atasan">NIK Penilai</label>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input type="text" id="nama_atasan" name="nama_atasan" value="{{ $namaAtasan }}" class="form-control" disabled>
                                <label for="nama_atasan">Nama Penilai</label>
                            </div>
                            
                            <div class="form-group">
                                <label for="bulan">Pilih Bulan:</label>
                                <input type="month" id="penilaian_bulan" name="penilaian_bulan" class="form-control" value="{{ old('penilaian_bulan', $bulan ?? now()->format('Y-m')) }}">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="nik_bawahan">Pilih Pegawai</label>
                                <select name="nik_bawahan" id="nik_bawahan" class="form-control" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->nik }}">{{ $p->nik }} - {{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="nama_bawahan" id="nama_bawahan" class="form-control" value="" disabled>
                                <label for="nama_bawahan">Nama pegawai</label>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input type="text" name="departemen" id="departemen" class="form-control" value="" disabled>
                                <label for="departemen">Kode Departemen</label>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Card Form Penilaian -->
    <div class="col-xl-12 mt-4">
        <div class="card custom-card">
            <div class="card-header">
                <h3 class="card-title">Form Penilaian</h3>
            </div>
            <div class="card-body">
                <!-- Form Penilaian - 1 Kolom -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Kepatuhan -->
                        <div class="mb-3">
                            <label for="kepatuhan">Kepatuhan : Kehadiran Sesuai Jadwal dan Tepat Waktu</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select id="kepatuhan" name="kepatuhan" class="form-select nilai">
                                        <option value="0">Hadir sesuai jadwal dan terdapat  5 kali keterlambatan dalam 1 bulan</option>
                                        <option value="1">Hadir sesuai jadwal dan terdapat  4 kali keterlambatan dalam 1 bulan</option>
                                        <option value="2">Hadir sesuai jadwal dan terdapat  3 kali keterlambatan dalam 1 bulan</option>
                                        <option value="3">Hadir sesuai jadwal dan terdapat  2 kali keterlambatan dalam 1 bulan</option>
                                        <option value="4">Hadir sesuai jadwal dan terdapat  1 kali keterlambatan dalam 1 bulan </option>
                                        <option value="5">Hadir sesuai jadwal dan tidak pernah terlambat dalam 1 bulan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="persentase_kepatuhan" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Keaktifan -->
                        <div class="mb-4 floating-primary">
                            <label for="keaktifan">Keaktifan : Selalu Ceklok</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select id="keaktifan" name="keaktifan" class="form-select nilai">
                                        <option value="0">Hadir sesuai jadwal dan terdapat 5 kali tidak ceklock dalam 1 bulan</option>
                                        <option value="1">Hadir sesuai jadwal dan terdapat 4 kali tidak ceklock dalam 1 bulan</option>
                                        <option value="2">Hadir sesuai jadwal dan terdapat 3 kali tidak ceklock dalam 1 bulan</option>
                                        <option value="3">Hadir sesuai jadwal dan terdapat 2 kali tidak ceklock dalam 1 bulan</option>
                                        <option value="4">Hadir sesuai jadwal dan terdapat 1 kali tidak ceklock dalam 1 bulan</option>
                                        <option value="5">Hadir sesuai jadwal dan selalu ceklock dalam 1 bulan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="persentase_keaktifan" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Budaya Kerja -->
                        <div class="mb-3">
                            <label for="budaya_kerja">Budaya Kerja - Kelengkapan Atribut Kerja</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select id="budaya_kerja" name="budaya_kerja" class="form-select nilai">
                                        <option value="0">Pernah melakukan pelanggaran 5 kali dari hasil monitoring budaya kerja dalam 1 bulan</option>
                                        <option value="1">Pernah melakukan pelanggaran 4 kali dari hasil monitoring budaya kerja dalam 1 bulan</option>
                                        <option value="2">Pernah melakukan pelanggaran 3 kali dari hasil monitoring budaya kerja dalam 1 bulan</option>
                                        <option value="3">Pernah melakukan pelanggaran 2 kali dari hasil monitoring budaya kerja dalam 1 bulan</option>
                                        <option value="4">Pernah melakukan pelanggaran 1 kali dari hasil monitoring budaya kerja dalam 1 bulan</option>
                                        <option value="5">Tidak pernah melakukan pelanggaran dari hasil monitoring budaya kerja dalam 1 bulan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="persentase_budaya_kerja" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Kajian -->
                        <div class="mb-3">
                            <label for="kajian">Kajian (kehadiran di Kegiatan Kajian)</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select id="kajian" name="kajian" class="form-select nilai">
                                        <option value="0">Pernah 3 kali tidak hadir di kegiatan kajian tanpa ijin dalam 1 bulan</option>
                                        <option value="1">Pernah 2 kali tidak hadir di kegiatan kajian tanpa ijin dalam 1 bulan</option>
                                        <option value="2">Pernah 1 kali tidak hadir di kegiatan kajian tanpa ijin dalam 1 bulan</option>
                                        <option value="3">Pernah Ijin tidak hadir 2 kali di kegiatan kajian dalam 1 bulan</option>
                                        <option value="4">Pernah Ijin tidak hadir 1 kali di kegiatan kajian dalam 1 bulan</option>
                                        <option value="5">Selalu aktif/ hadir  di kegiatan kajian dalam 1 bulan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="persentase_kajian" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Kegiatan RS -->
                        <div class="mb-3">
                            <label for="kegiatan_rs">Kegiatan RS (Undangan Rapat / Kegiatan yang diselengarakan Rumah Sakit)</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select id="kegiatan_rs" name="kegiatan_rs" class="form-select nilai">
                                        <option value="0">Pernah 3 kali tidak hadir di rapat/ kegitan yang diselenggarakan RS tanpa ijin dalam 1 bulan</option>
                                        <option value="1">Pernah 2 kali tidak hadir di rapat/ kegitan yang diselenggarakan RS tanpa ijin dalam 1 bulan</option>
                                        <option value="2">Pernah 1 kali tidak hadir di rapat/ kegitan yang diselenggarakan RS tanpa ijin dalam 1 bulan</option>
                                        <option value="3">Pernah Ijin tidak hadir 2 kali di rapat/ kegitan yang diselenggarakan RS dalam 1 bulan</option>
                                        <option value="4">Pernah Ijin tidak hadir 1 kali di rapat/ kegitan yang diselenggarakan RS dalam 1 bulan</option>
                                        <option value="5">Selalu aktif/ hadir  di rapat/ kegitan yang diselenggarakan RS dalam 1 bulan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="persentase_kegiatan_rs" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- IHT -->
                        <div class="mb-3">
                            <label for="iht">IHT / EHT (Hadir di semua undangan Resmi RS) </label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select id="iht" name="iht" class="form-select nilai">
                                        <option value="0">Pernah 3 kali tidak hadir di kegiatan IHT/ EHT tanpa ijin dalam 1 bulan</option>
                                        <option value="1">Pernah 2 kali tidak hadir di kegiatan IHT/ EHT tanpa ijin dalam 1 bulan</option>
                                        <option value="2">Pernah 1 kali tidak hadir di kegiatan IHT/ EHT tanpa ijin dalam 1 bulan</option>
                                        <option value="3">Pernah Ijin tidak hadir 2 kali di kegiatan IHT/ EHT dalam 1 bulan</option>
                                        <option value="4">Pernah Ijin tidak hadir 1 kali di kegiatan IHT/ EHT dalam 1 bulan</option>
                                        <option value="5">Selalu aktif/ hadir  di kegiatan IHT/ EHT dalam 1 bulan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="persentase_iht" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Total Nilai -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Total Nilai</label>
                                    <input type="text" id="total_nilai" class="form-control" value="0" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Total Persentase</label>
                                    <input type="text" id="total_persentase" class="form-control" value="0%" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const nikBawahanDropdown = document.getElementById("nik_bawahan");
    const namaBawahanInput = document.getElementById("nama_bawahan");
    const departemenInput = document.getElementById("departemen");

    // Inisialisasi Choices.js
    const choices = new Choices(nikBawahanDropdown, {
        placeholderValue: 'Search Pegawai...',
        searchEnabled: true,
        shouldSort: false
    });

    // Event Listener untuk pilihan NIK Bawahan
    nikBawahanDropdown.addEventListener("change", function () {
        const nik = this.value;

        // Jika ada NIK yang dipilih, lakukan AJAX request
        if (nik) {
            fetch(`/api/pegawai/${nik}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Data pegawai tidak ditemukan");
                    }
                    return response.json();
                })
                .then(data => {
                    // Isi otomatis input Nama Bawahan dan Departemen
                    namaBawahanInput.value = data.nama;
                    departemenInput.value = data.departemen;
                })
                .catch(error => {
                    console.error("Error:", error);
                    namaBawahanInput.value = "";
                    departemenInput.value = "";
                    alert("Data pegawai tidak ditemukan!");
                });
        } else {
            // Reset kolom jika tidak ada NIK yang dipilih
            namaBawahanInput.value = "";
            departemenInput.value = "";
        }
    });
});



    document.addEventListener("DOMContentLoaded", function() {
    const bobot = {
        kepatuhan: 0.25,
        keaktifan: 0.2,
        budaya_kerja: 0.25,
        kajian: 0.15,
        kegiatan_rs: 0.1,
        iht: 0.05
    };

    const inputs = document.querySelectorAll(".nilai");
    const totalNilaiField = document.getElementById("total_nilai");
    const totalPersentaseField = document.getElementById("total_persentase");

    inputs.forEach(input => {
        input.addEventListener("input", hitungSemua);
    });

    function hitungSemua() {
        let totalNilai = 0;
        let totalPersentase = 0;

        inputs.forEach(input => {
            const id = input.id;
            const value = parseFloat(input.value) || 0;

            // Hitung persentase per kolom
            const persentase = Math.floor((value * bobot[id] * 100) / 5);
            document.getElementById(`persentase_${id}`).value = `${persentase}%`;

            // Hitung total nilai dan total persentase
            totalNilai += value;
            totalPersentase += persentase;
        });

        totalNilaiField.value = totalNilai;
        totalPersentaseField.value = `${Math.floor(totalPersentase)}%`;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const nikBawahanDropdown = document.getElementById("nik_bawahan");
    const bulanInput = document.getElementById("penilaian_bulan");
    const persentaseKepatuhanInput = document.getElementById("persentase_kepatuhan");
    const kepatuhanSelect = document.getElementById("kepatuhan");

    function hitungKepatuhan() {
        const nik = nikBawahanDropdown.value;
        const bulan = bulanInput.value;

        if (!nik || !bulan) return;

        fetch('/penilaian/kepatuhan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ nik_bawahan: nik, bulan: bulan }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data kepatuhan');
            }
            return response.json();
        })
        .then(data => {
            kepatuhanSelect.value = data.nilai; // Isi nilai kepatuhan otomatis
            persentaseKepatuhanInput.value = `${data.persentase}%`; // Isi persentase otomatis
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghitung kepatuhan');
        });
    }

    // Event listener untuk trigger penghitungan
    nikBawahanDropdown.addEventListener("change", hitungKepatuhan);
    bulanInput.addEventListener("change", hitungKepatuhan);
});


</script>
@endsection
