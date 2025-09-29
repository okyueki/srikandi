@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('jenis_berkas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jenis_berkas" class="form-label">Jenis Berkas</label>
                            <input type="text" name="jenis_berkas" class="form-control" id="jenis_berkas" required>
                        </div>
                        <div class="mb-3">
                            <label for="bidang" class="form-label">Bidang</label>
                            <select name="bidang[]" id="bidang" class="form-control" multiple>
                                 <option value="">-- Select Bidang --</option>
                                @foreach ($bidang as $b)
                                    <option value="{{ $b->nama }}">{{ $b->nama }}</option>
                                 @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="masa_berlaku" class="form-label">Masa Berlaku</label>
                            <select name="masa_berlaku" class="form-control" id="masa_berlaku" required>
                                <option value="Iya">Iya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>

<script>
       document.addEventListener('DOMContentLoaded', function () {
            const element = document.getElementById('bidang');
            const choices = new Choices(element, {
                placeholderValue: 'Search Bidang...',
                searchEnabled: true,
                position: 'auto', // Display dropdown below the element
                shouldSort: false, // Avoid sorting if not necessary
                removeItemButton: true, // Allows users to remove selected items
            });
        });
</script>
<!-- End Page-content -->

@endsection