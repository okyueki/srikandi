@extends('layouts.pages-layouts')

@section('pageTitle', 'Riwayat Pemeriksaan')

@section('content')

<!-- Success/Error Notifications -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fe fe-check-circle mr-2"></i>{{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fe fe-alert-triangle mr-2"></i>{{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fe fe-alert-triangle mr-2"></i>
    <strong>Validasi Error:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<style>
    :root {
        --primary: #2c7be5;
        --secondary: #6e84a3;
        --success: #00d97e;
        --warning: #f6c343;
        --danger: #e63757;
        --ai-color: #6f42c1;
        --light: #f9fbfd;
        --border: #e3ebf6;
    }
    
    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #344050;
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
    
    .examination-card {
        background-color: #f0faff;
        border-radius: 10px;
        padding: 1.25rem;
        border-left: 4px solid var(--success);
        margin-bottom: 1.5rem;
    }
    
    .soap-card {
        background-color: #fff9ed;
        border-radius: 10px;
        padding: 1.25rem;
        border-left: 4px solid var(--warning);
        margin-bottom: 1.5rem;
    }
    
    .history-card {
        background-color: #fff5f8;
        border-radius: 10px;
        padding: 1.25rem;
        border-left: 4px solid var(--danger);
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
    
    .btn-ai {
        background-color: var(--ai-color);
        border-color: var(--ai-color);
        color: white;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-ai:hover {
        background-color: #5a32a3;
        border-color: #5a32a3;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(111, 66, 193, 0.2);
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
        min-height: 120px;
        font-size: 0.9375rem;
        line-height: 1.6;
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
    
    .ai-badge {
        background-color: #f0e6ff;
        color: var(--ai-color);
    }
    
    .form-section {
        background-color: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
        position: relative;
    }
    
    .ai-assistant {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-icon {
        margin-right: 8px;
        color: var(--primary);
    }
    
    .ai-response {
        background-color: #f8f9fc;
        border-left: 3px solid var(--ai-color);
        padding: 0.75rem 1rem;
        margin-top: 0.5rem;
        border-radius: 0 4px 4px 0;
        font-size: 0.875rem;
        display: none;
    }
    
    .vital-signs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    
    .vital-card {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }
    
    .vital-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .vital-label {
        font-size: 0.875rem;
        color: var(--secondary);
        margin-bottom: 5px;
    }
    
    .vital-value {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--primary);
    }
    
    .history-table {
        width: 100%;
        font-size: 0.875rem;
        border-collapse: collapse;
    }
    
    .history-table th {
        background-color: #f0f4f9;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: var(--primary);
    }
    
    .history-table td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border);
        vertical-align: top;
    }
    
    .history-table tr:hover {
        background-color: rgba(44, 123, 229, 0.03);
    }
    
    .badge-status {
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-info {
        background-color: #e1f0ff;
        color: var(--primary);
    }
    
    .badge-success {
        background-color: #d7f5ee;
        color: var(--success);
    }
    
    .badge-warning {
        background-color: #fef5d7;
        color: #e6a700;
    }
    
    .soap-label {
        font-size: 0.8rem;
        color: var(--secondary);
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .soap-content {
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    .ai-loading {
        display: inline-flex;
        align-items: center;
        color: var(--ai-color);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .ai-loading .spinner {
        border: 2px solid rgba(111, 66, 193, 0.2);
        border-top: 2px solid var(--ai-color);
        border-radius: 50%;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        margin-right: 8px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
        
        .ai-assistant {
            position: static;
            margin-bottom: 1rem;
            flex-direction: row;
            flex-wrap: wrap;
        }
        
        .vital-signs-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        }
    }
</style>

<div class="container-xl">
    <div class="adime-card">
        <div class="adime-card-header">
            <h3 class="adime-card-title">
                <i class="fas fa-file-medical me-2"></i>Form Pemeriksaan Pasien Baru
            </h3>
            <div class="card-actions">
                <a href="#" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <form action="{{ route('soapie.store') }}" method="POST">
            @csrf
            <div class="adime-card-body">
                <div class="info-badge">
                    <i class="fas fa-info-circle me-2"></i>
                    Silakan lengkapi form berikut untuk pemeriksaan pasien baru
                </div>
                
                <div class="info-badge ai-badge">
                    <i class="fas fa-robot me-2"></i>
                    Gunakan AI Assistant untuk membantu mengisi diagnosis dan rencana
                </div>
                
                <div class="row">
                    <!-- Informasi Pasien -->
                    <div class="col-lg-4">
                        <div class="patient-info-card">
                            <h4 class="section-title">
                                <i class="fas fa-user-injured me-2"></i>Informasi Pasien
                            </h4>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jam</label>
                                <input type="time" class="form-control" name="jam" value="{{ date('H:i:s') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ID Rawat</label>
                                <input type="text" class="form-control" name="no_rawat" value="{{ $no_rawat_formatted ?? '' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor RM</label>
                                <input type="text" class="form-control" name="no_rm" value="{{ $caripasien->no_rkm_medis ?? '' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control" name="nama_pasien" value="{{ $caripasien->pasien->nm_pasien ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pemeriksaan Fisik & SOAP -->
                    <div class="col-lg-8">
                        <div class="examination-card">
                            <h4 class="section-title">
                                <i class="fas fa-stethoscope me-2"></i>Pemeriksaan Fisik
                            </h4>
                            <div class="vital-signs-grid">
                                <div class="vital-card">
                                    <div class="vital-label">Tensi (mmHg)</div>
                                    <input type="text" class="form-control" name="tensi" maxlength="8" placeholder="120/80" value="{{ old('tensi') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">Suhu (°C)</div>
                                    <input type="text" class="form-control" name="suhu_tubuh" maxlength="5" placeholder="36.5" value="{{ old('suhu_tubuh') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">Nadi (/menit)</div>
                                    <input type="text" class="form-control" name="nadi" maxlength="3" placeholder="72" value="{{ old('nadi') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">RR (/menit)</div>
                                    <input type="text" class="form-control" name="respirasi" maxlength="3" placeholder="18" value="{{ old('respirasi') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">Tinggi (cm)</div>
                                    <input type="text" class="form-control" name="tinggi" maxlength="5" placeholder="165" value="{{ old('tinggi') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">Berat (kg)</div>
                                    <input type="text" class="form-control" name="berat" maxlength="5" placeholder="65" value="{{ old('berat') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">Kesadaran</div>
                                    <select class="form-control" name="kesadaran">
                                        <option value="Compos Mentis"{{ old('kesadaran', 'Compos Mentis') == 'Compos Mentis' ? ' selected' : '' }}>Compos Mentis</option>
                                        <option value="Somnolence"{{ old('kesadaran') == 'Somnolence' ? ' selected' : '' }}>Somnolence</option>
                                        <option value="Sopor"{{ old('kesadaran') == 'Sopor' ? ' selected' : '' }}>Sopor</option>
                                        <option value="Coma"{{ old('kesadaran') == 'Coma' ? ' selected' : '' }}>Coma</option>
                                        <option value="Alert"{{ old('kesadaran') == 'Alert' ? ' selected' : '' }}>Alert</option>
                                        <option value="Confusion"{{ old('kesadaran') == 'Confusion' ? ' selected' : '' }}>Confusion</option>
                                        <option value="Voice"{{ old('kesadaran') == 'Voice' ? ' selected' : '' }}>Voice</option>
                                        <option value="Pain"{{ old('kesadaran') == 'Pain' ? ' selected' : '' }}>Pain</option>
                                        <option value="Unresponsive"{{ old('kesadaran') == 'Unresponsive' ? ' selected' : '' }}>Unresponsive</option>
                                        <option value="Apatis"{{ old('kesadaran') == 'Apatis' ? ' selected' : '' }}>Apatis</option>
                                        <option value="Delirium"{{ old('kesadaran') == 'Delirium' ? ' selected' : '' }}>Delirium</option>
                                    </select>
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">SPO2 (%)</div>
                                    <input type="text" class="form-control" name="spo2" maxlength="3" placeholder="98" value="{{ old('spo2') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">GCS (E,V,M)</div>
                                    <input type="text" class="form-control" name="gcs" maxlength="10" placeholder="E4V5M6" value="{{ old('gcs') }}">
                                </div>
                                <div class="vital-card">
                                    <div class="vital-label">Alergi</div>
                                    <input type="text" class="form-control" name="alergi" maxlength="50" placeholder="Tidak ada" value="{{ old('alergi') }}">
                                </div>
                            </div>
                        </div>
                        
                        <!-- SOAP Section -->
                        <div class="soap-card">
                            <h4 class="section-title">
                                <i class="fas fa-file-medical-alt me-2"></i>Catatan SOAP
                            </h4>
                            <div class="form-section">
                                <div class="ai-assistant">
                                    <button type="button" class="btn btn-ai btn-sm" onclick="generateAssessment()" title="Generate AI Assessment">
                                        <i class="fas fa-robot me-1"></i> AI Rekomendasi
                                    </button>
                                </div>
                                
                                <label class="form-label">Subyektif (Keluhan)</label>
                                <textarea class="form-control" name="keluhan" maxlength="2000" rows="3" placeholder="Keluhan pasien...">{{ old('keluhan') }}</textarea>
                            </div>
                            
                            <div class="form-section">
                                <div class="ai-assistant">
                                    <button type="button" class="btn btn-ai btn-sm" onclick="generateAssessment()" title="Generate AI Assessment">
                                        <i class="fas fa-robot me-1"></i> AI Rekomendasi
                                    </button>
                                </div>
                                
                                <label class="form-label">Obyektif (Pemeriksaan)</label>
                                <textarea class="form-control" name="pemeriksaan" maxlength="2000" rows="3" placeholder="Hasil pemeriksaan...">{{ old('pemeriksaan') }}</textarea>
                            </div>
                            
                            <div class="form-section">
                                <div class="ai-assistant">
                                    <button type="button" class="btn btn-ai btn-sm" onclick="generateAssessment()" title="Generate AI Assessment">
                                        <i class="fas fa-robot me-1"></i> AI Rekomendasi
                                    </button>
                                </div>
                                
                                <label class="form-label">Assessment (Penilaian)</label>
                                <textarea class="form-control" name="penilaian" id="assessment-field" maxlength="2000" rows="3" placeholder="Diagnosa...">{{ old('penilaian') }}</textarea>
                                <div id="assessment-loading" class="ai-loading" style="display: none;">
                                    <div class="spinner"></div>
                                    <span>AI sedang menganalisis...</span>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="ai-assistant">
                                    <button type="button" class="btn btn-ai btn-sm" onclick="generatePlan()" title="Generate AI Plan">
                                        <i class="fas fa-robot me-1"></i> AI Plan
                                    </button>
                                </div>
                                
                                <label class="form-label">Plan (Rencana Tindak Lanjut)</label>
                                <textarea class="form-control" name="rtl" id="plan-field" maxlength="2000" rows="3" placeholder="Rencana pengobatan...">{{ old('rtl') }}</textarea>
                                <div id="plan-loading" class="ai-loading" style="display: none;">
                                    <div class="spinner"></div>
                                    <span>AI sedang membuat rencana...</span>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="ai-assistant">
                                    <button type="button" class="btn btn-ai btn-sm" onclick="generateInstruksi()" title="Generate AI Instruksi">
                                        <i class="fas fa-robot me-1"></i> AI Instruksi
                                    </button>
                                </div>
                                
                                <label class="form-label">Instruksi</label>
                                <textarea class="form-control" name="instruksi" id="instruksi-field" maxlength="2000" rows="2" placeholder="Instruksi untuk pasien...">{{ old('instruksi') }}</textarea>
                                <div id="instruksi-loading" class="ai-loading" style="display: none;">
                                    <div class="spinner"></div>
                                    <span>AI sedang membuat instruksi...</span>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="ai-assistant">
                                    <button type="button" class="btn btn-ai btn-sm" onclick="generateEvaluasi()" title="Generate AI Evaluasi">
                                        <i class="fas fa-robot me-1"></i> AI Evaluasi
                                    </button>
                                </div>
                                
                                <label class="form-label">Evaluasi</label>
                                <textarea class="form-control" name="evaluasi" id="evaluasi-field" maxlength="2000" rows="2" placeholder="Evaluasi hasil...">{{ old('evaluasi') }}</textarea>
                                <div id="evaluasi-loading" class="ai-loading" style="display: none;">
                                    <div class="spinner"></div>
                                    <span>AI sedang membuat evaluasi...</span>
                                </div>
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i> Simpan Pemeriksaan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Riwayat Pemeriksaan -->
    <div class="adime-card history-card">
        <div class="adime-card-header">
            <h3 class="adime-card-title">
                <i class="fas fa-history me-2"></i>Riwayat Pemeriksaan Pasien
            </h3>
            <div class="card-options">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control form-control" placeholder="Cari riwayat...">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="history-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Tanggal & Waktu</th>
                        <th>Vital Signs</th>
                        <th>Status</th>
                        <th>Assessment & Plan</th>
                        <th>Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($soapie as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div class="font-weight-bold">{{ \Carbon\Carbon::parse($item->tgl_perawatan)->format('d M Y') }}</div>
                            <div class="text-muted small">{{ $item->jam_rawat }}</div>
                            <div class="badge-status {{ $item->location == 'Rawat Inap' ? 'badge-info' : 'badge-success' }} mt-1">{{ $item->location }}</div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap">
                                <div class="mr-3 mb-1">
                                    <span class="text-muted">Suhu:</span>
                                    <span class="font-weight-bold">{{ $item->suhu_tubuh }}°C</span>
                                </div>
                                <div class="mr-3 mb-1">
                                    <span class="text-muted">TD:</span>
                                    <span class="font-weight-bold">{{ $item->tensi }} mmHg</span>
                                </div>
                                <div class="mr-3 mb-1">
                                    <span class="text-muted">Nadi:</span>
                                    <span class="font-weight-bold">{{ $item->nadi }}/mnt</span>
                                </div>
                                <div class="mr-3 mb-1">
                                    <span class="text-muted">RR:</span>
                                    <span class="font-weight-bold">{{ $item->respirasi }}/mnt</span>
                                </div>
                                <div class="mr-3 mb-1">
                                    <span class="text-muted">SPO2:</span>
                                    <span class="font-weight-bold">{{ $item->spo2 }}%</span>
                                </div>
                                <div class="mr-3 mb-1">
                                    <span class="text-muted">GCS:</span>
                                    <span class="font-weight-bold">{{ $item->gcs }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-1">
                                <span class="text-muted">Kesadaran:</span>
                                <span class="font-weight-bold">{{ $item->kesadaran }}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-muted">Alergi:</span>
                                <span class="font-weight-bold">{{ $item->alergi ?: '-' }}</span>
                            </div>
                            <div class="mb-1">
                                <span class="text-muted">Tinggi/Berat:</span>
                                <span class="font-weight-bold">{{ $item->tinggi }}cm / {{ $item->berat }}kg</span>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">
                                <div class="soap-label">Subyektif:</div>
                                <div class="soap-content">{{ $item->keluhan ?: '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="soap-label">Obyektif:</div>
                                <div class="soap-content">{{ $item->pemeriksaan ?: '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="soap-label">Assessment:</div>
                                <div class="soap-content">{{ $item->penilaian ?: '-' }}</div>
                            </div>
                            <div class="mb-2">
                                <div class="soap-label">Plan:</div>
                                <div class="soap-content">{{ $item->rtl ?: '-' }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-bold">{{ $item->dokter }}</div>
                            <div class="soap-label">Instruksi:</div>
                            <div class="soap-content">{{ $item->instruksi ?: '-' }}</div>
                            <div class="soap-label mt-2">Evaluasi:</div>
                            <div class="soap-content">{{ $item->evaluasi ?: '-' }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="adime-card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">Menampilkan {{ count($soapie) }} dari {{ count($soapie) }} entri</div>
            <ul class="pagination mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Function to collect all examination data
function collectExaminationData() {
    const data = {
        // Vital signs
        tensi: $('input[name="tensi"]').val() || '',
        suhu: $('input[name="suhu_tubuh"]').val() || '',
        nadi: $('input[name="nadi"]').val() || '',
        respirasi: $('input[name="respirasi"]').val() || '',
        spo2: $('input[name="spo2"]').val() || '',
        
        // Physical examination
        tinggi: $('input[name="tinggi"]').val() || '',
        berat: $('input[name="berat"]').val() || '',
        gcs: $('input[name="gcs"]').val() || '',
        kesadaran: $('select[name="kesadaran"]').val() || '',
        alergi: $('input[name="alergi"]').val() || '',
        
        // SOAP data
        keluhan: $('textarea[name="keluhan"]').val() || '',
        pemeriksaan: $('textarea[name="pemeriksaan"]').val() || '',
        
        // Patient info
        nama_pasien: $('input[name="nama_pasien"]').val() || '',
        no_rm: $('input[name="no_rm"]').val() || '',

        // History
        history: getPatientHistory()
    };
    
    return data;
}

// Function to get patient history for AI context
function getPatientHistory() {
    const history = [];
    @if(isset($soapie))
    @foreach($soapie->take(5) as $item) // Ambil 5 riwayat terakhir
        history.push({
            tanggal: '{{ $item->tgl_perawatan }}',
            jam: '{{ $item->jam_rawat }}',
            lokasi: '{{ $item->location }}',
            keluhan: `{{ str_replace(["\r", "\n"], ' ', $item->keluhan) }}`,
            pemeriksaan: `{{ str_replace(["\r", "\n"], ' ', $item->pemeriksaan) }}`,
            penilaian: `{{ str_replace(["\r", "\n"], ' ', $item->penilaian) }}`,
            rtl: `{{ str_replace(["\r", "\n"], ' ', $item->rtl) }}`,
        });
    @endforeach
    @endif
    return history;
}

const aiPromptInstruction = `
Bertindaklah sebagai seorang dokter atau perawat senior yang berpengalaman dan empatik.
Berdasarkan data pasien dan riwayat pemeriksaan sebelumnya, susunlah analisis medis (assessment, plan, dll.) yang relevan.

Gunakan bahasa yang profesional namun tetap humanis dan mudah dipahami, seolah-olah Anda sedang menulis catatan medis untuk kolega Anda, dengan fokus pada kesinambungan perawatan pasien.

- Analisis kondisi pasien saat ini dengan mempertimbangkan riwayatnya. Jika ada masalah kronis atau berulang, sebutkan dalam penilaian.
- Buatkan rencana yang jelas, logis, dan berpusat pada pasien. Gunakan kata kerja aktif (misal: "Lanjutkan observasi TTV," "Edukasi pasien tentang...").
- Tiru alur dan terminologi dari riwayat sebelumnya, namun perbaiki menjadi kalimat yang lebih terstruktur, lengkap, dan profesional. Hindari bahasa yang kaku atau terdengar seperti mesin.
`;

// Function to format examination data for AI analysis
function formatDataForAI(data) {
    let formattedData = `Data Pemeriksaan Pasien:\n`;
    formattedData += `Nama: ${data.nama_pasien}\n`;
    formattedData += `No. RM: ${data.no_rm}\n\n`;
    
    formattedData += `Tanda Vital:\n`;
    if (data.suhu) formattedData += `- Suhu: ${data.suhu}°C\n`;
    if (data.tensi) formattedData += `- TD: ${data.tensi} mmHg\n`;
    if (data.nadi) formattedData += `- Nadi: ${data.nadi}/mnt\n`;
    if (data.respirasi) formattedData += `- RR: ${data.respirasi}/mnt\n`;
    if (data.spo2) formattedData += `- SPO2: ${data.spo2}%\n`;
    if (data.gcs) formattedData += `- GCS: ${data.gcs}\n`;
    if (data.kesadaran) formattedData += `- Kesadaran: ${data.kesadaran}\n`;
    if (data.alergi) formattedData += `- Alergi: ${data.alergi}\n`;
    if (data.tinggi && data.berat) formattedData += `- Tinggi/Berat: ${data.tinggi}cm / ${data.berat}kg\n`;
    
    formattedData += `\nSubyektif (Saat Ini):\n${data.keluhan}\n`;
    formattedData += `\nObyektif (Saat Ini):\n${data.pemeriksaan}\n`;

    if (data.history && data.history.length > 0) {
        formattedData += `\n\n--- RIWAYAT PEMERIKSAAN SEBELUMNYA ---\n`;
        data.history.forEach(item => {
            formattedData += `\nTanggal: ${item.tanggal} ${item.jam} (${item.lokasi})\n`;
            if(item.keluhan) formattedData += `Keluhan: ${item.keluhan}\n`;
            if(item.pemeriksaan) formattedData += `Pemeriksaan: ${item.pemeriksaan}\n`;
            if(item.penilaian) formattedData += `Assessment: ${item.penilaian}\n`;
            if(item.rtl) formattedData += `Plan: ${item.rtl}\n`;
        });
    }
    
    return formattedData;
}

// Generate AI Assessment
function generateAssessment() {
    const data = collectExaminationData();
    
    // Validate required data
    if (!data.keluhan && !data.pemeriksaan) {
        alert('Mohon isi data Subyektif (Keluhan) dan Obyektif (Pemeriksaan) terlebih dahulu untuk mendapatkan rekomendasi AI.');
        return;
    }
    
    const formattedData = formatDataForAI(data) + '\n' + aiPromptInstruction;
    
    $('#assessment-loading').show();
    $('#assessment-field').prop('disabled', true);
    
    // Call AI API for medical analysis
    $.ajax({
        url: '{{ route("ai.analyze-medical") }}',
        method: 'POST',
        data: {
            text: formattedData,
            analysis_type: 'diagnosis',
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#assessment-field').val(response.message);
                showNotification('AI Assessment berhasil dibuat!', 'success');
            } else {
                showNotification('Error: ' + (response.error || 'Gagal membuat assessment'), 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AI Assessment Error:', error);
            showNotification('Koneksi AI gagal. Pastikan API key sudah dikonfigurasi.', 'error');
        },
        complete: function() {
            $('#assessment-loading').hide();
            $('#assessment-field').prop('disabled', false);
        }
    });
}

// Generate AI Instruksi
function generateInstruksi() {
    const data = collectExaminationData();
    const assessment = $('#assessment-field').val();
    
    // Validate required data
    if (!data.keluhan && !data.pemeriksaan && !assessment) {
        alert('Mohon isi data pemeriksaan dan assessment terlebih dahulu untuk mendapatkan instruksi AI.');
        return;
    }
    
    let formattedData = formatDataForAI(data);
    if (assessment) {
        formattedData += `\nAssessment (Saat Ini):\n${assessment}\n`;
    }
    formattedData += '\n' + aiPromptInstruction;
    
    $('#instruksi-loading').show();
    $('#instruksi-field').prop('disabled', true);
    
    // Call AI API for treatment recommendations
    $.ajax({
        url: '{{ route("ai.analyze-medical") }}',
        method: 'POST',
        data: {
            text: formattedData,
            analysis_type: 'treatment',
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#instruksi-field').val(response.message);
                showNotification('AI Instruksi berhasil dibuat!', 'success');
            } else {
                showNotification('Error: ' + (response.error || 'Gagal membuat instruksi'), 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AI Instruksi Error:', error);
            showNotification('Koneksi AI gagal. Pastikan API key sudah dikonfigurasi.', 'error');
        },
        complete: function() {
            $('#instruksi-loading').hide();
            $('#instruksi-field').prop('disabled', false);
        }
    });
}

// Generate AI Plan
function generatePlan() {
    const data = collectExaminationData();
    const assessment = $('#assessment-field').val();
    
    // Validate required data
    if (!data.keluhan && !data.pemeriksaan && !assessment) {
        alert('Mohon isi data pemeriksaan dan assessment terlebih dahulu untuk mendapatkan rencana AI.');
        return;
    }
    
    let formattedData = formatDataForAI(data);
    if (assessment) {
        formattedData += `\nAssessment (Saat Ini):\n${assessment}\n`;
    }
    formattedData += '\n' + aiPromptInstruction;
    
    $('#plan-loading').show();
    $('#plan-field').prop('disabled', true);
    
    // Call AI API for treatment plan
    $.ajax({
        url: '{{ route("ai.analyze-medical") }}',
        method: 'POST',
        data: {
            text: formattedData,
            analysis_type: 'plan',
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#plan-field').val(response.message);
                showNotification('AI Plan berhasil dibuat!', 'success');
            } else {
                showNotification('Error: ' + (response.error || 'Gagal membuat rencana'), 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AI Plan Error:', error);
            showNotification('Koneksi AI gagal. Pastikan API key sudah dikonfigurasi.', 'error');
        },
        complete: function() {
            $('#plan-loading').hide();
            $('#plan-field').prop('disabled', false);
        }
    });
}

// Generate AI Evaluasi
function generateEvaluasi() {
    const data = collectExaminationData();
    const assessment = $('#assessment-field').val();
    const plan = $('#plan-field').val();
    
    // Validate required data
    if (!data.keluhan && !data.pemeriksaan && !assessment && !plan) {
        alert('Mohon isi data pemeriksaan, assessment, dan rencana terlebih dahulu untuk mendapatkan evaluasi AI.');
        return;
    }
    
    let formattedData = formatDataForAI(data);
    if (assessment) {
        formattedData += `\nAssessment (Saat Ini):\n${assessment}\n`;
    }
    if (plan) {
        formattedData += `\nPlan (Saat Ini):\n${plan}\n`;
    }
    formattedData += '\n' + aiPromptInstruction;
    
    $('#evaluasi-loading').show();
    $('#evaluasi-field').prop('disabled', true);
    
    // Call AI API for evaluation
    $.ajax({
        url: '{{ route("ai.analyze-medical") }}',
        method: 'POST',
        data: {
            text: formattedData,
            analysis_type: 'evaluation',
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#evaluasi-field').val(response.message);
                showNotification('AI Evaluasi berhasil dibuat!', 'success');
            } else {
                showNotification('Error: ' + (response.error || 'Gagal membuat evaluasi'), 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AI Evaluasi Error:', error);
            showNotification('Koneksi AI gagal. Pastikan API key sudah dikonfigurasi.', 'error');
        },
        complete: function() {
            $('#evaluasi-loading').hide();
            $('#evaluasi-field').prop('disabled', false);
        }
    });
}

// Show notification function
function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    // Insert notification at the top of the form
    $('.card-body').first().prepend(notification);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

// Add some styling for AI buttons
$(document).ready(function() {
    // Add hover effects and styling
    $('button[onclick*="generate"]').hover(
        function() {
            $(this).addClass('shadow-sm');
        },
        function() {
            $(this).removeClass('shadow-sm');
        }
    );
});
</script>
@endpush