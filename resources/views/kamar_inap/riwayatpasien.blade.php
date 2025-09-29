@extends('layouts.pages-layouts')

@section('pageTitle', 'Riwayat Pemeriksaan')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
  .card {
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  .card-header {
    padding: 12px 16px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
  }
  .table-responsive {
    overflow-x: auto;
  }
  .section-title {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    color: #495057;
  }
  .tab-content {
    padding: 15px 0;
  }
  .nav-tabs .nav-link {
    border: none;
    color: #495057;
    padding: 10px 20px;
  }
  .nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    background-color: transparent;
  }
  .soap-row {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 4px;
    background-color: #f8f9fa;
  }
  .soap-date {
    font-weight: bold;
    color: #0d6efd;
  }
  .soap-type {
    font-size: 0.85rem;
    color: #6c757d;
  }
  .soap-section {
    margin-top: 5px;
  }
  .soap-label {
    font-weight: bold;
    color: #495057;
  }
  .loading-spinner {
    display: flex;
    justify-content: center;
    padding: 20px;
  }
  .identitas-card {
  margin-bottom: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.identitas-card .card-header {
  font-weight: bold;
  font-size: 1.2rem;
}
.table-borderless td, .table-borderless th {
  border: none;
  padding: 5px 0;
}
/* Tambahan agar tabel identitas responsif di mobile */
@media (max-width: 576px) {
  .table th, .table td {
    white-space: nowrap;
    font-size: 0.95rem;
  }
  .table td {
    word-break: break-word;
    max-width: 120px;
  }
  .table-responsive {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
  }
  .table {
    min-width: 400px;
  }
  .card-body, .tab-pane {
    padding-left: 2px !important;
    padding-right: 2px !important;
  }
  .container-fluid, .card, .card-body, .tab-pane {
    overflow: visible !important;
    max-width: 100vw !important;
  }
}
</style>

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title">Data Pasien & Registrasi</h3>
        </div>
    
        <div class="card-body">
          <ul class="nav nav-tabs mb-3" id="dataTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="identitas-tab" data-bs-toggle="tab" data-bs-target="#identitas" type="button" role="tab">
                Identitas Pasien
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="registrasi-tab" data-bs-toggle="tab" data-bs-target="#registrasi" type="button" role="tab">
                Data Registrasi
              </button>
            </li>
          </ul>
    
          <div class="tab-content" id="dataTabContent">
            {{-- Tab Identitas --}}
            <div class="tab-pane fade show active" id="identitas" role="tabpanel">
              @if($pasien)
              <div class="table-responsive">
              <table class="table table-sm">
                <tr><th>No. RM</th><td>{{ $pasien->no_rkm_medis }}</td></tr>
                <tr><th>Nama</th><td>{{ $pasien->nm_pasien }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                <tr><th>Tempat/Tgl Lahir</th><td>{{ $pasien->tmp_lahir }}, {{ date('d-m-Y', strtotime($pasien->tgl_lahir)) }}</td></tr>
                <tr><th>Nama Ibu</th><td>{{ $pasien->nm_ibu }}</td></tr>
                <tr><th>Alamat</th><td>{{ $pasien->alamat }}</td></tr>
                <tr><th>No. KTP</th><td>{{ $pasien->no_ktp }}</td></tr>
                <tr><th>Gol. Darah</th><td>{{ $pasien->gol_darah }}</td></tr>
                <tr><th>Pekerjaan</th><td>{{ $pasien->pekerjaan }}</td></tr>
                <tr><th>Status Nikah</th><td>{{ $pasien->stts_nikah }}</td></tr>
                <tr><th>Agama</th><td>{{ $pasien->agama }}</td></tr>
                <tr><th>No. Telepon</th><td>{{ $pasien->no_tlp }}</td></tr>
              </table>
              </div>
              @else
              <div class="alert alert-warning">Data pasien tidak ditemukan</div>
              @endif
            </div>
    
            {{-- Tab Registrasi --}}
            <div class="tab-pane fade" id="registrasi" role="tabpanel">
              @if($regPeriksa)
              <div class="table-responsive">
              <table class="table table-sm">
                <tr><th>No. Registrasi</th><td>{{ $regPeriksa->no_reg }}</td></tr>
                <tr><th>No. Rawat</th><td>{{ $regPeriksa->no_rawat }}</td></tr>
                <tr><th>Tgl/Jam Registrasi</th><td>{{ date('d-m-Y', strtotime($regPeriksa->tgl_registrasi)) }} {{ $regPeriksa->jam_reg }}</td></tr>
                <tr><th>Kode Dokter</th><td>{{ $regPeriksa->kd_dokter }}</td></tr>
                <tr><th>Kode Poli</th><td>{{ $regPeriksa->kd_poli }}</td></tr>
                <tr><th>Penanggung Jawab</th><td>{{ $regPeriksa->p_jawab }}</td></tr>
                <tr><th>Alamat PJ</th><td>{{ $regPeriksa->almt_pj }}</td></tr>
                <tr><th>Hubungan PJ</th><td>{{ $regPeriksa->hubunganpj }}</td></tr>
                <tr><th>Biaya Registrasi</th><td>{{ number_format($regPeriksa->biaya_reg, 0, ',', '.') }}</td></tr>
                <tr><th>Status</th><td>{{ $regPeriksa->stts }}</td></tr>
                <tr><th>Status Daftar</th><td>{{ $regPeriksa->stts_daftar }}</td></tr>
                <tr><th>Status Lanjut</th><td>{{ $regPeriksa->status_lanjut }}</td></tr>
                <tr><th>Kode Penjamin</th><td>{{ $regPeriksa->kd_pj }}</td></tr>
                <tr><th>Umur Daftar</th><td>{{ $regPeriksa->umurdaftar }} {{ $regPeriksa->sttsumur }}</td></tr>
                <tr><th>Status Bayar</th><td>{{ $regPeriksa->status_bayar }}</td></tr>
                <tr><th>Status Poli</th><td>{{ $regPeriksa->status_poli }}</td></tr>
              </table>
              </div>
              @else
              <div class="alert alert-warning">Data registrasi tidak ditemukan</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Riwayat Pasien - {{ $no_rawat }}</h3>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="soap-tab" data-bs-toggle="tab" data-bs-target="#soap" type="button" role="tab" aria-controls="soap" aria-selected="true">SOAP</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="medication-tab" data-bs-toggle="tab" data-bs-target="#medication" type="button" role="tab" aria-controls="medication" aria-selected="false">Obat</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="lab-tab" data-bs-toggle="tab" data-bs-target="#lab" type="button" role="tab" aria-controls="lab" aria-selected="false">Laboratorium</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="radiology-tab" data-bs-toggle="tab" data-bs-target="#radiology" type="button" role="tab" aria-controls="radiology" aria-selected="false">Radiologi</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="diagnosis-tab" data-bs-toggle="tab" data-bs-target="#diagnosis" type="button" role="tab" aria-controls="diagnosis" aria-selected="false">Diagnosa</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tindakan-tab" data-bs-toggle="tab" data-bs-target="#tindakan" type="button" role="tab" aria-controls="tindakan" aria-selected="false">Tindakan</button>
            </li>
          </ul>
          
          <div class="tab-content" id="myTabContent">
            <!-- SOAP Tab -->
            <div class="tab-pane fade show active" id="soap" role="tabpanel" aria-labelledby="soap-tab">
              <div id="soap-content">
                <h4 class="section-title">Rawat Inap</h4>
                @if($data->isEmpty())
                  <div class="alert alert-info">Tidak ada data pemeriksaan rawat inap</div>
                @else
                  @foreach($data as $index => $item)
                    <div class="soap-row">
                      <div class="soap-date">
                        {{ $item->tgl_perawatan }} {{ $item->jam_rawat }} - {{ $item->location }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Subjektif:</span> {{ $item->keluhan }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Objektif:</span> 
                        Suhu: {{ $item->suhu_tubuh }}°C, 
                        Tensi: {{ $item->tensi }}, 
                        Nadi: {{ $item->nadi }}/min, 
                        RR: {{ $item->respirasi }}/min, 
                        GCS: {{ $item->gcs }}, 
                        SpO2: {{ $item->spo2 }}%
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Assessment:</span> {{ $item->pemeriksaan }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Plan:</span> {{ $item->rtl }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Dokter:</span> {{ $item->dokter }}
                      </div>
                    </div>
                  @endforeach
                @endif
                
                <h4 class="section-title" style="margin-top: 30px;">Rawat Jalan</h4>
                @if($soapralan->isEmpty())
                  <div class="alert alert-info">Tidak ada data pemeriksaan rawat jalan</div>
                @else
                  @foreach($soapralan as $index => $item)
                    <div class="soap-row">
                      <div class="soap-date">
                        {{ $item->tgl_perawatan }} {{ $item->jam_rawat }} - {{ $item->location }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Subjektif:</span> {{ $item->keluhan }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Objektif:</span> 
                        Suhu: {{ $item->suhu_tubuh }}°C, 
                        Tensi: {{ $item->tensi }}, 
                        Nadi: {{ $item->nadi }}/min, 
                        RR: {{ $item->respirasi }}/min, 
                        GCS: {{ $item->gcs }}, 
                        SpO2: {{ $item->spo2 }}%
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Assessment:</span> {{ $item->pemeriksaan }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Plan:</span> {{ $item->rtl }}
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Dokter:</span> {{ $item->dokter }}
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
            
            <!-- Medication Tab -->
            <div class="tab-pane fade" id="medication" role="tabpanel" aria-labelledby="medication-tab">
              @if($obat->isEmpty())
                <div class="alert alert-info">Tidak ada data pemberian obat</div>
              @else
                <div class="accordion" id="medicationAccordion">
                  @php $groupedObat = $obat->groupBy('tgl_perawatan'); @endphp
                  @foreach($groupedObat as $tanggal => $items)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ $loop->index }}">
                        {{ $tanggal }}
                      </button>
                    </h2>
                    <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $loop->index }}" data-bs-parent="#medicationAccordion">
                      <div class="accordion-body">
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Jam</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Aturan Pakai</th>
                                <th>Harga</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($items as $item)
                              <tr>
                                <td>{{ $item->jam }}</td>
                                <td>{{ $item->barang->nama_brng }}</td>
                                <td>{{ $item->jml }}</td>
                                <td>
                                  @foreach($aturanPakai as $aturan)
                                    @if($aturan->kode_brng == $item->barang->kode_brng)
                                      {{ $aturan->aturan }}
                                    @endif
                                  @endforeach
                                </td>
                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <!-- Total Biaya Obat -->
                @php $totalObat = $obat->sum('total'); @endphp
                <div class="col-12 mt-2 mb-4">
                  <div class="alert alert-info text-end">
                    <strong>Total Biaya Obat:</strong> Rp {{ number_format($totalObat, 0, ',', '.') }}
                  </div>
                </div>
              @endif
            </div>
            
            <!-- Lab Tab -->
            <div class="tab-pane fade" id="lab" role="tabpanel" aria-labelledby="lab-tab">
              @if($pemeriksaan_lab->isEmpty())
                <div class="alert alert-info">Tidak ada data pemeriksaan laboratorium</div>
              @else
                <div class="accordion" id="labAccordion">
                  @php $groupedLab = $pemeriksaan_lab->groupBy('kd_jenis_prw'); @endphp
                  @foreach($groupedLab as $kd_jenis_prw => $items)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="lab-heading-{{ $loop->index }}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#lab-collapse-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="lab-collapse-{{ $loop->index }}">
                        {{ $nama_perawatan[$kd_jenis_prw] ?? 'Unknown Test' }}
                      </button>
                    </h2>
                    <div id="lab-collapse-{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="lab-heading-{{ $loop->index }}" data-bs-parent="#labAccordion">
                      <div class="accordion-body">
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Pemeriksaan</th>
                                <th>Hasil</th>
                                <th>Nilai Normal</th>
                                <th>Keterangan</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($items as $item)
                              <tr>
                                <td>{{ $item->tgl_periksa }}</td>
                                <td>{{ $item->jam }}</td>
                                <td>{{ $pemeriksaan_template[$item->id_template] ?? '' }}</td>
                                <td>{{ $item->nilai }}</td>
                                <td>{{ $item->nilai_rujukan }}</td>
                                <td>{{ $item->keterangan }}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              @endif
            </div>
            
            <!-- Radiology Tab -->
            <div class="tab-pane fade" id="radiology" role="tabpanel" aria-labelledby="radiology-tab">
              @if($periksaRadiologi->isEmpty())
                <div class="alert alert-info">Tidak ada data pemeriksaan radiologi</div>
              @else
                <div class="accordion" id="radiologyAccordion">
                  @foreach($periksaRadiologi as $index => $item)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="rad-heading-{{ $index }}">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#rad-collapse-{{ $index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="rad-collapse-{{ $index }}">
                        {{ $item->jnsPerawatanRadiologi->nm_perawatan ?? 'Unknown Radiology' }}
                      </button>
                    </h2>
                    <div id="rad-collapse-{{ $index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="rad-heading-{{ $index }}" data-bs-parent="#radiologyAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <p><strong>Tanggal:</strong> {{ $item->tgl_periksa }}</p>
                            <p><strong>Dokter:</strong> {{ $item->dokter_perujuk }}</p>
                            <p><strong>Petugas:</strong> {{ $item->petugas->nama ?? '' }}</p>
                          </div>
                          <div class="col-md-6">
                            <p><strong>Hasil:</strong></p>
                            @if(isset($hasilRadiologi[$index]))
                              <p>{{ $hasilRadiologi[$index]->hasil }}</p>
                            @else
                              <p>Hasil belum tersedia</p>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <!-- Tabel untuk Hasil Bacaan Radiologi -->
                <div class="card card-invoice mt-4">
                  <div class="card-body">
                    <div class="table-responsive">
                      <h3 class="card-title">Hasil Bacaan Radiologi</h3>
                      <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                            <tr>
                              <th>No. Rawat</th>
                              <th>Tgl. Periksa</th>
                              <th>Jam</th>
                              <th>Hasil</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($hasilRadiologi as $result)
                            <tr>
                              <td>{{ $result->no_rawat }}</td>
                              <td>{{ $result->tgl_periksa }}</td>
                              <td>{{ $result->jam }}</td>
                              <td>{{ $result->hasil }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Tambahkan Pemeriksaan Radiologi -->
                <div class="col-12 mt-4">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Pemeriksaan Radiologi</h3>
                    </div>
                    <div class="table-responsive">
                      <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                          <tr>
                            <th>NIP</th>
                            <th>Kd. Jenis Prw</th>
                            <th>Tgl. Periksa</th>
                            <th>Jam</th>
                            <th>Dokter Perujuk</th>
                            <th>Bagian RS</th>
                            <th>Menejemen</th>
                            <th>Biaya</th>
                            <th>Kd. Dokter</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($periksaRadiologi as $result)
                          <tr>
                            <td>{{ $result->petugas->nama }}</td>
                            <td>{{ $result->jnsPerawatanRadiologi->nm_perawatan }}</td>
                            <td>{{ $result->tgl_periksa }}</td>
                            <td>{{ $result->jam }}</td>
                            <td>{{ $result->biaya }}</td>
                            <td>{{ $result->kd_dokter }}</td>
                            <td>{{ $result->status }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              @endif
            </div>
            
            <!-- Diagnosis Tab -->
            <div class="tab-pane fade" id="diagnosis" role="tabpanel" aria-labelledby="diagnosis-tab">
              <div class="row">
                <div class="col-md-6">
                  <h5>Diagnosa</h5>
                  @if($diagnosa->isEmpty())
                    <div class="alert alert-info">Tidak ada data diagnosa</div>
                  @else
                    <ul class="list-group">
                      @foreach($diagnosa as $item)
                      <li class="list-group-item">
                        <strong>{{ $item->prioritas }}.</strong> 
                        {{ $item->penyakit->nm_penyakit ?? '' }}
                        <span class="badge bg-primary">{{ $item->status }}</span>
                      </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
                <div class="col-md-6">
                  <h5>Prosedur</h5>
                  @if($prosedurPasien->isEmpty())
                    <div class="alert alert-info">Tidak ada data prosedur</div>
                  @else
                    <ul class="list-group">
                      @foreach($prosedurPasien as $item)
                      <li class="list-group-item">
                        <strong>{{ $item->prioritas }}.</strong> 
                        {{ $item->icd9->deskripsi ?? '' }}
                        <span class="badge bg-success">{{ $item->status }}</span>
                      </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
              <!-- Tabel untuk Riwayat Diagnosa -->
              <div class="col-12 mt-4">
                <div class="card">
                  <div class="bg-azure text-azure-fg card-header">
                    <h3 class="card-title">
                      Riwayat Diagnosa
                    </h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th>Kode Penyakit</th>
                          <th>Nama Penyakit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($diagnosa as $item)
                        <tr>
                          <td>{{ $item->kd_penyakit }}</td>
                          <td>{{ $item->penyakit->nm_penyakit }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Tambahkan Prosedur Pasien -->
              @unless($prosedurPasien->isEmpty())
              <div class="col-12 mt-4">
                <div class="card">
                  <div class="bg-azure text-azure-fg card-header">
                    <h3 class="card-title">Prosedur Pasien</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Deskripsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($prosedurPasien as $prosedur)
                        <tr>
                          <td>{{ $prosedur->kode }}</td>
                          <td>{{ $prosedur->icd9->deskripsi_panjang }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              @endunless
            </div>
            <!-- Tindakan Tab -->
            <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
              <!-- Tabel untuk Riwayat Tindakan -->
              <div class="col-12 mt-4">
                <div class="card">
                  <div class="card-header" style="background-color: #e9ecef; color: #212529;">
                    <h3 class="card-title" style="color: #212529;">Riwayat Tindakan</h3>
                  </div>
                  <div class="accordion" id="accordionExample">
                    @php
                      $groupedTindakan = $tindakan->groupBy('tgl_perawatan');
                      $accordionIndex = 1;
                    @endphp
                    @foreach ($groupedTindakan as $tanggal => $items)
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading-{{ $accordionIndex }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $accordionIndex }}" aria-expanded="true" aria-controls="collapse-{{ $accordionIndex }}">
                          Tanggal: {{ $tanggal }}
                        </button>
                      </h2>
                      <div id="collapse-{{ $accordionIndex }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $accordionIndex }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                              <thead>
                                <tr>
                                  <th>Jam Rawat</th>
                                  <th>No Rawat</th>
                                  <th>Nama Perawatan</th>
                                  <th>Nama Dokter</th>
                                  <th>Material</th>
                                  <th>BHP</th>
                                  <th>Tarif Tindakan</th>
                                  <th>KSO</th>
                                  <th>Menejemen</th>
                                  <th>Biaya Rawat</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($items as $item)
                                <tr>
                                  <td>{{ $item->jam_rawat }}</td>
                                  <td>{{ $item->no_rawat }}</td>
                                  <td>{{ $item->jenisPerawatan->nm_perawatan }}</td>
                                  <td>{{ $item->dokter->nm_dokter }}</td>
                                  <td>{{ $item->material }}</td>
                                  <td>{{ $item->bhp }}</td>
                                  <td>{{ $item->tarif_tindakandr }}</td>
                                  <td>{{ $item->kso }}</td>
                                  <td>{{ $item->menejemen }}</td>
                                  <td>{{ $item->biaya_rawat }}</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          @php $totalTindakanDokter = $items->sum('biaya_rawat'); @endphp
                          <div class="text-end mt-2">
                            <strong>Total Biaya Rawat (Dokter):</strong> Rp {{ number_format($totalTindakanDokter, 0, ',', '.') }}
                          </div>
                        </div>
                      </div>
                    </div>
                    @php
                      $accordionIndex++;
                    @endphp
                    @endforeach
                  </div>
                </div>
              </div>
              <!-- Tabel untuk Riwayat Tindakan perawat -->
              <div class="col-12 mt-4">
                <div class="card">
                  <div class="card-header" style="background-color: #e9ecef; color: #212529;">
                    <h3 class="card-title" style="color: #212529;">Riwayat Tindakan perawat</h3>
                  </div>
                  <div class="accordion" id="accordionExamplePerawat">
                    @php
                      $groupedTindakanpr = $tindakanpr->groupBy('tgl_perawatan');
                      $accordionIndex = 1;
                    @endphp
                    @foreach ($groupedTindakanpr as $tanggal => $items)
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingpr-{{ $accordionIndex }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsepr-{{ $accordionIndex }}" aria-expanded="true" aria-controls="collapsepr-{{ $accordionIndex }}">
                          Tanggal: {{ $tanggal }}
                        </button>
                      </h2>
                      <div id="collapsepr-{{ $accordionIndex }}" class="accordion-collapse collapse" aria-labelledby="headingpr-{{ $accordionIndex }}" data-bs-parent="#accordionExamplePerawat">
                        <div class="accordion-body">
                          <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                              <thead>
                                <tr>
                                  <th>Jam Rawat</th>
                                  <th>No Rawat</th>
                                  <th>Nama Perawatan</th>
                                  <th>Nama Petugas</th>
                                  <th>Material</th>
                                  <th>BHP</th>
                                  <th>Tarif Tindakan</th>
                                  <th>KSO</th>
                                  <th>Menejemen</th>
                                  <th>Biaya Rawat</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($items as $item)
                                <tr>
                                  <td>{{ $item->jam_rawat }}</td>
                                  <td>{{ $item->no_rawat }}</td>
                                  <td>{{ $item->jenisPerawatan->nm_perawatan }}</td>
                                  <td>{{ $item->petugas->nama }}</td>
                                  <td>{{ $item->material }}</td>
                                  <td>{{ $item->bhp }}</td>
                                  <td>{{ $item->tarif_tindakandr }}</td>
                                  <td>{{ $item->kso }}</td>
                                  <td>{{ $item->menejemen }}</td>
                                  <td>{{ $item->biaya_rawat }}</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          @php $totalTindakanPerawat = $items->sum('biaya_rawat'); @endphp
                          <div class="text-end mt-2">
                            <strong>Total Biaya Rawat (Perawat):</strong> Rp {{ number_format($totalTindakanPerawat, 0, ',', '.') }}
                          </div>
                        </div>
                      </div>
                    </div>
                    @php
                      $accordionIndex++;
                    @endphp
                    @endforeach
                  </div>
                </div>
              </div>
              <!-- Total Biaya Tindakan -->
              @php
                $totalTindakan = $tindakan->sum('biaya_rawat') + $tindakanpr->sum('biaya_rawat');
              @endphp
              <div class="col-12 mt-2 mb-4">
                <div class="alert alert-info text-end">
                  <strong>Total Biaya Tindakan:</strong> Rp {{ number_format($totalTindakan, 0, ',', '.') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  });
  
  // Tab persistence
  const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');
  tabElms.forEach(tabElm => {
    tabElm.addEventListener('click', event => {
      localStorage.setItem('lastTab', event.target.getAttribute('id'));
    });
  });
  
  const lastTab = localStorage.getItem('lastTab');
  if (lastTab) {
    const tab = document.querySelector(`#${lastTab}`);
    if (tab) {
      bootstrap.Tab.getOrCreateInstance(tab).show();
    }
  }
  
  // Responsive table handling
  function handleResponsiveTables() {
    document.querySelectorAll('.table-responsive').forEach(tableWrapper => {
      const table = tableWrapper.querySelector('table');
      if (table && tableWrapper.offsetWidth < table.offsetWidth) {
        tableWrapper.classList.add('shadow-sm');
      } else {
        tableWrapper.classList.remove('shadow-sm');
      }
    });
  }
  
  window.addEventListener('resize', handleResponsiveTables);
  handleResponsiveTables();
  
  // Accordion state persistence
  document.querySelectorAll('.accordion-button').forEach(button => {
    button.addEventListener('click', function() {
      const accordionId = this.getAttribute('data-bs-target');
      const isExpanded = this.getAttribute('aria-expanded') === 'true';
      
      if (isExpanded) {
        localStorage.setItem(accordionId, 'expanded');
      } else {
        localStorage.removeItem(accordionId);
      }
    });
  });
  
  // Restore accordion states
  document.querySelectorAll('.accordion-collapse').forEach(collapse => {
    const collapseId = '#' + collapse.getAttribute('id');
    if (localStorage.getItem(collapseId)) {
      const accordion = bootstrap.Collapse.getOrCreateInstance(collapse, { toggle: false });
      accordion.show();
    }
  });
});
</script>
@endsection