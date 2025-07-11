@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container" style="margin-top:30px">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card">
                <div class="auth-header">
                    <img src="{{ asset('images/logo.uitm.png') }}" alt="UiTM Logo" height="50">
                    <h2>President Login</h2>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('president.login.submit') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address">
                            <label for="email">Email Address</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: url('{{ asset("images/background.login.jpg") }}');
        min-height: 100vh;
    }

    .auth-card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        margin-top: 3rem;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-header h2 {
        color: #333;
        margin-top: 1rem;
        font-weight: 600;
    }

    .form-floating label {
        color: #6c757d;
    }

    .btn-primary {
        background-color: #11998e;
        border: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #0d7a72;
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        border-color: #11998e;
        color: #11998e;
        font-weight: 500;
    }

    .btn-outline-primary:hover {
        background-color: #11998e;
        color: white;
    }
</style>
@endpush
