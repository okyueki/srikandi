<div class="form-group">
    <label for="nik">NIK</label>
    <select name="nik" class="form-control js-example-basic-single">
        <option value="">Pilih NIK</option>
        @foreach($pegawai as $p)
            <option value="{{ $p->nik }}" {{ (old('nik', $ticket->nik ?? '') == $p->nik) ? 'selected' : '' }}>
                {{ $p->nik }} - {{ $p->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="jenis_permintaan">Jenis Permintaan</label>
    <select name="jenis_permintaan" class="form-control">
        <option value="Perbaikan" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
        <option value="Design" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == 'Design' ? 'selected' : '' }}>Design</option>
        <option value="Permasalahan" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == 'Permasalahan' ? 'selected' : '' }}>Permasalahan</option>
        <option value="Permintaan" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == 'Permintaan' ? 'selected' : '' }}>Permintaan</option>
        <option value="Improvment" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == 'Improvment' ? 'selected' : '' }}>Improvment</option>
        <option value="Lain-Lain" {{ old('jenis_permintaan', $ticket->jenis_permintaan ?? '') == 'Lain-Lain' ? 'selected' : '' }}>Lain-Lain</option>
    </select>
</div>

<div class="form-group">
    <label for="tanggal">Tanggal</label>
    <input type="datetime-local" name="tanggal" class="form-control" value="{{ old('tanggal', $ticket->tanggal ?? now()->format('Y-m-d\TH:i')) }}" required>
</div>

<div class="form-group">
    <label for="prioritas">Prioritas</label>
    <select name="prioritas" class="form-control">
        <option value="low" {{ old('prioritas', $ticket->prioritas ?? '') == 'low' ? 'selected' : '' }}>Low</option>
        <option value="medium" {{ old('prioritas', $ticket->prioritas ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
        <option value="high" {{ old('prioritas', $ticket->prioritas ?? '') == 'high' ? 'selected' : '' }}>High</option>
    </select>
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select name="status" class="form-control">
        <option value="open" {{ old('status', $ticket->status ?? '') == 'open' ? 'selected' : '' }}>Open</option>
        <option value="in progress" {{ old('status', $ticket->status ?? '') == 'in progress' ? 'selected' : '' }}>In Progress</option>
        <option value="in review" {{ old('status', $ticket->status ?? '') == 'in review' ? 'selected' : '' }}>In Review</option>
        <option value="close" {{ old('status', $ticket->status ?? '') == 'close' ? 'selected' : '' }}>Close</option>
        <option value="di jadwalkan" {{ old('status', $ticket->status ?? '') == 'di jadwalkan' ? 'selected' : '' }}>Di Jadwalkan</option>
    </select>
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" required>{{ old('deskripsi', $ticket->deskripsi ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="upload">Upload (Gambar)</label>
    <input type="file" name="upload" class="form-control">
</div>

<div class="form-group">
    <label for="departemen">Departemen</label>
    <select name="departemen" class="form-control js-example-basic-single" required>
        <option value="">Pilih Departemen</option>
        @foreach($departemen as $d)
            <option value="{{ $d->dep_id }}" {{ old('departemen', $ticket->departemen ?? '') == $d->dep_id ? 'selected' : '' }}>
                {{ $d->nama }}
            </option>
        @endforeach
    </select>
</div>
