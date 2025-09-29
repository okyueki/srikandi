@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body">
                <form action="{{ route('ubahpassword.update') }}" method="POST" id="passwordForm">
                    @csrf
                    <div class="mb-3">
                        <label for="password_lama" class="form-label">Password Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                            <span class="input-group-text" onclick="togglePassword('password_lama')">
                                <i class="fa fa-eye" id="eye_password_lama"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                            <span class="input-group-text" onclick="togglePassword('password_baru')">
                                <i class="fa fa-eye" id="eye_password_baru"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_baru_confirmation" name="password_baru_confirmation" required>
                            <span class="input-group-text" onclick="togglePassword('password_baru_confirmation')">
                                <i class="fa fa-eye" id="eye_password_baru_confirmation"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        let field = document.getElementById(fieldId);
        let eyeIcon = document.getElementById('eye_' + fieldId);
        if (field.type === "password") {
            field.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
    
    document.getElementById("passwordForm").addEventListener("submit", function(event) {
        let passwordBaru = document.getElementById("password_baru").value;
        let konfirmasiPassword = document.getElementById("password_baru_confirmation").value;

        if (passwordBaru !== konfirmasiPassword) {
            event.preventDefault(); // Mencegah form dikirim
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok!',
                text: 'Konfirmasi password harus sama dengan password baru.',
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! implode("<br>", $errors->all()) !!}'
            });
        @endif
    });
</script>

@endsection