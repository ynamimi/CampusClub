@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 profile-container">
    <div class="row g-0">
        <div class="col-12">
            <!-- Vibrant Header Section -->
            <div class="profile-header p-3 text-center text-white" style="margin-top:70px">
                <div class="d-flex justify-content-between align-items-center" >
                    <div class="d-flex align-items-center">
                    </div>
                </div>
            </div>

            <!-- Profile Section with Colorful Elements -->
            <div class="p-3">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Profile Card with Gradient Background -->
                <div class="card mb-3 border-0 shadow-sm profile-card">
                    <div class="card-body text-center p-4">
                        {{-- Profile Picture upload form (this one submits on file change) --}}
                        {{-- IMPORTANT: Added @method('PUT') here for correct form spoofing --}}
                        <form id="profilePictureForm" method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="file" id="profile_picture" name="profile_picture" class="d-none">
                            <div class="avatar-container mx-auto mb-3 position-relative">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/'.auth()->user()->profile_picture) }}"
                                         class="profile-avatar" alt="Profile Picture">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <label for="profile_picture" class="avatar-edit-btn bg-primary">
                                    <i class="fas fa-camera text-white"></i>
                                    <input type="file" id="profile_picture" name="profile_picture" class="d-none" onchange="this.form.submit()">
                                </label>
                            </div>
                        </form>
                        <h5 class="mb-1 text-dark">{{ auth()->user()->name }}</h5>
                        <span class="badge bg-info text-dark">
                            <i class="fas fa-id-card me-1"></i> Student Member
                        </span>
                    </div>
                </div>

                <!-- Colorful Form Section - Main Profile Update Form -->
                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    @method('PUT') {{-- This was already correct --}}
                    <div class="row g-2">
                        {{-- Student Fullname (Readonly - always from User model) --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">Full Name</label>
                                <input type="text" class="form-control form-control-lg bg-light"
                                       value="{{ $user->name }}" readonly>
                            </div>
                        </div>

                        <!-- Email (Readonly - always from User model) -->
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">Email Address</label>
                                <input type="email" class="form-control form-control-lg bg-light"
                                       value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                    <!-- Colorful Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="button" class="btn btn-gradient-purple flex-grow-1"
                                data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i> Change Password
                        </button>
                    </div>

                    <!-- Back to Home Button at Bottom -->
                    <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                        <a href="{{ route('student.home') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-home me-2"></i> Back to Home
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal with Color -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-blue text-white">
                <h5 class="modal-title">
                    <i class="fas fa-lock me-2"></i> Update Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('student.changePassword') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label text-primary fw-bold">Current Password</label>
                        <input type="password" class="form-control form-control-lg" name="current_password" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label text-primary fw-bold">New Password</label>
                        <input type="password" class="form-control form-control-lg" name="new_password" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label text-primary fw-bold">Confirm New Password</label>
                        <input type="password" class="form-control form-control-lg" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-blue">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Colorful Base Styles */
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-blue: #4895ef;
        --accent-purple: #7209b7;
        --accent-pink: #f72585;
    }

    .profile-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--accent-purple), var(--primary-color));
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .profile-card {
        background: linear-gradient(135deg, #ffffff 0%, #f1f8ff 100%);
        border-radius: 12px !important;
        border-left: 4px solid var(--accent-blue);
    }

    /* Avatar Styles */
    .avatar-container {
        width: 100px;
        height: 100px;
        position: relative;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .avatar-edit-btn:hover {
        transform: scale(1.1);
    }

    /* Form Styles */
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-control-lg:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 0.25rem rgba(72, 149, 239, 0.25);
    }

    .form-group {
        position: relative;
    }

    /* Button Styles */
    .btn-gradient-blue {
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-purple {
        background: linear-gradient(135deg, var(--accent-purple), #9d4edd);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-blue:hover, .btn-gradient-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }

    /* Back to Home Button */
    .btn-outline-secondary {
        border-color: #dee2e6;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    /* Badge Styles */
    .badge.bg-info {
        background-color: #4cc9f0 !important;
    }

    /* Landscape Optimization */
    @media (orientation: landscape) {
        .profile-header {
            padding: 1rem !important;
        }

        .avatar-container {
            width: 80px;
            height: 80px;
        }

        .form-control-lg {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.5rem 1rem;
        }
    }

    /* Portrait Optimization */
    @media (orientation: portrait) {
        .profile-card {
            margin-top: 1rem;
        }
    }
</style>
@endpush
