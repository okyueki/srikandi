@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Tambah Penilaian Harian')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Penilaian Harian</h3>
                    </div>
                    @if ($errors->has('pegawai_id'))
                        <div class="alert alert-danger">{{ $errors->first('pegawai_id') }}</div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('penilaian.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3 position-relative">
                                <label for="pegawai_id" class="form-label">Pegawai</label>
                                <div class="input-icon mb-3">
                                    <input type="text" id="pegawai_search" class="form-control" placeholder="Cari pegawai..." onkeyup="searchPegawai()">
                                    <span class="input-icon-addon">
                                        <div class="spinner-border spinner-border-sm text-secondary" id="loading_spinner" role="status" style="display: none;"></div>
                                    </span>
                                </div>
                                <div id="pegawai_list" class="list-group position-absolute w-100 bg-white border border-1" style="max-height: 200px; overflow-y: auto; z-index: 1000; display: none;"></div>
                                <input type="hidden" name="pegawai_id" id="pegawai_id">
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="departemen" class="form-label">Departemen</label>
                                <input type="text" id="departemen" class="form-control" readonly>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="jbtn" class="form-label">Jabatan</label>
                                <input type="text" id="jbtn" class="form-control" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                                <input type="date" name="tanggal_penilaian" id="tanggal_penilaian" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="waktu_penilaian" class="form-label">Waktu Penilaian</label>
                                <select name="waktu_penilaian" id="waktu_penilaian" class="form-control" required>
                                    <option value="pagi">Pagi</option>
                                    <option value="sore">Sore</option>
                                </select>
                            </div>
                            <!-- Item Penilaian Section -->
                            <div class="form-group">
                                <label for="item_penilaian" class="form-label">Item Penilaian</label>
                                @foreach ($items as $item)
                                    <div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span>{{ $item->nama_item }}</span>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input item-penilaian" name="item_penilaian[{{ $item->id }}]" value="1" id="item_{{ $item->id }}_ya" data-group="item_{{ $item->id }}" checked>
                                            <label class="form-check-label" for="item_{{ $item->id }}_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input item-penilaian" name="item_penilaian[{{ $item->id }}]" value="0" id="item_{{ $item->id }}_tidak" data-group="item_{{ $item->id }}">
                                            <label class="form-check-label" for="item_{{ $item->id }}_tidak">Tidak</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function searchPegawai() {
        const query = document.getElementById('pegawai_search').value;
        const list = document.getElementById('pegawai_list');
        const loadingSpinner = document.getElementById('loading_spinner');

        if (query.length > 2) {
            loadingSpinner.style.display = 'block';
            fetch(`/search-pegawai?query=${query}`)
    .then(response => response.json())
    .then(data => {
        list.innerHTML = '';
        if (data.length > 0) {
            list.style.display = 'block';
            data.forEach(pegawai => {
                const item = document.createElement('a');
                item.href = "#";
                item.className = "list-group-item list-group-item-action";
                item.innerText = `${pegawai.nama} - ${pegawai.departemen} (${pegawai.jbtn})`;
                item.onclick = function(event) {
                    event.preventDefault();
                    selectPegawai(pegawai.id, pegawai.nama, pegawai.departemen, pegawai.jbtn);
                };
                list.appendChild(item);
            });
        } else {
            list.style.display = 'none';
        }
        loadingSpinner.style.display = 'none';
    })
    .catch(error => {
        console.error('Error:', error);
        loadingSpinner.style.display = 'none';
    });

        } else {
            list.innerHTML = '';
            list.style.display = 'none';
        }
    }

    function selectPegawai(id, nama, departemen, jbtn) {
    document.getElementById('pegawai_search').value = nama;
    document.getElementById('pegawai_id').value = id;
    document.getElementById('departemen').value = departemen;
    document.getElementById('jbtn').value = jbtn;
    document.getElementById('pegawai_list').style.display = 'none';
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toLocaleDateString('en-CA'); // Use en-CA to format as yyyy-mm-dd
    document.getElementById('tanggal_penilaian').value = today;
});
</script>
<script>
document.querySelectorAll('.item-penilaian').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const group = this.getAttribute('data-group');
        const checkboxesInGroup = document.querySelectorAll(`input[data-group="${group}"]`);
        
        checkboxesInGroup.forEach(function(cb) {
            if (cb !== checkbox) cb.checked = false;
        });
    });
});

// Menandai semua checkbox "Ya" sebagai tercentang secara default
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[id$="_ya"]').forEach(function(checkbox) {
        checkbox.checked = true; // Semua checkbox "Ya" akan dicentang
    });
});

</script>

@endsection
