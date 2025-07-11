@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 profile-container">
    <div class="row g-0">
        <div class="col-12">
            <div class="profile-header p-3 text-center text-white" style="margin-top:70px">
                <div class="d-flex justify-content-between align-items-center">
                    <div></div> {{-- Placeholder --}}
                </div>
            </div>

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

                <div class="card mb-3 border-0 shadow-sm profile-card">
                    <div class="card-body text-center p-4">
                        {{-- Main profile update form now includes profile picture --}}
                        <form method="POST" action="{{ route('president.profile.update') }}" enctype="multipart/form-data" id="profileUpdateForm">
                            @csrf
                            @method('PUT')
                            <div class="avatar-container mx-auto mb-3 position-relative">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/'.$user->profile_picture) }}"
                                            class="profile-avatar" alt="Profile Picture">
                                @else
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                @endif
                                <label for="profile_picture" class="avatar-edit-btn bg-primary">
                                    <i class="fas fa-camera text-white"></i>
                                    {{-- REMOVED onchange="this.form.submit()" here --}}
                                    <input type="file" id="profile_picture" name="profile_picture" class="d-none">
                                </label>
                            </div>
                        </form>
                        {{-- FIX: Corrected President Display Name to use $user->name --}}
                        <h5 class="mb-1 text-dark">{{ $user->name ?? 'President Name' }}</h5>
                        <span class="badge bg-info text-dark">
                            <i class="fas fa-crown me-1"></i> Club President
                        </span>
                        @if($club)
                            <p class="text-muted mb-0 mt-2">
                                <i class="fas fa-users me-1"></i> {{ $club->name }}
                            </p>
                        @else
                            <p class="text-muted mb-0 mt-2">
                                <i class="fas fa-info-circle me-1"></i> No Club Assigned
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Main profile update form - now the only form and includes profile picture --}}
                {{-- The form tag starts ABOVE the profile picture div to include it --}}
                <form method="POST" action="{{ route('president.profile.update') }}" enctype="multipart/form-data" id="mainProfileUpdateForm">
                    @csrf
                    @method('PUT')
                    {{-- Hidden input for profile_picture if you want to use the first form's file input --}}
                    {{-- Alternatively, move the whole avatar-container inside this form --}}
                    {{-- For simplicity, I'll assume you combine them directly as suggested above,
                         and the input[type="file"] should be inside this form. --}}

                    <div class="row g-2">
                        <div class="col-12">
                            <h5 class="text-primary fw-bold mb-3 mt-4 border-top pt-3">President's Personal Details</h5>
                        </div>

                        {{-- President Fullname (Editable) --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">President Fullname</label>
                                <input type="text" class="form-control form-control-lg" name="name" {{-- Changed to name="name" to match President model column --}}
                                        value="{{ old('name', $user->name ?? '') }}"> {{-- Using $user->name --}}
                                @error('name') {{-- Error message for 'name' --}}
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- President Student ID --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">President Student ID</label>
                                <input type="text" class="form-control form-control-lg" name="president_student_id"
                                        value="{{ old('president_student_id', $user->president_student_id ?? '') }}">
                                @error('president_student_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- President Course --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">President Course Program</label>
                                <input type="text" class="form-control form-control-lg" name="president_course"
                                        value="{{ old('president_course', $user->president_course ?? '') }}">
                                @error('president_course')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- President Semester --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">President Current Semester</label>
                                <input type="number" class="form-control form-control-lg" name="president_semester"
                                        value="{{ old('president_semester', $user->president_semester ?? '') }}" min="1" max="10">
                                @error('president_semester')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- President Contact Phone --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">President Contact Phone</label>
                                <input type="text" class="form-control form-control-lg" name="contact_phone"
                                        value="{{ old('contact_phone', $user->contact_phone ?? '') }}" placeholder="e.g., 0123456789">
                                @error('contact_phone')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <h5 class="text-primary fw-bold mb-3 mt-4 border-top pt-3">Club Details (Managed by you)</h5>
                        </div>

                        {{-- Club Name (Editable if club exists) --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">Club Name</label>
                                <input type="text" class="form-control form-control-lg" name="club_name"
                                        value="{{ old('club_name', $club->name ?? '') }}" {{ $club ? '' : 'readonly' }} placeholder="{{ $club ? 'Enter club name' : 'No club assigned' }}">
                                @error('club_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Advisor Name (Editable if club exists) --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">Advisor Name</label>
                                <input type="text" class="form-control form-control-lg" name="advisor_name"
                                        value="{{ old('advisor_name', $club->advisor_name ?? '') }}" {{ $club ? '' : 'readonly' }} placeholder="{{ $club ? 'Enter advisor name' : 'No club assigned' }}">
                                @error('advisor_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Club Email (Editable if club exists) --}}
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 form-group">
                                <label class="form-label text-primary fw-bold">Club Email Address</label>
                                <input type="email" class="form-control form-control-lg" name="club_email"
                                        value="{{ old('club_email', $club->email ?? '') }}" {{ $club ? '' : 'readonly' }} placeholder="{{ $club ? 'Enter club email' : 'No club assigned' }}">
                                @error('club_email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="button" class="btn btn-gradient-purple flex-grow-1"
                                data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i> Change Password
                        </button>
                        <button type="submit" class="btn btn-gradient-blue flex-grow-1">
                            <i class="fas fa-save me-1"></i> Save Profile
                        </button>
                    </div>

                    <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                        @if($club)
                            <a href="{{ route('president.dashboard', ['club_id' => $club->id]) }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-tachometer-alt me-2"></i> Back to Dashboard
                            </a>
                        @else
                            <span class="btn btn-outline-secondary rounded-pill px-4 disabled" tabindex="-1" role="button" aria-disabled="true">
                                <i class="fas fa-tachometer-alt me-2"></i> No Dashboard (No Club Assigned)
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-blue text-white">
                <h5 class="modal-title">
                    <i class="fas fa-lock me-2"></i> Update Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('president.changePassword') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label text-primary fw-bold">Current Password</label>
                        <input type="password" class="form-control form-control-lg" name="current_password" required>
                        @error('current_password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label text-primary fw-bold">New Password</label>
                        <input type="password" class="form-control form-control-lg" name="new_password" required>
                        @error('new_password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
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
