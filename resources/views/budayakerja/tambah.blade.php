@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Tambah Penilaian Harian')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Penilaian Harian</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('budayakerja.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Tanggal -->
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                                </div>
                                
                                <!-- Jam -->
                                <div class="col-md-6 mb-3">
                                    <label for="jam" class="form-label">Jam</label>
                                    <input type="time" id="jam" name="jam" class="form-control" value="{{ date('H:i') }}" readonly>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" id="petugas" name="nik_atasan" value="{{ $petugas }}" class="form-control" disabled>
                                    <label for="petugas">Petugas</label>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="nik_pegawai">Pilih NIK Pegawai</label>
                                    <select name="nik_pegawai" id="nik_pegawai" class="form-control" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach ($pegawai as $p)
                                            <option value="{{ $p->nik }}">{{ $p->nik }} - {{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" value="" readonly>
                                    <label for="nama_pegawai">Nama Pegawai</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="departemen" id="departemen" class="form-control" value="" readonly>
                                    <label for="departemen">Departemen</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="" readonly>
                                    <label for="jabatan">Jabatan</label>
                                </div>

                                <!-- Shift -->
                                <div class="col-md-6 mb-3">
                                    <label for="shift" class="form-label">Shift</label>
                                    <div>
                                        <input type="radio" id="shift_pagi" name="shift" value="pagi" required>
                                        <label for="shift_pagi">Pagi</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="shift_sore" name="shift" value="sore" required>
                                        <label for="shift_sore">Sore</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="shift_sore" name="shift" value="malam" required>
                                        <label for="shift_sore">Malam</label>
                                    </div>
                                </div>

                                <!-- Item Penilaian -->
                                <div class="col-12 mb-3">
                                    <label class="form-label">Item Penilaian</label>
                                    <div class="row">
                                        @foreach(['sepatu', 'sabuk', 'make_up', 'minyak_wangi', 'jilbab', 'kuku', 'baju', 'celana', 'name_tag', 'perhiasan', 'kaos_kaki'] as $item)
                                            <div class="col-md-4">
                                                <input type="hidden" name="{{ $item }}" value="0"> <!-- Hidden input for unchecked state -->
                                                <label class="form-check">
                                                    <input type="checkbox" name="{{ $item }}" value="1" class="form-check-input" checked>
                                                    <span class="form-check-label">{{ ucfirst(str_replace('_', ' ', $item)) }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Total Nilai -->
                                <div class="col-md-12 mb-3">
                                    <label for="total_nilai" class="form-label">Total Nilai</label>
                                    <input type="text" id="total_nilai" name="total_nilai" class="form-control" disabled>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nikPegawaiDropdown = document.getElementById("nik_pegawai");
        const namaPegawaiInput = document.getElementById("nama_pegawai");
        const departemenInput = document.getElementById("departemen");
        const jabatanInput = document.getElementById("jabatan");
        const totalNilaiInput = document.getElementById("total_nilai");
        
        // Inisialisasi Choices.js
            const choices = new Choices(nikPegawaiDropdown, {
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                shouldSort: false
            });

        
        // Fungsi untuk menghitung total nilai
        function calculateTotalNilai() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            let total = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += 1; // Tambah 1 untuk setiap checkbox yang tercentang
                }
            });
            totalNilaiInput.value = total; // Set nilai total ke input
        }

        // Event listener untuk checkbox
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotalNilai);
        });

        nikPegawaiDropdown.addEventListener("change", function () {
            const nik = this.value;

            if (nik) {
                fetch(`/api/pegawai/${nik}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Data pegawai tidak ditemukan");
                        }
                        return response.json();
                    })
                    .then(data => {
                        namaPegawaiInput.value = data.nama;
                        departemenInput.value = data.departemen;
                        jabatanInput.value = data.jabatan;
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        namaPegawaiInput.value = "";
                        departemenInput.value = "";
                        jabatanInput.value = "";
                        alert("Data pegawai tidak ditemukan!");
                    });
            } else {
                namaPegawaiInput.value = "";
                departemenInput.value = "";
                jabatanInput.value = "";
            }
        });

        // Hitung total nilai saat halaman dimuat
        calculateTotalNilai();
    });
</script>


@endsection