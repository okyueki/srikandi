<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">No Permintaan</label>
                        <input type="text" class="form-control" name="no_permintaan" placeholder="Disabled..." value="{{ old('no_permintaan', $permintaan->no_permintaan ?? '') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Inventaris</label>
                        <select type="text" class="form-control" name="no_inventaris">
                            @foreach($inventaris as $item)
                                <option value="{{ $item->no_inventaris }}" {{ isset($permintaan) && $item->no_inventaris == $permintaan->no_inventaris ? 'selected' : '' }}>
                                    {{ $item->no_inventaris }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label>NIK</label>
                        <select name="nik">
                            @foreach($pegawai as $person)
                                <option value="{{ $person->nik }}" {{ isset($permintaan) && $person->nik == $permintaan->nik ? 'selected' : '' }}>
                                    {{ $person->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label>Tanggal</label>
                        <input type="datetime-local" name="tanggal" value="{{ old('tanggal', isset($permintaan->tanggal) ? $permintaan->tanggal->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                    </div>
                    
                    <div>
                        <label>Deskripsi Kerusakan</label>
                        <textarea name="deskripsi_kerusakan">{{ old('deskripsi_kerusakan', $permintaan->deskripsi_kerusakan ?? '') }}</textarea>
                    </div>
                    
                    <div>
                        <label>Status</label>
                        <select name="status">
                            <option value="Pending" {{ isset($permintaan) && $permintaan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ isset($permintaan) && $permintaan->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ isset($permintaan) && $permintaan->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ isset($permintaan) && $permintaan->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    
                    <div>
                        <label>Prioritas</label>
                        <select name="prioritas">
                            <option value="Low" {{ isset($permintaan) && $permintaan->prioritas == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ isset($permintaan) && $permintaan->prioritas == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ isset($permintaan) && $permintaan->prioritas == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>    
            </div>
        </div>
    </div>            
</div>