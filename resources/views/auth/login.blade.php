@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')

{{-- CSS Khusus untuk halaman login --}}
<style>
    .login-container {
        padding: 160px 0 60px 0; /* Padding atas besar agar di bawah navbar */
        background-color: var(--neutral-cream);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }
    .login-box {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 450px;
        border-top: 5px solid var(--dark-olive-green-3);
    }
    .login-box h1 {
        font-family: 'Merriweather', serif;
        color: var(--dark-olive-green-2);
        text-align: center;
        margin-top: 0;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 8px;
        color: #555;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .btn-login {
        width: 100%;
        padding: 12px 15px;
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        background-color: var(--dark-olive-green-3);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-login:hover {
        background-color: var(--dark-olive-green-2);
    }
    .login-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }
</style>

<div class="login-container">
    <div class="login-box">
        <h1>Login Admin</h1>

        {{-- Menampilkan error jika login gagal --}}
        @error('email')
            <div class="login-error">
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            {{-- 
            <div class="form-group" style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" id="remember" style="margin-right: 10px;">
                <label for="remember" style="margin: 0; font-weight: normal;">
                    Ingat Saya
                </label>
            </div>
            --}}

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn-login">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
