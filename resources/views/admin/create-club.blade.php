@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen">
    <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 ease-in-out">
        <main class="flex-1 flex justify-start items-start">
            <div class="w-full px-4 py-8">
                <div class="dashboard-container">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md" style="margin-top:50px">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Main Header for the page --}}
                    <h1 class="text-center mb-4 text-indigo-700 font-extrabold text-3xl" style="margin-top:80px">Create New Club</h1>

                    {{-- Form container (the main white card) --}}
                    {{-- START OF CHANGES: Use a flex container for the main layout --}}
                    <div class="flex flex-col md:flex-row justify-center items-center">
                        {{-- Placeholder for content on the left --}}
                        {{-- You can add your left-side content here, for example: --}}
                        <div class="w-full md:w-1/2 p-6">
                            <h2 class="text-2xl font-bold text-gray-800">New Club Registration</h2>
                            <p class="mt-4 text-gray-600">Please fill out the form on the right to register a new club. All required fields are marked with an asterisk (*).</p>
                        </div>

                        {{-- The form now takes a specific width, and is a flex item --}}
                        <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full md:w-1/2 lg:w-2/3 mx-auto">
                            <form action="{{ route('admin.storeClub') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- The rest of your form code is here --}}
                                {{-- START: CLUB DETAILS SECTION HEADER --}}
                                <h5 class="text-indigo-700 font-extrabold border-b pb-2 mb-4 text-xl mt-0">
                                    Club Details
                                </h5>
                                {{-- END: CLUB DETAILS SECTION HEADER --}}

                                {{-- Group for Club Name and Acronym (two columns) --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-tag fa-lg me-2 text-indigo-500"></i> Club Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="name" name="name" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="acronym" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-compress-alt fa-lg me-2 text-indigo-500"></i> Club Acronym (Optional)
                                            </label>
                                            <input type="text" id="acronym" name="acronym" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('acronym') }}">
                                            @error('acronym')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Club Description - Full width row --}}
                                <div class="mb-6">
                                    <label for="description" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                        <i class="fas fa-align-left fa-lg me-2 text-indigo-500"></i> Club Description (Optional)
                                    </label>
                                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Group for Club Type and Logo (two columns) --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="type" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-bars fa-lg me-2 text-indigo-500"></i> Club Type <span class="text-red-500">*</span>
                                            </label>
                                            <select id="type" name="type" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100" required>
                                                <option value="">Select Club Type</option>
                                                <option value="public" {{ old('type') == 'public' ? 'selected' : '' }}>Public</option>
                                                <option value="faculty" {{ old('type') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                            </select>
                                            @error('type')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="logo" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-image fa-lg me-2 text-indigo-500"></i> Club Logo (Optional)
                                            </label>
                                            <input type="file" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-gray-800 bg-gray-100" id="logo" name="logo">
                                            @error('logo')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Organizational Chart - Full width row --}}
                                <div class="mb-6">
                                    <label for="org_chart" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                        <i class="fas fa-sitemap fa-lg me-2 text-indigo-500"></i> Organizational Chart (Optional)
                                    </label>
                                    <input type="file" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-gray-800 bg-gray-100" id="org_chart" name="org_chart">
                                    @error('org_chart')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- START: ADVISOR NAME FIELD (NOW MANDATORY) --}}
                                <div class="mb-6">
                                    <label for="advisor_name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                        <i class="fas fa-user-tie fa-lg me-2 text-indigo-500"></i> Advisor Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="advisor_name" name="advisor_name" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('advisor_name') }}" required>
                                    @error('advisor_name')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- END: ADVISOR NAME FIELD --}}

                                <hr class="my-8 border-gray-300">

                                {{-- START: PRESIDENT'S INFORMATION SECTION HEADER --}}
                                <h5 class="text-indigo-700 font-extrabold border-b pb-2 mb-4 text-xl mt-8">
                                    President's Information
                                </h5>
                                {{-- END: PRESIDENT'S INFORMATION SECTION HEADER --}}

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="president_name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-user fa-lg me-2 text-indigo-500"></i> President Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="president_name" name="president_name" value="{{ old('president_name') }}" required>
                                            @error('president_name')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="president_student_id" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-id-card fa-lg me-2 text-indigo-500"></i> President Student ID <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="president_student_id" name="president_student_id" value="{{ old('president_student_id') }}" required>
                                            @error('president_student_id')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="president_course" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-book-open fa-lg me-2 text-indigo-500"></i> President Course <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="president_course" name="president_course" value="{{ old('president_course') }}" required>
                                            @error('president_course')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="president_semester" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-calendar-alt fa-lg me-2 text-indigo-500"></i> President Semester <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="president_semester" name="president_semester" value="{{ old('president_semester') }}" required>
                                            @error('president_semester')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="contact_phone" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                        <i class="fas fa-phone fa-lg me-2 text-indigo-500"></i> President Contact Phone (Optional)
                                    </label>
                                    <input type="text" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                                    @error('contact_phone')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div><br><br>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="email" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-envelope fa-lg me-2 text-indigo-500"></i> Club Email (President's Login) <span class="text-red-500">*</span>
                                            </label>
                                            <input type="email" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="password" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-lock fa-lg me-2 text-indigo-500"></i> President Password <span class="text-red-500">*</span>
                                            </label>
                                            <input type="password" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="password" name="password" required>
                                            @error('password')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="password_confirmation" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-lock-open fa-lg me-2 text-indigo-500"></i> Confirm Password <span class="text-red-500">*</span>
                                            </label>
                                            <input type="password" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="password_confirmation" name="password_confirmation" required>
                                            @error('password_confirmation')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-8 border-gray-300">

                                {{-- START: CONTACT & SOCIAL MEDIA LINKS SECTION HEADER --}}
                                <h5 class="text-indigo-700 font-extrabold border-b pb-2 mb-4 text-xl mt-8">
                                    Contact & Social Media Links (Optional)
                                </h5>
                                {{-- END: CONTACT & SOCIAL MEDIA LINKS SECTION HEADER --}}

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="instagram_link" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fab fa-instagram fa-lg me-2 text-pink-600"></i> Instagram Link
                                            </label>
                                            <input type="url" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="instagram_link" name="instagram_link" value="{{ old('instagram_link') }}" placeholder="https://instagram.com/yourclub">
                                            @error('instagram_link')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="x_link" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fab fa-x-twitter fa-lg me-2 text-blue-600"></i> X (Twitter) Link
                                            </label>
                                            <input type="url" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="x_link" name="x_link" value="{{ old('x_link') }}" placeholder="https://twitter.com/yourclub">
                                            @error('x_link')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                    <div class="col-span-1">
                                        <div class="mb-4">
                                            <label for="tiktok_link" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fab fa-tiktok fa-lg me-2 text-gray-800"></i> TikTok Link
                                            </label>
                                            <input type="url" class="w-full px-4 py-3 border-2 border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="tiktok_link" name="tiktok_link" value="{{ old('tiktok_link') }}" placeholder="https://tiktok.com/@yourclub">
                                            @error('tiktok_link')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-1"></div>
                                </div>

                                <div class="flex flex-wrap gap-4 mt-6">
                                    <button type="submit" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                        <i class="fas fa-save me-2"></i> Create Club
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    {{-- END OF CHANGES: Close the new flex container --}}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // No JavaScript is needed here as there's no sidebar to manage.
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    :root {
        --primary-color: #4f46e5;
        --secondary-color: #3730a3;
        --accent-blue: #2563eb;
        --accent-purple: #9333ea;
        --accent-pink: #db2777;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        background: #f9fafb;
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Styles for the elevated card effect, previously called 'dashboard-card' */
    .dashboard-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        width: 100% !important;
    }

    /* Primary button styles */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #6366f1;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
    }

    /* Outline secondary button styles */
    .btn-outline-secondary {
        border-color: #d1d5db;
        color: #4b5563;
        font-weight: 500;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    /* Form input styling */
    input, select, textarea {
        border-width: 2px !important;
        border-color: #4f46e5 !important;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.3);
    }

    /* Specific text colors */
    .text-indigo-700 {
        color: #4338ca;
    }

    .text-indigo-500 {
        color: #6366f1;
    }

    .text-dark {
        color: #1f2937;
    }

    .text-pink-600 {
        color: #db2777;
    }

    .text-blue-600 {
        color: #2563eb;
    }

    /* Media queries for responsiveness */
    @media (max-width: 767.98px) {
        .text-4xl {
            font-size: 2.5rem !important;
        }

        .text-3xl {
            font-size: 2rem !important;
        }

        .flex-wrap>.flex-grow {
            flex-grow: 1;
            min-width: 120px;
        }
    }
</style>
@endpush
