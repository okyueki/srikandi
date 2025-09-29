<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Styles untuk menyesuaikan dengan template Valex -->
<style>
    .discharge-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }
    .discharge-header {
        border-bottom: 2px solid #5e72e4;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .discharge-title {
        color: #5e72e4;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .section-title {
        color: #5e72e4;
        font-weight: 600;
        border-bottom: 1px dashed #dee2e6;
        padding-bottom: 10px;
        margin-top: 25px;
        margin-bottom: 20px;
    }
    .diagnosis-box {
        background-color: #f8f9fe;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .medication-table th {
        background-color: #5e72e4;
        color: white;
    }
    .monitoring-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f2f8;
    }
    .monitoring-item:last-child {
        border-bottom: none;
    }
    .option-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 8px;
    }
    .option-label {
        background-color: #f0f2f8;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
    .form-control-custom {
        border: 1px solid #e9ecef;
        border-radius: 4px;
        padding: 8px 12px;
        width: 100%;
    }
</style>
<form method="POST" action="<?php echo e(route('discharge-note.store')); ?>">
    <?php echo csrf_field(); ?>
<div class="discharge-container">
    <!-- Header -->
    <div class="discharge-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="discharge-title">Asuhan Pasien Pasca Rawat Inap</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
            <div class="form-group">
                <label>Nama Pasien</label>
                <input type="text" class="form-control" name="nm_pasien" placeholder="Nama Pasien" value="<?php echo e($kamarinap->regPeriksa->pasien->nm_pasien ?? '-'); ?>" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>No Rawat</label>
                <input type="text" class="form-control" name="no_rawat" placeholder="Nomor Rawat" value="<?php echo e($kamarinap->regPeriksa->no_rawat ?? '-'); ?>" readonly>
            </div>
        </div>

    <!--- Informasi Umum -->
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" class="form-control" name="tgl_masuk" value="<?php echo e($asuhan->tgl_masuk ?? '-'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tanggal Pulang</label>
                <input type="date" class="form-control" name="tgl_keluar" value="<?php echo e($asuhan->tgl_keluar ?? '-'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Kondisi Saat Pulang</label>
                <input type="text" class="form-control" name="kondisi_pulang" placeholder="Kondisi pasien" value="<?php echo e($asuhan->kondisi_pulang ?? '-'); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Dokter Yang Merawat</label>
                  <select class="form-control" name="kd_dokter">
                    <option value="">-- Pilih Dokter --</option>
                    <?php $__currentLoopData = $dokter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->kd_dokter); ?>" 
                            <?php echo e((isset($asuhan) && $asuhan->kd_dokter == $item->kd_dokter) ? 'selected' : ''); ?>>
                            <?php echo e($item->nm_dokter); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Diagnosis -->
    <h4 class="section-title">Diagnosa</h4>
    <div class="row">
        <div class="col-md-5">
            <div class="diagnosis-box">
                <h5>Diagnosa Masuk</h5>
                <textarea class="form-control" rows="3" name="diagnosa_awal" placeholder="Masukkan diagnosis saat masuk"><?php echo e($kamarinap->diagnosa_awal ?? '-'); ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="diagnosis-box">
                <h5>Diagnosa Pulang</h5>
                <textarea class="form-control" rows="3" name="diagnosa_akhir" placeholder="Masukkan diagnosis saat pulang"><?php echo e($asuhan->diagnosa_akhir ?? '-'); ?></textarea>
            </div>
        </div>
    </div>

    <!-- Tindakan di RS -->
    <h4 class="section-title">Tindakan Yang Diberikan Di RS Serta Indikasinya</h4>
    <div class="row">
        <div class="col-md-6">
           <input type="hidden" id="no-rawat-hidden" value="<?php echo e($no_rawat); ?>">

<table class="table table-bordered" id="tindakan-table">
    <thead>
        <tr>
            <th>*</th>
            <th>Tindakan</th>
            <th>Tanggal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="tbody-tindakan">
        <tr>
            <td><button id="add-btn" class="btn btn-success"><i class="far fa-plus"></i></button></td>
            <td><textarea id="input-tindakan" class="form-control" rows="2" placeholder="Tindakan..."></textarea></td>
            <td><input type="date" id="input-tanggal" class="form-control"></td>
            <td></td>
        </tr>

        <?php $__currentLoopData = $tindakan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr id="row-<?php echo e($row->id_tindakan); ?>">
            <td>#<?php echo e($loop->iteration); ?></td>
            <td><textarea class="form-control tindakan-text" data-id="<?php echo e($row->id_tindakan); ?>"><?php echo e($row->tindakan); ?></textarea></td>
            <td><input type="date" class="form-control tanggal-input" data-id="<?php echo e($row->id_tindakan); ?>" value="<?php echo e($row->tanggal); ?>"></td>
            <td>
                <button class="btn btn-warning edit-btn" data-id="<?php echo e($row->id_tindakan); ?>"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger delete-btn" data-id="<?php echo e($row->id_tindakan); ?>"><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

        </div>
    </div>

    <!-- Pengobatan -->
    <h4 class="section-title">Pengobatan Yang Diberikan</h4>
    <div class="table-responsive">
    <table class="table table-bordered medication-table" id="obat-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Cara Pakai</th>
                <th>Frekuensi</th>
                <th>Fungsi Obat</th>
                <th>Dosis Terakhir</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="obat-body">
            <?php $__currentLoopData = $obat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr data-id="<?php echo e($row->id_obat); ?>">
                <td><?php echo e($loop->iteration); ?></td>
                <td><input type="text" class="form-control nama_obat" value="<?php echo e($row->nama_obat); ?>"></td>
                <td><input type="text" class="form-control dosis" value="<?php echo e($row->dosis); ?>"></td>
                <td><input type="text" class="form-control cara_pakai" value="<?php echo e($row->cara_pakai); ?>"></td>
                <td><input type="text" class="form-control frekuensi" value="<?php echo e($row->frekuensi); ?>"></td>
                <td><input type="text" class="form-control fungsi_obat" value="<?php echo e($row->fungsi_obat); ?>"></td>
                <td><input type="text" class="form-control dosis_terakhir" value="<?php echo e($row->dosis_terakhir); ?>"></td>
                <td><input type="text" class="form-control keterangan" value="<?php echo e($row->keterangan); ?>"></td>
                <td>
                    <button class="btn btn-success ubah-obat" data-id="<?php echo e($row->id_obat); ?>"><i class="fas fas fa-edit"></i></button>
                    <button class="btn btn-danger delete-obat" data-id="<?php echo e($row->id_obat); ?>"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- Tambahkan baris kosong untuk input baru -->
            <tr>
                <td><button class="btn btn-success" id="add-obat"><i class="fas fa-plus"></i></button></td>
                <td><input type="text" class="form-control" id="new-nama_obat"></td>
                <td><input type="text" class="form-control" id="new-dosis"></td>
                <td><input type="text" class="form-control" id="new-cara_pakai"></td>
                <td><input type="text" class="form-control" id="new-frekuensi"></td>
                <td><input type="text" class="form-control" id="new-fungsi_obat"></td>
                <td><input type="text" class="form-control" id="new-dosis_terakhir"></td>
                <td><input type="text" class="form-control" id="new-keterangan"></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>


    <!-- Pemantauan -->
    <h4 class="section-title">PEMANTAUAN YANG DIPERLUKAN</h4>
    
    <!-- Item 1: Kecukupan tidur -->
    <div class="monitoring-item">
        <h6>Kecukupan tidur dan kelelahan umum</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Total waktu tidur</label>
                    <input type="text" class="form-control" name="total_waktu_tidur" placeholder=".... jam/24 jam" value="<?php echo e($asuhan->total_waktu_tidur ?? '-'); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kualitas tidur</label>
                   <div class="option-group">
                    <span class="option-label">
                        <input type="radio" value="Nyenyak" name="kualitas_tidur"
                            <?php echo e(old('kualitas_tidur', $asuhan->kualitas_tidur ?? '') == 'Nyenyak' ? 'checked' : ''); ?>>
                        Nyenyak
                    </span>
                    <span class="option-label">
                        <input type="radio" value="Kurang nyenyak" name="kualitas_tidur"
                            <?php echo e(old('kualitas_tidur', $asuhan->kualitas_tidur ?? '') == 'Kurang nyenyak' ? 'checked' : ''); ?>>
                        Kurang nyenyak
                    </span>
                    <span class="option-label">
                        <input type="radio" value="Tidak nyenyak" name="kualitas_tidur"
                            <?php echo e(old('kualitas_tidur', $asuhan->kualitas_tidur ?? '') == 'Tidak nyenyak' ? 'checked' : ''); ?>>
                        Tidak nyenyak
                    </span>
                </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Makan</label>
            <input type="text" class="form-control" name="kalori_makan" placeholder="....... Kal/hari" value="<?php echo e($asuhan->kalori_makan ?? '-'); ?>">
        </div>
    </div>

    <!-- Item 2: Mood -->
    <div class="monitoring-item">
        <h6>Mood dan kesehatan mental</h6>
        <div class="form-group">
            <label>Waktu luang</label>
           <div class="option-group">
    <span class="option-label">
        <input type="radio" value="Tidak Ada" name="waktu_luang"
            <?php echo e(old('waktu_luang', $asuhan->waktu_luang ?? '') == 'Tidak Ada' ? 'checked' : ''); ?>>
        Tidak ada sama sekali
    </span>
    <span class="option-label">
        <input type="radio" value="Sangat Sedikit" name="waktu_luang"
            <?php echo e(old('waktu_luang', $asuhan->waktu_luang ?? '') == 'Sangat Sedikit' ? 'checked' : ''); ?>>
        Sangat sedikit
    </span>
    <span class="option-label">
        <input type="radio" value="Cukup" name="waktu_luang"
            <?php echo e(old('waktu_luang', $asuhan->waktu_luang ?? '') == 'Cukup' ? 'checked' : ''); ?>>
        Cukup
    </span>
</div>
        </div>
        <div class="form-group">
            <label>Aktivitas di waktu luang</label>
           <div class="option-group">
    <span class="option-label">
        <input type="checkbox" name="aktifitas_luang[]" value="Menonton TV"
            <?php echo e(in_array('Menonton TV', old('aktifitas_luang', $aktifitas_luang ?? [])) ? 'checked' : ''); ?>>
        Menonton TV
    </span>
    <span class="option-label">
        <input type="checkbox" name="aktifitas_luang[]" value="Membaca"
            <?php echo e(in_array('Membaca', old('aktifitas_luang', $aktifitas_luang ?? [])) ? 'checked' : ''); ?>>
        Membaca
    </span>
    <span class="option-label">
        <input type="checkbox" name="aktifitas_luang[]" value="Ngobrol"
            <?php echo e(in_array('Ngobrol', old('aktifitas_luang', $aktifitas_luang ?? [])) ? 'checked' : ''); ?>>
        Ngobrol
    </span>
    <span class="option-label">
        <input type="checkbox" name="aktifitas_luang[]" value="Lainnya"
            <?php echo e(in_array('Lainnya', old('aktifitas_luang', $aktifitas_luang ?? [])) ? 'checked' : ''); ?>>
        Lainnya
    </span>
</div>
        </div>
        <div class="form-group">
            <label>Catatan Khusus</label>
            <textarea class="form-control" name="catatan_khusus" rows="2" placeholder="Catatan khusus"><?php echo e($asuhan->catatan_khusus ?? '-'); ?></textarea>
        </div>
    </div>

    <!-- Item 3-7: Singkat -->
    <div class="monitoring-item">
        <h6>Kebutuhan Nutrisi</h6>
        <input type="text" class="form-control"  name="nutrisi_makan" placeholder="Makan" value="<?php echo e($asuhan->catatan_khusus ?? '-'); ?>">
    </div>
    
    <div class="monitoring-item">
        <h6>Minum</h6>
        <input type="text" class="form-control"name="nutrisi_minum" placeholder="Minum" value="<?php echo e($asuhan->nutrisi_minum ?? '-'); ?>">
    </div>
    
    <div class="monitoring-item">
        <h6>Kebutuhan Aktivitas</h6>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Duduk</label>
                    <select class="form-control" name="duduk">
                         <option value="Mandiri" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Mandiri' ? 'selected' : ''); ?>>Mandiri</option>
    <option value="Sebagian" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Sebagian' ? 'selected' : ''); ?>>Sebagian</option>
    <option value="Total" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Total' ? 'selected' : ''); ?>>Total</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Berdiri</label>
                    <select class="form-control" name="berdiri">
                         <option value="Mandiri" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Mandiri' ? 'selected' : ''); ?>>Mandiri</option>
    <option value="Sebagian" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Sebagian' ? 'selected' : ''); ?>>Sebagian</option>
    <option value="Total" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Total' ? 'selected' : ''); ?>>Total</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Bergerak</label>
                    <select class="form-control" name="bergerak">
                        <option value="Mandiri" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Mandiri' ? 'selected' : ''); ?>>Mandiri</option>
    <option value="Sebagian" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Sebagian' ? 'selected' : ''); ?>>Sebagian</option>
    <option value="Total" <?php echo e(old('duduk', $asuhan->duduk ?? '') == 'Total' ? 'selected' : ''); ?>>Total</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <div class="monitoring-item">
        <h6>Kebutuhan Eliminasi (BAK)</h6>
        <input type="text" class="form-control" name="bak" placeholder="BAK"  value="<?php echo e($asuhan->bak ?? '-'); ?>">
    </div>
    
    <div class="monitoring-item">
        <h6>Kebutuhan Eliminasi (BAB)</h6>
        <input type="text" class="form-control" name="bab" placeholder="BAB" value="<?php echo e($asuhan->bab ?? '-'); ?>">
    </div>

    <!-- Item 8: Perawatan khusus -->
    <div class="monitoring-item">
        <h6>Perawatan Khusus di Rumah</h6>
        <div class="form-group">
            <label>Luka operasi</label>
            <?php
    $luka_operasi = isset($asuhan) && $asuhan->luka_operasi ? json_decode($asuhan->luka_operasi, true) : [];
?>
<div class="option-group">
    <?php $__currentLoopData = [
        'Masih tertutup kasa', 'Terbuka', 'Normal', 'Nyeri', 'Ringan',
        'Sedang', 'Berat', 'Merah', 'Bengkak', 'Basah', 'Bernanah'
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="option-label">
            <input type="checkbox" name="luka_operasi[]" value="<?php echo e($item); ?>"
                <?php echo e(in_array($item, $luka_operasi) ? 'checked' : ''); ?>> <?php echo e($item); ?>

        </span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
        </div>
    </div>

    <!-- Item 9-14: Perawatan Ibu/Bayi -->
    <div class="monitoring-item">
        <h6>Perawatan Ibu/Bayi dan Menyusui</h6>
        <textarea class="form-control" rows="2" name="deskripsi_perawatan" placeholder="Deskripsi perawatan"><?php echo e($asuhan->deskripsi_perawatan ?? '-'); ?></textarea>
    </div>
    
    <div class="monitoring-item">
        <h6>Keluarga yang membantu</h6>
        <div class="form-group">
           <div class="option-group">
                <?php
                    $keluarga = isset($asuhan) && $asuhan->keluarga ? json_decode($asuhan->keluarga, true) : [];
                ?>
            
                <?php $__currentLoopData = ['Suami', 'Ibu', 'Ayah', 'Kakak', 'Adik', 'Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="option-label">
                        <input type="checkbox" name="keluarga[]" value="<?php echo e($item); ?>" 
                            <?php echo e(in_array($item, $keluarga) ? 'checked' : ''); ?>> <?php echo e($item); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="form-group">
            <label>Bantuan yang sering dibutuhkan saat</label>
            <div class="option-group">
                <?php
                    $bantuan = isset($asuhan) && $asuhan->batuan_dibutuhkan ? json_decode($asuhan->batuan_dibutuhkan, true) : [];
                ?>
            
                <?php $__currentLoopData = ['Pagi', 'Siang', 'Malam']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waktu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="option-label">
                        <input type="checkbox" name="batuan_dibutuhkan[]" value="<?php echo e($waktu); ?>"
                            <?php echo e(in_array($waktu, $bantuan) ? 'checked' : ''); ?>> <?php echo e($waktu); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    
    <div class="monitoring-item">
        <h6>Bayi menyusui</h6>
        <div class="option-group">
            <?php
                $bayi_menyusui = $asuhan->bayi_menyusui ?? '';
            ?>
        
            <?php $__currentLoopData = ['Sangat baik', 'Cukup baik', 'Kesulitan menetek', 'Rewel', 'Malas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="option-label">
                    <input type="radio" name="bayi_menyusui" value="<?php echo e($value); ?>"
                        <?php echo e($bayi_menyusui === $value ? 'checked' : ''); ?>> <?php echo e($value); ?>

                </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    
    <div class="monitoring-item">
        <h6>Tali pusat bayi</h6>
       <?php
    $taliPusat = is_array($asuhan->tali_pusat_bayi ?? null)
        ? $asuhan->tali_pusat_bayi
        : json_decode($asuhan->tali_pusat_bayi ?? '[]', true);
?>

<div class="option-group">
    <?php $__currentLoopData = [
        'Berbau', 'Bernanah', 'Kering', 'Basah', 'Puput',
        'Belum puput', 'Dinding perut kemerahan'
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="option-label">
            <input type="checkbox" name="tali_pusat_bayi[]" value="<?php echo e($value); ?>"
                <?php echo e(in_array($value, $taliPusat) ? 'checked' : ''); ?>> <?php echo e($value); ?>

        </span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
    </div>
    
    <div class="monitoring-item">
        <h6>BAB Bayi</h6>
       <?php
    $babBayi = $asuhan->bab_bayi ?? '';
?>

<div class="option-group">
    <?php $__currentLoopData = ['Sangat sering', 'Sering', 'Jarang', 'Tidak', 'Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="option-label">
            <input type="radio" name="bab_bayi" value="<?php echo e($value); ?>"
                <?php echo e($babBayi === $value ? 'checked' : ''); ?>> <?php echo e($value); ?>

        </span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
    </div>
    
    <div class="monitoring-item">
        <h6>BAK Bayi</h6>
        <?php
    $bakBayi = $asuhan->bak_bayi ?? '';
?>

<div class="option-group">
    <?php $__currentLoopData = ['Sangat sering', 'Sering', 'Jarang', 'Tidak', 'Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="option-label">
            <input type="radio" name="bak_bayi" value="<?php echo e($value); ?>"
                <?php echo e($bakBayi === $value ? 'checked' : ''); ?>> <?php echo e($value); ?>

        </span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
    </div>

    <!-- Item 15-18: Kesehatan fisik -->
    <div class="monitoring-item">
        <h6>Kesehatan fisik (Dewasa)</h6>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Kondisi umum</label>
                    <select class="form-control" name="kesehatan_umum">
                       <?php
    $options = ['Baik', 'Sedang', 'Buruk'];
    $kesehatanUmum = $asuhan->kesehatan_umum ?? '';
?>


    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($value); ?>" <?php echo e($kesehatanUmum === $value ? 'selected' : ''); ?>><?php echo e($value); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tensi</label>
                    <input type="text" class="form-control" name="tensi" placeholder="Tensi" value="<?php echo e($asuhan->tensi ?? '-'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>RR</label>
                    <input type="text" class="form-control" name="rr" placeholder="RR" value="<?php echo e($asuhan->rr ?? '-'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>SPO2</label>
                    <input type="text" class="form-control" name="spo2" placeholder="SPO2" value="<?php echo e($asuhan->rr ?? '-'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Temp</label>
                    <input type="text" class="form-control" name="temp" placeholder="Suhu Badan" value="<?php echo e($asuhan->rr ?? '-'); ?>">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Item 16-18: Kesehatan fisik lainnya (disingkat) -->
    <div class="monitoring-item">
        <h6>Kesehatan fisik (Anak, Bayi)</h6>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Anak - Kondisi</label>
                    <select class="form-control" name="anak_kondsi">
                      <?php
    $options = ['Baik', 'Sedang', 'Buruk'];
    $kesehatanAnak = $asuhan->anak_kondsi ?? '';
?>


    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($value); ?>" <?php echo e($kesehatanAnak === $value ? 'selected' : ''); ?>><?php echo e($value); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Bayi - Kondisi</label>
                    <select class="form-control" name="bayi_kondisi">
                        <?php
    $options = ['Baik', 'Sedang', 'Buruk'];
    $bayiKondisi = $asuhan->bayi_kondisi ?? '';
?>

    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($value); ?>" <?php echo e($bayiKondisi === $value ? 'selected' : ''); ?>><?php echo e($value); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Item 19-22: Perawatan pasca persalinan -->
    <div class="monitoring-item">
        <h6>Perawatan Pasca Persalinan</h6>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tinggi fundus uteri</label>
                    <input type="text" class="form-control" name="tinggi_fundus_uteri" placeholder="...... cm" value="<?php echo e($asuhan->tinggi_fundus_uteri ?? '-'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Kontraksi rahim</label>
                    <input type="text" class="form-control" name="kontraksi_rahim" placeholder="...... x/menit" value="<?php echo e($asuhan->kontraksi_rahim ?? '-'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengeluaran pervagina</label>
                    <input type="text" class="form-control" name="pengeluaran_pravagina" placeholder="...... cc" value="<?php echo e($asuhan->pengeluaran_pravagina ?? '-'); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Lochea (warna cairan yang keluar)</label>
            <input type="text" class="form-control" name="lochea" placeholder="Deskripsi warna" value="<?php echo e($asuhan->lochea ?? '-'); ?>">
        </div>
    </div>
    
    <div class="monitoring-item">
        <h6>Luka operasi</h6>
        <?php
    $selected = isset($asuhan->luka_opera_bersalin) ? json_decode($asuhan->luka_opera_bersalin, true) : [];
?>

<div class="option-group">
    <?php $__currentLoopData = ['Masih tertutup kasa', 'Terbuka', 'Normal', 'Nyeri', 'Ringan', 'Sedang', 'Berat', 'Merah', 'Bengkak', 'Basah', 'Bernanah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="option-label">
            <input type="checkbox" name="luka_opera_bersalin[]" value="<?php echo e($value); ?>" 
                <?php echo e(in_array($value, $selected) ? 'checked' : ''); ?>>
            <?php echo e($value); ?>

        </span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
    </div>
    
    <div class="monitoring-item">
        <h6>Luka Perineum</h6>
       <?php
    $lukaPerineum = $asuhan->luka_perineum ?? '';
?>

<div class="option-group">
    <?php $__currentLoopData = ['Bersih', 'Kotor', 'Bengkak', 'Berdarah', 'Terbuka']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="option-label">
            <input type="radio" name="luka_perineum" value="<?php echo e($value); ?>"
                <?php echo e($lukaPerineum === $value ? 'checked' : ''); ?>>
            <?php echo e($value); ?>

        </span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
    </div>
    
    <div class="monitoring-item">
        <h6>Lain - Lain Catatan Khusus jika terdapat kondisi tertentu</h6>
        <textarea class="form-control" rows="3" name="catatan_tambahan" placeholder="Catatan tambahan"><?php echo e($asuhan->catatan_tambahan ?? '-'); ?></textarea>
    </div>

    <!-- Tombol Simpan -->
    <div class="text-right mt-4">
        <button class="btn btn-primary" type="submit">Simpan Discharge Note</button>
    </div>
    </form>
    <br>
    <div class="row">
        <div class="col-md-12">
           <input type="hidden" id="no-rawat-hidden" value="<?php echo e($no_rawat); ?>">

        <table class="table table-bordered" id="tindakan-table">
            <thead>
                <tr>
                    <th>No Rawat</th>
                    <th>Nama Pasien</th>
                    <th>No. RM</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo e($asuhan->no_rawat ?? ''); ?></td>
                    <td><?php echo e($asuhan->regPeriksa->pasien->nm_pasien ?? ''); ?></td>
                    <td><?php echo e($asuhan->regPeriksa->no_rkm_medis ?? ''); ?></td>
                    <td>
                       <?php if($asuhan): ?>
                       
                        <form action="<?php echo e(route('discharge-note.destroy', $no_rawat)); ?>" method="POST" onsubmit="return confirm('Yakin ingin hapus?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                             <a href="<?php echo e(route('discharge-note.show', $asuhan->id)); ?>" class="btn btn-sm btn-primary">Lihat</a>                      

                            <a href="<?php echo e(route('discharge-note.edit', $no_rawat)); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/pages/discharge-note.blade.php ENDPATH**/ ?>