@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:30px">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <div class="auth-header">
                    <img src="{{ asset('images/logo.uitm.png') }}" alt="UiTM Logo" height="50">
                    <h2>Student Registration</h2>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus placeholder="Full Name">
                            <label for="name">Full Name</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required placeholder="Email Address">
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

                        <div class="form-floating mb-4">
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation" required placeholder="Confirm Password">
                            <label for="password_confirmation">Confirm Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </button>

                        <div class="text-center">
                            <p class="mb-0">Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        // Auto-close after 5 seconds
        setTimeout(() => {
            document.querySelector('.alert').alert('close');
        }, 5000);
    </script>
@endif

@endsection

@push('styles')
<style>
    body {
        background: url('{{ asset("images/background.login.jpg") }}');
        background-attachment: fixed;
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
        background-color: #f12711;
        border: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #d4210f;
        transform: translateY(-2px);
    }

    .alert {
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
@endpush
