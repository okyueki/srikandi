@extends('layouts.pages-layouts')

@section('pageTitle', 'Tambah Agenda Baru')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <h1>Absensi Event</h1>
            
                <form action="{{ route('absensi_event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
            
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <select name="nik" id="nik" class="form-control">
                            <option value="">-- Pilih NIK --</option>
                            @foreach ($pegawai as $pegawai)
                                <option value="{{ $pegawai->nik }}">{{ $pegawai->nik }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" class="form-control" readonly>
                    </div>
            
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <input type="text" id="departemen" class="form-control" readonly>
                    </div>
            
                    <div class="form-group">
                        <label for="agenda_id">Nama Event</label>
                        <select name="agenda_id" id="agenda_id" class="form-control">
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->judul }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="text" id="tanggal" class="form-control" readonly>
                    </div>
            
                    <div class="form-group">
                        <label for="jam_checkin">Jam Check-in</label>
                        <input type="text" id="jam_checkin" class="form-control" readonly>
                    </div>
            
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" id="keterangan" class="form-control" readonly>
                    </div>

            
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
            
                    <!-- Tambahkan div untuk menampilkan peta -->
                    <div id="map" style="height: 300px;"></div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>    
</div>

<script>
// JavaScript untuk mengisi otomatis nama dan departemen ketika NIK dipilih
document.getElementById('nik').addEventListener('change', function() {
    var nik = this.value;

    if (nik) {
        fetch(`/api/pegawai/${nik}`)  // Mengakses API untuk mendapatkan data pegawai
            .then(response => response.json())  // Mengonversi response ke JSON
            .then(data => {
                if (data) {
                    document.getElementById('nama').value = data.nama;  // Isi nama
                    document.getElementById('departemen').value = data.departemen;  // Isi departemen
                }
            })
            .catch(error => {
                console.error('Error fetching pegawai data:', error);
            });
    } else {
        // Jika NIK kosong, kosongkan input nama dan departemen
        document.getElementById('nama').value = '';
        document.getElementById('departemen').value = '';
    }
});
// JavaScript untuk mengisi otomatis tanggal ketika Nama Event dipilih
document.getElementById('agenda_id').addEventListener('change', function() {
    var agendaId = this.value;

    if (agendaId) {
        fetch(`/api/agenda/${agendaId}`)  // Memanggil API untuk mendapatkan tanggal mulai
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('tanggal').value = data.mulai;  // Isi tanggal mulai
                }
            })
            .catch(error => {
                console.error('Error fetching agenda data:', error);
            });
    } else {
        // Jika agenda_id kosong, kosongkan input tanggal
        document.getElementById('tanggal').value = '';
    }
});

function updateJamCheckin() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');

    var jamCheckin = hours + ':' + minutes + ':' + seconds;
    
    document.getElementById('jam_checkin').value = jamCheckin;
}

// Panggil fungsi updateJamCheckin setiap detik
setInterval(updateJamCheckin, 1000);

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

// Fungsi untuk mengisi latitude dan longitude secara otomatis
function showPosition(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    // Cek apakah nilai latitude dan longitude sudah benar
    console.log('Latitude:', latitude, 'Longitude:', longitude);  // Log untuk cek

    // Isi form latitude dan longitude
    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;

    // Tampilkan peta menggunakan Leaflet
    var map = L.map('map').setView([latitude, longitude], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);
    
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup("You are here!")
        .openPopup();
}

// Fungsi untuk menangani error jika geolocation gagal
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
// Titik koordinat yang dikunci (lokasi tetap)
const fixedLatitude = -7.485606542801486;
const fixedLongitude = 112.65265125312277;

// Fungsi untuk menghitung jarak menggunakan rumus Haversine
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3; // Radius bumi dalam meter
    const φ1 = lat1 * Math.PI / 180; // φ, λ in radians
    const φ2 = lat2 * Math.PI / 180;
    const Δφ = (lat2 - lat1) * Math.PI / 180;
    const Δλ = (lon2 - lon1) * Math.PI / 180;

    const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
              Math.cos(φ1) * Math.cos(φ2) *
              Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    return R * c; // Distance in meters
}

function showPosition(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    // Cek apakah nilai latitude dan longitude sudah benar
    console.log('Latitude:', latitude, 'Longitude:', longitude);

    // Isi form latitude dan longitude
    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;

    // Tampilkan peta menggunakan Leaflet
    var map = L.map('map').setView([latitude, longitude], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);
    
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup("You are here!")
        .openPopup();

    // Hitung jarak dari titik tetap
    const distance = calculateDistance(fixedLatitude, fixedLongitude, latitude, longitude);
    console.log('Distance:', distance, 'meters');

    // Tetapkan jarak maksimum, misalnya 50 meter
    const maxDistance = 50;

    // Tentukan keterangan berdasarkan jarak
    if (distance <= maxDistance) {
        document.getElementById('keterangan').value = 'Di dalam lokasi';
        console.log('Keterangan: Di dalam lokasi');
    } else {
        document.getElementById('keterangan').value = `Di luar lokasi (${(distance / 1000).toFixed(2)} km)`;
        console.log('Keterangan: Di luar lokasi');
    }
}

// Panggil fungsi getLocation saat halaman selesai dimuat
window.onload = getLocation;

</script>

@endsection


