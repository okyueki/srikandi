@extends('layouts.pages-layouts')

@section('pageTitle', 'Edit Jadwal Pegawai')

@section('content')
<article class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Jadwal Presensi</h3>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="{{ route('jadwal.index') }}" role="tab">Jadwal</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
              <form name="jadwaledit" action="{{ route('jadwal.update', [$jadwalPegawai->id, $bulan, $tahun]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama</label>
                            <select name="id" id="id" class="form-control selectator">
                                <option value="{{ $jadwalPegawai->pegawai->id }}" selected>{{ $jadwalPegawai->pegawai->nama }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="tahun" id="tahun" class="form-control selectator">
                                <option value="{{ $tahun }}" selected>{{ $tahun }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select name="bulan" id="bulan" class="form-control selectator">
                                <option value="{{ $bulan }}" selected>{{ date('F', mktime(0, 0, 0, $bulan, 10)) }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <label for="">Tanggal</label>
                <div class="row clearfix">
                  @for ($i = 1; $i <= 31; $i++)
                    @php
                        $hari = 'h'.$i;
                    @endphp
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</label>
                        <select name="h{{ $i }}" id="h{{ $i }}" class="form-control selectator">
                            <option value="">Pilih Shift</option> <!-- Ini adalah nilai default jika tidak ada shift yang dipilih -->
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->shift }}" 
                                    {{ old('h'.$i, $jadwalPegawai->$hari) == $shift->shift ? 'selected' : '' }}>
                                    {{ $shift->shift }} - {{ $shift->jam_masuk }} s/d {{ $shift->jam_pulang }}
                                </option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  @endfor
                </div>
                <div class="form-group">
                  <input type="submit" name="save" class="btn btn-primary" value="Simpan" />
                </div>
              </form>
            </div>
        </div>
    </div>
</article>

@endsection