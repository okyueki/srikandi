@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Adime Gizi')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Adime Gizi</h3>
            <div>
                <a href="{{ route('adimegizi.create',['no_rawat' => $no_rawat]) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tambah Baru
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(count($adimeGizi) > 0)
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Tanggal</th>
                            <th>Asesmen</th>
                            <th>Diagnosis</th>
                            <th>Petugas</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adimeGizi as $index => $item)
                        <tr>
                            <td><span class="text-muted">{{ $index + 1 }}</span></td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ Str::limit($item->asesmen, 30) }}</td>
                            <td>{{ Str::limit($item->diagnosis, 30) }}</td>
                            <td>{{ $item->pegawai->nama }}</td>
                            <td class="text-end">
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('adimegizi.edit', [$no_rawat, $item->formatted_tanggal]) }}" class="btn btn-sm btn-info">
                                        Edit
                                    </a>
                                    <form action="{{ route('adimegizi.destroy', [$no_rawat, $item->formatted_tanggal]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            Hapus
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $index }}">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Detail Modal -->
                        <div class="modal fade" id="modal-detail-{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="modal-detail-{{ $index }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Adime Gizi - {{ $item->tanggal }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">No. Rawat</label>
                                                <input type="text" class="form-control" value="{{ $item->no_rawat }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal</label>
                                                <input type="text" class="form-control" value="{{ $item->tanggal }}" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Asesmen</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $item->asesmen }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Diagnosis</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $item->diagnosis }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Intervensi</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $item->intervensi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Monitoring</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $item->monitoring }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Evaluasi</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $item->evaluasi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Instruksi</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $item->instruksi }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Petugas</label>
                                            <input type="text" class="form-control" value="{{ $item->pegawai->nama }}" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty">
                <div class="empty-img">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 8l0 4" />
                        <path d="M12 16l.01 0" />
                    </svg>
                </div>
                <p class="empty-title">No data found</p>
                <p class="empty-subtitle text-muted">
                    No Adime Gizi records found for this patient. Click the button below to add new record.
                </p>
                <div class="empty-action">
                    <a href="{{ route('adimegizi.create',['no_rawat' => $no_rawat]) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Baru
                    </a>
                </div>
            </div>
            @endif
        </div>

        @if(count($adimeGizi) > 0)
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-muted">Showing <span>1</span> to <span>{{ count($adimeGizi) }}</span> entries</p>
        </div>
        @endif
    </div>
</div>
@endsection