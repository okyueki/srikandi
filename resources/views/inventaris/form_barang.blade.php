<div class="form-group">
    <label for="kode_barang">Kode Barang</label>
    <input type="text" name="kode_barang" id="kode_barang" class="form-control" value="{{ old('kode_barang', $barang->kode_barang ?? '') }}" required>
</div>

<div class="form-group">
    <label for="nama_barang">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" required>
</div>

<div class="form-group">
    <label for="jml_barang">Jumlah Barang</label>
    <input type="number" name="jml_barang" id="jml_barang" class="form-control" value="{{ old('jml_barang', $barang->jml_barang ?? '') }}" required>
</div>

<div class="form-group">
    <label for="kode_produsen" class="form-label">Produsen</label>
    <select id="kode_produsen" name="kode_produsen" class="form-control" required>
        <option value="">Pilih Produsen</option>
        @foreach($produsen as $item)
            <option value="{{ $item->kode_produsen }}" {{ old('kode_produsen', $barang->kode_produsen ?? '') == $item->kode_produsen ? 'selected' : '' }}>
                {{ $item->nama_produsen }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="id_merk" class="form-label">Merk</label>
    <select name="id_merk" id="id_merk" class="form-control" required>
        <option value="">Pilih Merk</option>
        @foreach($merk as $item)
            <option value="{{ $item->id_merk }}" {{ old('id_merk', $barang->id_merk ?? '') == $item->id_merk ? 'selected' : '' }}>
                {{ $item->nama_merk }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="id_kategori" class="form-label">Kategori</label>
    <select name="id_kategori" id="id_kategori" class="form-control" required>
        <option value="">Pilih Kategori</option>
        @foreach($kategori as $item)
            <option value="{{ $item->id_kategori }}" {{ old('id_kategori', $barang->id_kategori ?? '') == $item->id_kategori ? 'selected' : '' }}>
                {{ $item->nama_kategori }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="id_jenis" class="form-label">Jenis</label>
    <select name="id_jenis" id="id_jenis" class="form-control" required>
        <option value="">Pilih Jenis</option>
        @foreach($jenis as $item)
            <option value="{{ $item->id_jenis }}" {{ old('id_jenis', $barang->id_jenis ?? '') == $item->id_jenis ? 'selected' : '' }}>
                {{ $item->nama_jenis }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="thn_produksi">Tahun Produksi</label>
    <input type="number" name="thn_produksi" id="thn_produksi" class="form-control" value="{{ old('thn_produksi', $barang->thn_produksi ?? '') }}" required>
</div>

<div class="form-group">
    <label for="isbn">ISBN</label>
    <input type="text" name="isbn" id="isbn" class="form-control" value="{{ old('isbn', $barang->isbn ?? '') }}">
</div>