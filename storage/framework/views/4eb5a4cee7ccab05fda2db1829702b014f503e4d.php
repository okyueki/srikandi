<?php $__env->startSection('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title); ?>

<?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Detail Surat Keluar</span>    
                                </a>
                             </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">PDF</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#lampiran" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Lampiran</span>    
                                </a>
                            </li>           
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ol class="list-group list-group-numbered">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Nomor Surat</div>
                                                    <?php echo e($surat->nomor_surat); ?>

                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Perihal Surat</div>
                                                    <?php echo e($surat->perihal); ?>

                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Pengirim</div>
                                                    <?php if($surat->nik_pengirim==""): ?>
                                                        <?php echo e($surat->pengirim_external); ?>

                                                    <?php else: ?>
                                                        <?php echo e($surat->pegawai->nama); ?>

                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Sifat</div>
                                                    <?php echo e($surat->sifat_surat->nama_sifat_surat); ?>

                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Tanggal Surat</div>
                                                    <?php echo e($tanggalSurat); ?>

                                                </div>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="col-lg-6">
                                        <ol class="list-group list-group-numbered">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Verifikasi</div>
                                                    <ul>
                                                        <?php $__currentLoopData = $verifikasiSurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                        <span style="font-size: 14px;" class="badge 
                                                                    <?php if($vS->status_surat == 'Dikirim'): ?> bg-warning
                                                                    <?php elseif($vS->status_surat == 'Dibaca'): ?> bg-success 
                                                                    <?php elseif($vS->status_surat == 'Disetujui'): ?> bg-success 
                                                                    <?php elseif($vS->status_surat == 'Ditolak'): ?> bg-danger 
                                                                    <?php endif; ?>">
                                                                    <?php echo e($vS->status_surat); ?>

                                                                </span>
                                                        <?php echo e($vS->pegawai->nama); ?> <?php echo e($vS->tanggal_verifikasi); ?>

                                                        <p><span style="font-weight: 900;">Catatan : </span><?php echo e($vS->catatan ?? 'Tidak Ada Catatan'); ?></p>
                                                        </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Disposisi</div>
                                                    <ul>
                                                        <?php $__currentLoopData = $disposisiAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                        <span style="font-size: 14px;" class="badge 
                                                                    <?php if($dA->status_disposisi == 'Dikirim'): ?> bg-warning
                                                                    <?php elseif($dA->status_disposisi == 'Dibaca'): ?> bg-success 
                                                                    <?php elseif($dA->status_disposisi == 'Ditindaklanjuti'): ?> bg-success 
                                                                    <?php elseif($dA->status_disposisi == 'Selesai'): ?> bg-success 
                                                                    <?php endif; ?>">
                                                                    <?php echo e($dA->status_disposisi); ?>

                                                                </span>
                                                        <?php echo e($dA->pegawai2->nama); ?> <?php echo e($dA->tanggal_disposisi); ?>

                                                        <p><span style="font-weight: 900;">Catatan : </span><?php echo e($dA->catatan_disposisi ?? 'Tidak Ada Catatan'); ?></p>
                                                        </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="col-lg-12">
                                    <form action="<?php echo e(route('surat_masuk.verifikasidisposisiProses', $surat->verifikasi->id_verifikasi_surat)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-group">
        <label for="status_surat">Status Verifikasi</label>
        <select name="status_surat" class="form-control" id="status_surat" required>
            <option value="Disetujui" <?php echo e($surat->verifikasi->status_surat == 'Disetujui' ? 'selected' : ''); ?>>Disetujui</option>
            <option value="Ditolak" <?php echo e($surat->verifikasi->status_surat == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
        </select>
    </div>
    
    <div class="form-group" id="NikAtasanLangsung" style="display: none;">
    <label for="nik_atasan_langsung">Pilih Atasan Langsung:</label>
    <select name="nik_atasan_langsung" id="nik_atasan_langsung" class="form-control">
        <option value="">-- Pilih Atasan Langsung --</option>
        <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

    <div class="form-group">
        <label for="catatan">Catatan</label>
        <textarea class="form-control" name="catatan" id="catatan" rows="3"><?php echo e(old('catatan', $surat->verifikasi->catatan)); ?></textarea>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="CheckDisposisi">
        <label class="form-check-label" for="CheckDisposisi">Disposisi</label>
    </div>

    <!-- Hidden input untuk mengirimkan nilai checkbox -->
    <input type="hidden" name="is_disposisi" id="is_disposisi" value="0">

    <div class="form-group" id="NikDisposisi" style="display: none;">
        <label for="nik_penerima">Disposisi Ke:</label>
        <select name="nik_penerima[]" id="nik_penerima" class="form-control" multiple>
            <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->nik); ?>"><?php echo e($p->nama); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group" id="CatatanDisposisi" style="display: none;">
        <label for="catatan_disposisi">Catatan Disposisi</label>
        <textarea class="form-control" name="catatan_disposisi" id="catatan_disposisi" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Kirim</button>
</form>
                                    </div>
                                </div>
                            </div>
                             <!-- Tab 2: PDF Viewer -->
                    <div class="tab-pane" id="profile" role="tabpanel">
                        <!-- Embed PDF.js Viewer -->
                        <iframe src="<?php echo e(asset('assets/libs/pdfjs/web/viewer.html?file=' . urlencode($pdfUrl). '?v=' . time())); ?>" width="100%" height="600px"></iframe>

                    </div>

                    <!-- Tab 3: Lampiran -->
                    <div class="tab-pane" id="lampiran" role="tabpanel">
                        <?php if(!empty($surat->file_lampiran)): ?>
    <?php
        $fileName = basename($surat->file_lampiran);
        $viewerURL = asset('assets/libs/pdfjs/web/viewer.html') . '?file=' . urlencode(route('surat_masuk.show', $fileName)) . '&v=' . time();
        $downloadURL = Storage::url($surat->file_lampiran);
    ?>

    <iframe src="<?php echo e($viewerURL); ?>" width="100%" height="600px"></iframe>

    <p class="text-center mt-3">
        <a href="<?php echo e($downloadURL); ?>" class="btn btn-primary" download>Download PDF</a>
    </p>
<?php else: ?>
    <h4 class="text-center">Tidak Ada Lampiran</h4>
<?php endif; ?>
                    </div>
                        </div>                                  
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('nik_atasan_langsung');
            const choices = new Choices(element, {
                allowHTML: true,
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'top', // Display dropdown below the element
                shouldSort: false, // Avoid sorting if not necessary
                removeItemButton: true, // Allows users to remove selected items
            });
        });
         document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('nik_penerima');
            const choices = new Choices(element, {
                allowHTML: true,
                placeholderValue: 'Search Pegawai...',
                searchEnabled: true,
                position: 'top', // Menampilkan dropdown di bawah elemen
                shouldSort: false, // Menghindari pengurutan jika tidak diperlukan
            });

        });
       document.addEventListener('DOMContentLoaded', function () {
            const checkDisposisi = document.getElementById('CheckDisposisi');
            const NikAtasanLangsung = document.getElementById('NikAtasanLangsung');
            const isDisposisi = document.getElementById('is_disposisi');
            const nikDisposisi = document.getElementById('NikDisposisi');
            const catatanDisposisi = document.getElementById('CatatanDisposisi');
        
            function toggleDisposisiFields() {
                if (checkDisposisi.checked) {
                    isDisposisi.value = 1; // Checkbox dicentang
                    nikDisposisi.style.display = 'block';
                    NikAtasanLangsung.style.display = 'none';
                    catatanDisposisi.style.display = 'block';
                } else {
                    isDisposisi.value = 0; // Checkbox tidak dicentang
                    nikDisposisi.style.display = 'none';
                    NikAtasanLangsung.style.display = 'block';
                    catatanDisposisi.style.display = 'none';
                }
            }
        
            // Jalankan fungsi saat halaman dimuat dan ketika checkbox berubah
            toggleDisposisiFields();
            checkDisposisi.addEventListener('change', toggleDisposisiFields);
        });
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pages-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/srikandi.rsaisyiyahsitifatimah.com/srikandi/resources/views/surat_masuk/verifikasidisposisi.blade.php ENDPATH**/ ?>