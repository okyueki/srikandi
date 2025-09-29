<?php $__env->startSection('pageTitle', 'Riwayat Pemeriksaan'); ?>

<?php $__env->startSection('content'); ?>
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
            
            <div class="tab-pane fade show active" id="identitas" role="tabpanel">
              <?php if($pasien): ?>
              <div class="table-responsive">
              <table class="table table-sm">
                <tr><th>No. RM</th><td><?php echo e($pasien->no_rkm_medis); ?></td></tr>
                <tr><th>Nama</th><td><?php echo e($pasien->nm_pasien); ?></td></tr>
                <tr><th>Jenis Kelamin</th><td><?php echo e($pasien->jk == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td></tr>
                <tr><th>Tempat/Tgl Lahir</th><td><?php echo e($pasien->tmp_lahir); ?>, <?php echo e(date('d-m-Y', strtotime($pasien->tgl_lahir))); ?></td></tr>
                <tr><th>Nama Ibu</th><td><?php echo e($pasien->nm_ibu); ?></td></tr>
                <tr><th>Alamat</th><td><?php echo e($pasien->alamat); ?></td></tr>
                <tr><th>No. KTP</th><td><?php echo e($pasien->no_ktp); ?></td></tr>
                <tr><th>Gol. Darah</th><td><?php echo e($pasien->gol_darah); ?></td></tr>
                <tr><th>Pekerjaan</th><td><?php echo e($pasien->pekerjaan); ?></td></tr>
                <tr><th>Status Nikah</th><td><?php echo e($pasien->stts_nikah); ?></td></tr>
                <tr><th>Agama</th><td><?php echo e($pasien->agama); ?></td></tr>
                <tr><th>No. Telepon</th><td><?php echo e($pasien->no_tlp); ?></td></tr>
              </table>
              </div>
              <?php else: ?>
              <div class="alert alert-warning">Data pasien tidak ditemukan</div>
              <?php endif; ?>
            </div>
    
            
            <div class="tab-pane fade" id="registrasi" role="tabpanel">
              <?php if($regPeriksa): ?>
              <div class="table-responsive">
              <table class="table table-sm">
                <tr><th>No. Registrasi</th><td><?php echo e($regPeriksa->no_reg); ?></td></tr>
                <tr><th>No. Rawat</th><td><?php echo e($regPeriksa->no_rawat); ?></td></tr>
                <tr><th>Tgl/Jam Registrasi</th><td><?php echo e(date('d-m-Y', strtotime($regPeriksa->tgl_registrasi))); ?> <?php echo e($regPeriksa->jam_reg); ?></td></tr>
                <tr><th>Kode Dokter</th><td><?php echo e($regPeriksa->kd_dokter); ?></td></tr>
                <tr><th>Kode Poli</th><td><?php echo e($regPeriksa->kd_poli); ?></td></tr>
                <tr><th>Penanggung Jawab</th><td><?php echo e($regPeriksa->p_jawab); ?></td></tr>
                <tr><th>Alamat PJ</th><td><?php echo e($regPeriksa->almt_pj); ?></td></tr>
                <tr><th>Hubungan PJ</th><td><?php echo e($regPeriksa->hubunganpj); ?></td></tr>
                <tr><th>Biaya Registrasi</th><td><?php echo e(number_format($regPeriksa->biaya_reg, 0, ',', '.')); ?></td></tr>
                <tr><th>Status</th><td><?php echo e($regPeriksa->stts); ?></td></tr>
                <tr><th>Status Daftar</th><td><?php echo e($regPeriksa->stts_daftar); ?></td></tr>
                <tr><th>Status Lanjut</th><td><?php echo e($regPeriksa->status_lanjut); ?></td></tr>
                <tr><th>Kode Penjamin</th><td><?php echo e($regPeriksa->kd_pj); ?></td></tr>
                <tr><th>Umur Daftar</th><td><?php echo e($regPeriksa->umurdaftar); ?> <?php echo e($regPeriksa->sttsumur); ?></td></tr>
                <tr><th>Status Bayar</th><td><?php echo e($regPeriksa->status_bayar); ?></td></tr>
                <tr><th>Status Poli</th><td><?php echo e($regPeriksa->status_poli); ?></td></tr>
              </table>
              </div>
              <?php else: ?>
              <div class="alert alert-warning">Data registrasi tidak ditemukan</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Riwayat Pasien - <?php echo e($no_rawat); ?></h3>
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
                <?php if($data->isEmpty()): ?>
                  <div class="alert alert-info">Tidak ada data pemeriksaan rawat inap</div>
                <?php else: ?>
                  <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="soap-row">
                      <div class="soap-date">
                        <?php echo e($item->tgl_perawatan); ?> <?php echo e($item->jam_rawat); ?> - <?php echo e($item->location); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Subjektif:</span> <?php echo e($item->keluhan); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Objektif:</span> 
                        Suhu: <?php echo e($item->suhu_tubuh); ?>°C, 
                        Tensi: <?php echo e($item->tensi); ?>, 
                        Nadi: <?php echo e($item->nadi); ?>/min, 
                        RR: <?php echo e($item->respirasi); ?>/min, 
                        GCS: <?php echo e($item->gcs); ?>, 
                        SpO2: <?php echo e($item->spo2); ?>%
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Assessment:</span> <?php echo e($item->pemeriksaan); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Plan:</span> <?php echo e($item->rtl); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Dokter:</span> <?php echo e($item->dokter); ?>

                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                
                <h4 class="section-title" style="margin-top: 30px;">Rawat Jalan</h4>
                <?php if($soapralan->isEmpty()): ?>
                  <div class="alert alert-info">Tidak ada data pemeriksaan rawat jalan</div>
                <?php else: ?>
                  <?php $__currentLoopData = $soapralan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="soap-row">
                      <div class="soap-date">
                        <?php echo e($item->tgl_perawatan); ?> <?php echo e($item->jam_rawat); ?> - <?php echo e($item->location); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Subjektif:</span> <?php echo e($item->keluhan); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Objektif:</span> 
                        Suhu: <?php echo e($item->suhu_tubuh); ?>°C, 
                        Tensi: <?php echo e($item->tensi); ?>, 
                        Nadi: <?php echo e($item->nadi); ?>/min, 
                        RR: <?php echo e($item->respirasi); ?>/min, 
                        GCS: <?php echo e($item->gcs); ?>, 
                        SpO2: <?php echo e($item->spo2); ?>%
                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Assessment:</span> <?php echo e($item->pemeriksaan); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Plan:</span> <?php echo e($item->rtl); ?>

                      </div>
                      <div class="soap-section">
                        <span class="soap-label">Dokter:</span> <?php echo e($item->dokter); ?>

                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Medication Tab -->
            <div class="tab-pane fade" id="medication" role="tabpanel" aria-labelledby="medication-tab">
              <?php if($obat->isEmpty()): ?>
                <div class="alert alert-info">Tidak ada data pemberian obat</div>
              <?php else: ?>
                <div class="accordion" id="medicationAccordion">
                  <?php $groupedObat = $obat->groupBy('tgl_perawatan'); ?>
                  <?php $__currentLoopData = $groupedObat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanggal => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-<?php echo e($loop->index); ?>">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($loop->index); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>" aria-controls="collapse-<?php echo e($loop->index); ?>">
                        <?php echo e($tanggal); ?>

                      </button>
                    </h2>
                    <div id="collapse-<?php echo e($loop->index); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>" aria-labelledby="heading-<?php echo e($loop->index); ?>" data-bs-parent="#medicationAccordion">
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
                              <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td><?php echo e($item->jam); ?></td>
                                <td><?php echo e($item->barang->nama_brng); ?></td>
                                <td><?php echo e($item->jml); ?></td>
                                <td>
                                  <?php $__currentLoopData = $aturanPakai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aturan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($aturan->kode_brng == $item->barang->kode_brng): ?>
                                      <?php echo e($aturan->aturan); ?>

                                    <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- Total Biaya Obat -->
                <?php $totalObat = $obat->sum('total'); ?>
                <div class="col-12 mt-2 mb-4">
                  <div class="alert alert-info text-end">
                    <strong>Total Biaya Obat:</strong> Rp <?php echo e(number_format($totalObat, 0, ',', '.')); ?>

                  </div>
                </div>
              <?php endif; ?>
            </div>
            
            <!-- Lab Tab -->
            <div class="tab-pane fade" id="lab" role="tabpanel" aria-labelledby="lab-tab">
              <?php if($pemeriksaan_lab->isEmpty()): ?>
                <div class="alert alert-info">Tidak ada data pemeriksaan laboratorium</div>
              <?php else: ?>
                <div class="accordion" id="labAccordion">
                  <?php $groupedLab = $pemeriksaan_lab->groupBy('kd_jenis_prw'); ?>
                  <?php $__currentLoopData = $groupedLab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kd_jenis_prw => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="lab-heading-<?php echo e($loop->index); ?>">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#lab-collapse-<?php echo e($loop->index); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>" aria-controls="lab-collapse-<?php echo e($loop->index); ?>">
                        <?php echo e($nama_perawatan[$kd_jenis_prw] ?? 'Unknown Test'); ?>

                      </button>
                    </h2>
                    <div id="lab-collapse-<?php echo e($loop->index); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>" aria-labelledby="lab-heading-<?php echo e($loop->index); ?>" data-bs-parent="#labAccordion">
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
                              <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td><?php echo e($item->tgl_periksa); ?></td>
                                <td><?php echo e($item->jam); ?></td>
                                <td><?php echo e($pemeriksaan_template[$item->id_template] ?? ''); ?></td>
                                <td><?php echo e($item->nilai); ?></td>
                                <td><?php echo e($item->nilai_rujukan); ?></td>
                                <td><?php echo e($item->keterangan); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              <?php endif; ?>
            </div>
            
            <!-- Radiology Tab -->
            <div class="tab-pane fade" id="radiology" role="tabpanel" aria-labelledby="radiology-tab">
              <?php if($periksaRadiologi->isEmpty()): ?>
                <div class="alert alert-info">Tidak ada data pemeriksaan radiologi</div>
              <?php else: ?>
                <div class="accordion" id="radiologyAccordion">
                  <?php $__currentLoopData = $periksaRadiologi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="rad-heading-<?php echo e($index); ?>">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#rad-collapse-<?php echo e($index); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>" aria-controls="rad-collapse-<?php echo e($index); ?>">
                        <?php echo e($item->jnsPerawatanRadiologi->nm_perawatan ?? 'Unknown Radiology'); ?>

                      </button>
                    </h2>
                    <div id="rad-collapse-<?php echo e($index); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>" aria-labelledby="rad-heading-<?php echo e($index); ?>" data-bs-parent="#radiologyAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <p><strong>Tanggal:</strong> <?php echo e($item->tgl_periksa); ?></p>
                            <p><strong>Dokter:</strong> <?php echo e($item->dokter_perujuk); ?></p>
                            <p><strong>Petugas:</strong> <?php echo e($item->petugas->nama ?? ''); ?></p>
                          </div>
                          <div class="col-md-6">
                            <p><strong>Hasil:</strong></p>
                            <?php if(isset($hasilRadiologi[$index])): ?>
                              <p><?php echo e($hasilRadiologi[$index]->hasil); ?></p>
                            <?php else: ?>
                              <p>Hasil belum tersedia</p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php $__currentLoopData = $hasilRadiologi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($result->no_rawat); ?></td>
                              <td><?php echo e($result->tgl_periksa); ?></td>
                              <td><?php echo e($result->jam); ?></td>
                              <td><?php echo e($result->hasil); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                          <?php $__currentLoopData = $periksaRadiologi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><?php echo e($result->petugas->nama); ?></td>
                            <td><?php echo e($result->jnsPerawatanRadiologi->nm_perawatan); ?></td>
                            <td><?php echo e($result->tgl_periksa); ?></td>
                            <td><?php echo e($result->jam); ?></td>
                            <td><?php echo e($result->biaya); ?></td>
                            <td><?php echo e($result->kd_dokter); ?></td>
                            <td><?php echo e($result->status); ?></td>
                          </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
            
            <!-- Diagnosis Tab -->
            <div class="tab-pane fade" id="diagnosis" role="tabpanel" aria-labelledby="diagnosis-tab">
              <div class="row">
                <div class="col-md-6">
                  <h5>Diagnosa</h5>
                  <?php if($diagnosa->isEmpty()): ?>
                    <div class="alert alert-info">Tidak ada data diagnosa</div>
                  <?php else: ?>
                    <ul class="list-group">
                      <?php $__currentLoopData = $diagnosa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="list-group-item">
                        <strong><?php echo e($item->prioritas); ?>.</strong> 
                        <?php echo e($item->penyakit->nm_penyakit ?? ''); ?>

                        <span class="badge bg-primary"><?php echo e($item->status); ?></span>
                      </li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  <?php endif; ?>
                </div>
                <div class="col-md-6">
                  <h5>Prosedur</h5>
                  <?php if($prosedurPasien->isEmpty()): ?>
                    <div class="alert alert-info">Tidak ada data prosedur</div>
                  <?php else: ?>
                    <ul class="list-group">
                      <?php $__currentLoopData = $prosedurPasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="list-group-item">
                        <strong><?php echo e($item->prioritas); ?>.</strong> 
                        <?php echo e($item->icd9->deskripsi ?? ''); ?>

                        <span class="badge bg-success"><?php echo e($item->status); ?></span>
                      </li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  <?php endif; ?>
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
                        <?php $__currentLoopData = $diagnosa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($item->kd_penyakit); ?></td>
                          <td><?php echo e($item->penyakit->nm_penyakit); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Tambahkan Prosedur Pasien -->
              <?php if (! ($prosedurPasien->isEmpty())): ?>
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
                        <?php $__currentLoopData = $prosedurPasien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prosedur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($prosedur->kode); ?></td>
                          <td><?php echo e($prosedur->icd9->deskripsi_panjang); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php endif; ?>
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
                    <?php
                      $groupedTindakan = $tindakan->groupBy('tgl_perawatan');
                      $accordionIndex = 1;
                    ?>
                    <?php $__currentLoopData = $groupedTindakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanggal => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading-<?php echo e($accordionIndex); ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($accordionIndex); ?>" aria-expanded="true" aria-controls="collapse-<?php echo e($accordionIndex); ?>">
                          Tanggal: <?php echo e($tanggal); ?>

                        </button>
                      </h2>
                      <div id="collapse-<?php echo e($accordionIndex); ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo e($accordionIndex); ?>" data-bs-parent="#accordionExample">
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
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                  <td><?php echo e($item->jam_rawat); ?></td>
                                  <td><?php echo e($item->no_rawat); ?></td>
                                  <td><?php echo e($item->jenisPerawatan->nm_perawatan); ?></td>
                                  <td><?php echo e($item->dokter->nm_dokter); ?></td>
                                  <td><?php echo e($item->material); ?></td>
                                  <td><?php echo e($item->bhp); ?></td>
                                  <td><?php echo e($item->tarif_tindakandr); ?></td>
                                  <td><?php echo e($item->kso); ?></td>
                                  <td><?php echo e($item->menejemen); ?></td>
                                  <td><?php echo e($item->biaya_rawat); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                            </table>
                          </div>
                          <?php $totalTindakanDokter = $items->sum('biaya_rawat'); ?>
                          <div class="text-end mt-2">
                            <strong>Total Biaya Rawat (Dokter):</strong> Rp <?php echo e(number_format($totalTindakanDokter, 0, ',', '.')); ?>

                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                      $accordionIndex++;
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php
                      $groupedTindakanpr = $tindakanpr->groupBy('tgl_perawatan');
                      $accordionIndex = 1;
                    ?>
                    <?php $__currentLoopData = $groupedTindakanpr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanggal => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingpr-<?php echo e($accordionIndex); ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsepr-<?php echo e($accordionIndex); ?>" aria-expanded="true" aria-controls="collapsepr-<?php echo e($accordionIndex); ?>">
                          Tanggal: <?php echo e($tanggal); ?>

                        </button>
                      </h2>
                      <div id="collapsepr-<?php echo e($accordionIndex); ?>" class="accordion-collapse collapse" aria-labelledby="headingpr-<?php echo e($accordionIndex); ?>" data-bs-parent="#accordionExamplePerawat">
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
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                  <td><?php echo e($item->jam_rawat); ?></td>
                                  <td><?php echo e($item->no_rawat); ?></td>
                                  <td><?php echo e($item->jenisPerawatan->nm_perawatan); ?></td>
                                  <td><?php echo e($item->petugas->nama); ?></td>
                                  <td><?php echo e($item->material); ?></td>
                                  <td><?php echo e($item->bhp); ?></td>
                                  <td><?php echo e($item->tarif_tindakandr); ?></td>
                                  <td><?php echo e($item->kso); ?></td>
                                  <td><?php echo e($item->menejemen); ?></td>
                                  <td><?php echo e($item->biaya_rawat); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                            </table>
                          </div>
                          <?php $totalTindakanPerawat = $items->sum('biaya_rawat'); ?>
                          <div class="text-end mt-2">
                            <strong>Total Biaya Rawat (Perawat):</strong> Rp <?php echo e(number_format($totalTindakanPerawat, 0, ',', '.')); ?>

                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                      $accordionIndex++;
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>
              </div>
              <!-- Total Biaya Tindakan -->
              <?php
                $totalTindakan = $tindakan->sum('biaya_rawat') + $tindakanpr->sum('biaya_rawat');
              ?>
              <div class="col-12 mt-2 mb-4">
                <div class="alert alert-info text-end">
                  <strong>Total Biaya Tindakan:</strong> Rp <?php echo e(number_format($totalTindakan, 0, ',', '.')); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/kamar_inap/riwayatpasien.blade.php ENDPATH**/ ?>