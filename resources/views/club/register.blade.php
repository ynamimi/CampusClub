@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 profile-container">
    <div class="row g-0">
        <div class="col-12" style="margin-top:70px">
            <!-- Registration Section -->
            <div class="p-4">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12">
                        <!-- Wider Registration Card -->
                        <div class="card border-0 shadow-lg mb-4 w-100" style="border-radius: 15px; margin: 0 auto;">
                            <div class="card-header bg-gradient-blue text-white py-3 rounded-top">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="mb-0">
                                            <i class="fas fa-user-plus me-2"></i>
                                            Join {{ $club->name }}
                                        </h3>
                                        <p class="mb-0 mt-1 small opacity-75">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Complete the form to become a member
                                        </p>
                                    </div>
                                    @if($club->logo)
                                    <img src="{{ asset('storage/club_images/'.$club->image) }}"
                                        alt="Club Logo"
                                        class="img-thumbnail border-0 shadow-sm"
                                        style="max-width: 60px; background: transparent;">
                                    @endif
                                </div>
                            </div>

                            <div class="card-body p-5">
                                <form action="{{ route('club.register.submit', $club->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="club_id" value="{{ $club->id }}">

                                    <div class="row g-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3 border-bottom pb-2">
                                                <i class="fas fa-user-circle me-2"></i> Personal Information
                                            </h5>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text"
                                                       name="fullname"
                                                       id="fullname"
                                                       class="form-control"
                                                       placeholder=" "
                                                       value="{{ old('fullname', $user->name ?? '') }}"
                                                       required>
                                                <label for="fullname">
                                                    <i class="fas fa-user me-1 text-primary"></i> Full Name
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text"
                                                       name="student_id"
                                                       id="student_id"
                                                       class="form-control"
                                                       placeholder=" "
                                                       value="{{ old('student_id', $latest->student_id ?? '') }}"
                                                       autocomplete="username"
                                                       required>
                                                <label for="student_id">
                                                    <i class="fas fa-id-card me-1 text-primary"></i> Student ID
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h5 class="text-primary mb-3 border-bottom pb-2">
                                                <i class="fas fa-graduation-cap me-2"></i> Academic Information
                                            </h5>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text"
                                                       name="course"
                                                       id="course"
                                                       class="form-control"
                                                       placeholder=" "
                                                       value="{{ old('course', $latest->course ?? '') }}"
                                                       autocomplete="organization"
                                                       required>
                                                <label for="course">
                                                    <i class="fas fa-book me-1 text-primary"></i> Course
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text"
                                                       name="semester"
                                                       id="semester"
                                                       class="form-control"
                                                       placeholder=" "
                                                       value="{{ old('semester', $latest->semester ?? '') }}"
                                                       required>
                                                <label for="semester">
                                                    <i class="fas fa-calendar-alt me-1 text-primary"></i> Semester
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h5 class="text-primary mb-3 border-bottom pb-2">
                                                <i class="fas fa-address-book me-2"></i> Contact Information
                                            </h5>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                {{-- Key Change: Use $user->email and make it readonly --}}
                                                <input type="email"
                                                       name="email"
                                                       id="email"
                                                       class="form-control bg-light" {{-- Added bg-light for visual readonly cue --}}
                                                       placeholder=" "
                                                       value="{{ $user->email ?? '' }}" {{-- Directly use $user->email --}}
                                                       autocomplete="email"
                                                       readonly> {{-- Make it readonly --}}
                                                <label for="email">
                                                    <i class="fas fa-envelope me-1 text-primary"></i> Email Address
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="tel"
                                                       name="phone"
                                                       id="phone"
                                                       class="form-control"
                                                       placeholder=" "
                                                       value="{{ old('phone', $latest->phone ?? '') }}"
                                                       autocomplete="tel"
                                                       required>
                                                <label for="phone">
                                                    <i class="fas fa-phone-alt me-1 text-primary"></i> Phone Number
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h5 class="text-primary mb-3 border-bottom pb-2">
                                                <i class="fas fa-info-circle me-2"></i> Additional Information
                                            </h5>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-floating">
                                                <select name="gender" class="form-select" required>
                                                    <option value="" disabled selected>Select Gender</option> {{-- Added disabled selected for better UX --}}
                                                    <option value="male" {{ (old('gender', $latest->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ (old('gender', $latest->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                                                </select>
                                                <label for="gender">
                                                    <i class="fas fa-venus-mars me-1 text-primary"></i> Gender
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4 pt-3 border-top">
                                            <button type="submit" class="btn btn-gradient-blue px-4 py-3 w-100">
                                                <i class="fas fa-user-plus me-2"></i> Submit Registration
                                            </button>
                                        </div>

                                        <div class="col-12 text-center mt-3">
                                            <a href="{{ route('club.show', $club->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                                                <i class="fas fa-arrow-left me-2"></i> Back to Club
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-blue {
        background: linear-gradient(135deg, #4361ee, #3a0ca3) !important;
    }

    .profile-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    /* Card and form styling */
    .card {
        width: 100%;
        max-width: 1200px;
    }

    @media (min-width: 992px) {
        .card-body {
            padding: 3rem !important;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }
    }

    /* Form elements */
    .form-floating {
        margin-bottom: 1.25rem;
    }

    .form-control, .form-select {
        height: calc(3.25rem + 2px);
        border-radius: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
        padding: 1rem 1.25rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    }

    .form-floating label {
        color: #6c757d;
        padding: 1rem 1.5rem;
    }

    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label,
    .form-floating>.form-select~label {
        transform: scale(0.85) translateY(-0.8rem) translateX(0.5rem);
        background-color: white;
        padding: 0 0.5rem;
        color: #4361ee;
    }

    /* Button styling */
    .btn-gradient-blue {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .btn-gradient-blue:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: white;
    }

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

    /* Section headers */
    h5.text-primary {
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .form-control, .form-select {
            height: calc(2.75rem + 2px);
            padding: 0.75rem 1rem;
        }
    }
</style>
@endpush
