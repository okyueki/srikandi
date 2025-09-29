@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Create Adime Gizi')

@section('content')
<style>
    :root {
        --primary: #2c7be5;
        --secondary: #6e84a3;
        --success: #00d97e;
        --light: #f9fbfd;
        --border: #e3ebf6;
    }
    
    .adime-card {
        border-radius: 12px;
        box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        border: 1px solid var(--border);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .adime-card-header {
        background-color: white;
        border-bottom: 1px solid var(--border);
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .adime-card-title {
        font-weight: 600;
        color: var(--primary);
        margin: 0;
        font-size: 1.5rem;
    }
    
    .adime-card-body {
        padding: 1.5rem;
    }
    
    .adime-card-footer {
        background-color: white;
        border-top: 1px solid var(--border);
        padding: 1rem 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #344050;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .form-label.required:after {
        content: " *";
        color: #e63757;
    }
    
    .section-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--primary);
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .section-title:after {
        content: "";
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 60px;
        height: 2px;
        background-color: var(--primary);
    }
    
    .patient-info-card {
        background-color: #f0f7ff;
        border-radius: 10px;
        padding: 1.25rem;
        border-left: 4px solid var(--primary);
        margin-bottom: 1.5rem;
    }
    
    .patient-info-label {
        font-weight: 500;
        color: var(--secondary);
        min-width: 120px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        background-color: #1a68d1;
        border-color: #1a68d1;
        transform: translateY(-1px);
    }
    
    .btn-outline-secondary {
        border-color: var(--secondary);
        color: var(--secondary);
    }
    
    .btn-outline-secondary:hover {
        background-color: var(--secondary);
        border-color: var(--secondary);
        color: white;
    }
    
    .form-control, .form-select {
        border: 1px solid #d8e2ef;
        border-radius: 6px;
        padding: 0.625rem 1rem;
        font-size: 0.9375rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
    }
    
    textarea.form-control {
        min-height: 100px;
    }
    
    .info-badge {
        background-color: #e1f0ff;
        color: var(--primary);
        border-radius: 50px;
        padding: 0.25rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .form-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
    }
    
    .form-icon {
        margin-right: 8px;
        color: var(--primary);
    }
    
    .alert {
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    .is-invalid {
        border-color: #e63757 !important;
    }
    
    .invalid-feedback {
        display: block;
        color: #e63757;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .adime-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-actions {
            margin-top: 1rem;
            width: 100%;
        }
    }
</style>

<div class="container-xl">
    <div class="adime-card">
        <div class="adime-card-header">
            <h3 class="adime-card-title">
                <i class="fas fa-notes-medical me-2"></i>Buat Adime Gizi Baru
            </h3>
            <div class="card-actions">
                <a href="{{ url('adimegizi/' . preg_replace('/[^0-9]/', '', $regPeriksa->no_rawat)) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('adimegizi.store') }}" method="POST" id="adimeForm">
            @csrf
            <!-- Hidden field untuk no_rawat -->
            <input type="hidden" name="no_rawat" value="{{ $regPeriksa->no_rawat }}">
            
            <div class="adime-card-body">
                <div class="info-badge">
                    <i class="fas fa-info-circle me-2"></i>
                    Silakan lengkapi form berikut untuk membuat Adime Gizi baru
                </div>
                
                <!-- Informasi Pasien -->
                <div class="patient-info-card">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <span class="patient-info-label">No. Rawat</span>
                                <span class="fw-medium">{{ $regPeriksa->no_rawat }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <span class="patient-info-label">No. RM</span>
                                <span class="fw-medium">{{ $regPeriksa->pasien->no_rkm_medis ?? '' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <span class="patient-info-label">Nama Pasien</span>
                                <span class="fw-medium">{{ $regPeriksa->pasien->nm_pasien ?? '' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <span class="patient-info-label">Umur</span>
                                <span class="fw-medium">{{ $regPeriksa->pasien->umur ?? '' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <span class="patient-info-label">Jenis Kelamin</span>
                                <span class="fw-medium">{{ $regPeriksa->pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <span class="patient-info-label">Alamat</span>
                                <span class="fw-medium">{{ $regPeriksa->pasien->alamat ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tanggal dan Petugas -->
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">
                                <i class="fas fa-calendar form-icon"></i>Tanggal
                            </label>
                            <input type="text" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $hariIni) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">
                                <i class="fas fa-user-nurse form-icon"></i>Petugas
                            </label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            <input type="hidden" name="nip" value="{{ Auth::user()->email }}">
                        </div>
                    </div>
                </div>
                
                <!-- Asesmen Gizi -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-clipboard-list me-2"></i>Asesmen Gizi
                    </h5>
                    <div class="mb-3">
                        <label class="form-label required">
                            <i class="fas fa-stethoscope form-icon"></i>Asesmen
                        </label>
                        <textarea class="form-control @error('asesmen') is-invalid @enderror" name="asesmen" rows="4" placeholder="Masukkan hasil asesmen gizi pasien (status gizi, kebiasaan makan, aktivitas fisik, dll)" required>{{ old('asesmen') }}</textarea>
                        @error('asesmen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-1">
                            Contoh: Pasien dengan BB 65kg, TB 170cm (IMT 22.5). Asupan makanan kurang dari kebutuhan, aktivitas fisik rendah.
                        </div>
                    </div>
                </div>
                
                <!-- Diagnosis Gizi -->
                <div class="form-section">
                    <h5 class="section-title">
                        <i class="fas fa-diagnoses me-2"></i>Diagnosis Gizi
                    </h5>
                    <div class="mb-3">
                        <label class="form-label required">
                            <i class="fas fa-file-medical form-icon"></i>Diagnosis
                        </label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" rows="4" placeholder="Masukkan diagnosis gizi berdasarkan hasil asesmen" required>{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-1">
                            Contoh: Ketidakseimbangan asupan nutrisi terkait asupan energi dan protein yang tidak adekuat.
                        </div>
                    </div>
                </div>
                
                <!-- Intervensi & Monitoring -->
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="section-title">
                                <i class="fas fa-tasks me-2"></i>Intervensi Gizi
                            </h6>
                            <label class="form-label required">
                                <i class="fas fa-procedures form-icon"></i>Intervensi
                            </label>
                            <textarea class="form-control @error('intervensi') is-invalid @enderror" name="intervensi" rows="4" placeholder="Masukkan rencana intervensi gizi" required>{{ old('intervensi') }}</textarea>
                            @error('intervensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-1">
                                Contoh: Pemberian diet tinggi kalori tinggi protein (TKTP) 2000 kkal, 80g protein.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="section-title">
                                <i class="fas fa-chart-line me-2"></i>Monitoring
                            </h6>
                            <label class="form-label required">
                                <i class="fas fa-clipboard-check form-icon"></i>Monitoring
                            </label>
                            <textarea class="form-control @error('monitoring') is-invalid @enderror" name="monitoring" rows="4" placeholder="Masukkan rencana monitoring gizi" required>{{ old('monitoring') }}</textarea>
                            @error('monitoring')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-1">
                                Contoh: Pemantauan berat badan 2x/minggu, asupan makanan harian, dan toleransi diet.
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Evaluasi & Instruksi -->
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="section-title">
                                <i class="fas fa-chart-bar me-2"></i>Evaluasi
                            </h6>
                            <label class="form-label required">
                                <i class="fas fa-file-medical-alt form-icon"></i>Evaluasi
                            </label>
                            <textarea class="form-control @error('evaluasi') is-invalid @enderror" name="evaluasi" rows="4" placeholder="Masukkan evaluasi hasil intervensi gizi" required>{{ old('evaluasi') }}</textarea>
                            @error('evaluasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-1">
                                Contoh: Terjadi peningkatan berat badan 0.5kg dalam 1 minggu, asupan mencapai 80% target.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="section-title">
                                <i class="fas fa-file-prescription me-2"></i>Instruksi
                            </h6>
                            <label class="form-label required">
                                <i class="fas fa-notes-medical form-icon"></i>Instruksi
                            </label>
                            <textarea class="form-control @error('instruksi') is-invalid @enderror" name="instruksi" rows="4" placeholder="Masukkan instruksi gizi untuk pasien" required>{{ old('instruksi') }}</textarea>
                            @error('instruksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-1">
                                Contoh: Tingkatkan asupan protein dengan konsumsi telur, daging, dan susu. Kontrol minggu depan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="adime-card-footer text-end">
                <button type="reset" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('debug-form.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Flatpickr dengan konfigurasi yang diperbaiki
        flatpickr("#tanggal", {
            enableTime: true,
            dateFormat: "Y-m-d H:i:s",
            time_24hr: true,
            defaultDate: "{{ $hariIni }}",
            locale: "id",
            // Hapus minDate untuk menghindari masalah tanggal
            altInput: true,
            altFormat: "j F Y, H:i",
        });
        
        // Form validation
        const form = document.getElementById('adimeForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            // Reset error states
            requiredFields.forEach(field => {
                field.classList.remove('is-invalid');
                const feedback = field.parentNode.querySelector('.invalid-feedback');
                if (feedback && !feedback.dataset.serverError) {
                    feedback.style.display = 'none';
                }
            });
            
            // Check required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                    
                    // Show custom error message
                    let feedback = field.parentNode.querySelector('.invalid-feedback');
                    if (!feedback) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        field.parentNode.appendChild(feedback);
                    }
                    feedback.textContent = 'Field ini wajib diisi';
                    feedback.style.display = 'block';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi');
                return false;
            }
            
            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        });
        
        // Real-time validation
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
</script>
@endsection