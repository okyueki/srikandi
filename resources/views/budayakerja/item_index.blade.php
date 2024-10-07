@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Item Penilaian')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Item Penilaian</h3>
            <h1>Daftar Item Penilaian</h1>
            <a href="{{ route('item_penilaian.create') }}" class="btn btn-primary">Tambah Item</a>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Item</th>
                        <th>Bobot Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_item }}</td>
                            <td>{{ $item->bobot_nilai }}</td>
                            <td>
                                <a href="{{ route('item_penilaian.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('item_penilaian.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>    
    </div>        
</div>
@endsection
