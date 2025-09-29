@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')

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

                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <select id="pegawai-select" name="pegawai_id" class="form-control">
                                <option value="">-- Select Pegawai --</option>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->nik }},{{ $p->nama }}" {{ $user->username === $p->nik ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username"  id="username"  class="form-control" placeholder="Enter Username" value="{{ $user->username }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank if not changing">
                            </div>

                            <div class="form-group mb-3">
                                <label for="level">Level:</label>
                                <select name="level" class="form-control">
                                    <option value="Direktur" {{ $user->level == 'Direktur' ? 'selected' : '' }}>Direktur</option>
                                    <option value="Kabag" {{ $user->level == 'Kabag' ? 'selected' : '' }}>Kabag</option>
                                    <option value="Kabid" {{ $user->level == 'Kabag' ? 'selected' : '' }}>Kabid</option>
                                    <option value="Kasie" {{ $user->level == 'Kasie' ? 'selected' : '' }}>Kasie</option>
                                    <option value="Koordinator" {{ $user->level == 'Koordinator' ? 'selected' : '' }}>Koordinator</option>
                                    <option value="Pelaksana" {{ $user->level == 'Pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                                    <option value="Komite" {{ $user->level == 'Komite' ? 'selected' : '' }}>Komite</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
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
            
            // Initialize Choices.js
            const choices = new Choices(pegawaiSelect, {
                searchEnabled: true,
                itemSelectText: '',
                placeholderValue: 'Select Pegawai',
            });

            // Update username input field when selection changes
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