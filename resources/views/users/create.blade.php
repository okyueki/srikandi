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
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <select id="pegawai-select" name="pegawai_id" class="form-control">
                                    <option value="">-- Select Pegawai --</option>
                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->nik }},{{ $p->nama }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" value="{{ old('username') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="form-group mb-3">
                                <label for="level">Level:</label>
                                <select name="level" class="form-control">
                                <option value="Direktur">Direktur</option>
                                    <option value="Kabag">Kabag</option>
                                    <option value="Kabid">Kabid</option>
                                    <option value="Kasie">Kasie</option>
                                    <option value="Koordinator">Koordinator</option>
                                    <option value="Pelaksana">Pelaksana</option>
                                    <option value="Komite">Komite</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- End Page-content -->
<script>
        document.addEventListener('DOMContentLoaded', function () {
            const pegawaiSelect = document.getElementById('pegawai-select');
            const usernameInput = document.getElementById('username');
            
            const choices = new Choices(pegawaiSelect, {
                searchEnabled: true,
                itemSelectText: '',
                placeholderValue: 'Select Pegawai',
            });

            pegawaiSelect.addEventListener('change', function () {
                const selectedValue = pegawaiSelect.value;
                if (selectedValue) {
                    // Split the value to extract nik and nama
                    const [nik, nama] = selectedValue.split(',');
                    usernameInput.value = nik;
                } else {
                    usernameInput.value = '';
                }
            });
        });
    </script>
@endsection