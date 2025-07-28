@extends('layouts.app')

@section('title', 'PISAH - Register')

@section('styles')
<style>
     body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .register-container {
        margin-top: 50px;
    }

    .register-header h2 {
        font-size: 1.5rem;
    }

    .register-header p {
        font-size: 0.9rem;
    }

    .register-form .form-group {
        position: relative;
    }

    .register-form .form-control {
        padding-right: 40px;
    }

    .register-form .password-requirements {
        position: static;
        width: 100%;
        padding: 0.5rem;
        background-color: #f8d7da;
        border-radius: 0.25rem;
        display: none;
        margin-top: 0.5rem;
    }

    .register-form .password-requirements ul {
        margin: 0;
        padding: 0;
    }

    .register-form .password-requirements li {
        font-size: 0.8rem;
    }

    .register-form .password-requirements li i {
        margin-right: 0.5rem;
    }

    .register-form .password-requirements li.text-success {
        color: #155724;
        background-color: #d4edda;
    }

    .register-form .password-requirements li.text-danger {
        color: #721c24;
        background-color: #f8d7da;
    }
</style>

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="register-container bg-white p-5 rounded shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="register-header text-center mb-4">
            <h2 class="text-success">Register</h2>
            <p class="text-muted">Daftar PISAH</p>
        </div>
        <form class="register-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama" required autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="password-requirements mt-2">
                    <ul class="list-unstyled">
                        <li id="length" class="text-danger">
                            <i class="fas fa-times"></i> Minimal 8 karakter
                        </li>
                        <li id="uppercase" class="text-danger">
                            <i class="fas fa-times"></i> Ada huruf kapital
                        </li>
                        <li id="lowercase" class="text-danger">
                            <i class="fas fa-times"></i> Ada huruf kecil
                        </li>
                        <li id="number" class="text-danger">
                            <i class="fas fa-times"></i> Ada angka
                        </li>
                        <li id="special" class="text-danger">
                            <i class="fas fa-times"></i> Ada karakter spesial
                        </li>
                    </ul>
                </div>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">Daftar</button>
            </div>
        </form>
        <div class="text-center mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Login disini</a>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- Password Validation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const requirementsDiv = document.querySelector('.password-requirements');
        const requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            lowercase: document.getElementById('lowercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };

        const checkPassword = () => {
            const password = passwordInput.value;
            const criteria = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            if (password.length > 0) {
                requirementsDiv.style.display = 'block';
            } else {
                requirementsDiv.style.display = 'none';
            }

            for (const key in criteria) {
                if (criteria[key]) {
                    requirements[key].classList.remove('text-danger');
                    requirements[key].classList.add('text-success');
                    requirements[key].innerHTML = `<i class="fas fa-check"></i> ${requirements[key].textContent.trim()}`;
                } else {
                    requirements[key].classList.remove('text-success');
                    requirements[key].classList.add('text-danger');
                    requirements[key].innerHTML = `<i class="fas fa-times"></i> ${requirements[key].textContent.trim()}`;
                }
            }
        };

        passwordInput.addEventListener('input', checkPassword);
        passwordInput.addEventListener('focus', checkPassword);
        passwordInput.addEventListener('blur', () => {
            if (passwordInput.value.length === 0) {
                requirementsDiv.style.display = 'none';
            }
        });
    });
</script>
@endsection
