@extends('layouts.app')

@section('title', 'Login Page')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }

    .login-container {
        display: flex;
        max-width: 1000px;
        margin: 50px auto;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .login-form-container {
        flex: 1;
        padding: 40px;
    }

    .login-image {
        flex: 1;
        background-image: url('{{ asset('images/login/bg1.png') }}');
        background-size: cover;
        background-position: center;
        min-height: 500px;
    }

    .login-header img {
        width: 50px;
        height: 50px;
        margin-bottom: 15px;
    }

    .login-header h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333333;
    }

    .login-header p {
        font-size: 14px;
        color: #666666;
        margin-bottom: 30px;
    }

    .login-form .form-group {
        margin-bottom: 25px;
    }

    .login-form .form-control {
        height: 50px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        box-shadow: none;
        transition: border-color 0.2s;
    }

    .login-form .form-control:focus {
        border-color: #6c5ce7;
    }

    .login-form .btn-primary {
        height: 50px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;
        background-color: #6c5ce7;
        border-color: #6c5ce7;
        width: 100%;
    }

    .login-form .btn-primary:hover {
        background-color: #5b4cc7;
        border-color: #5b4cc7;
    }

    .login-divider {
        text-align: center;
        margin: 30px 0;
        position: relative;
    }

    .login-divider span {
        display: inline-block;
        position: relative;
        padding: 0 15px;
        font-size: 14px;
        color: #999999;
        background-color: #ffffff;
    }

    .login-divider:before,
    .login-divider:after {
        content: "";
        position: absolute;
        top: 50%;
        width: calc(50% - 30px);
        height: 1px;
        background-color: #e0e0e0;
    }

    .login-divider:before {
        left: 0;
    }

    .login-divider:after {
        right: 0;
    }

    .btn-google {
        background-color: #ffffff;
        color: #333333;
        height: 50px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;
        border: 1px solid #ced4da;
        width: 100%;
    }

    .btn-google:hover {
        background-color: #f1f3f5;
    }

    .text-center a {
        color: #6c5ce7;
        text-decoration: none;
    }

    .text-center a:hover {
        text-decoration: underline;
    }

    .password-input-group {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666666;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-form-container">
        <div class="login-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h2>Selamat datang kembali!</h2>
            <p>Silahkan login untuk masuk</p>
        </div>
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group password-input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                <span class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Login</button>
            </div>
        </form>
        <div class="login-divider">
            <span>Atau</span>
        </div>
        <div class="text-center mt-3">
            Tidak punya akun? <a href="{{ route('register') }}">Daftar disini</a>
        </div>
    </div>
    <div class="login-image"></div>
</div>

<script>
function togglePassword() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.getElementById("toggleIcon");
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
</script>
@endsection