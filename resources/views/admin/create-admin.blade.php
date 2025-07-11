@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen">

    {{-- The main content area, no sidebar --}}
    <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 ease-in-out">

        <main class="flex-1 flex justify-center items-start">
            {{-- This div wraps the header and the form, controlling its max-width and horizontal padding --}}
            <div class="w-full max-w-4xl px-4 py-8 md:px-8">
                <div class="dashboard-container">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md" style="margin-top:50px">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Header for "Create New Admin", matching "Create New Club" style --}}
                    <h1 class="text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md mb-8" style="margin-top:50px">Create New Admin</h1>

                    {{-- Form container, now using 'dashboard-card' for elevated look and consistent padding --}}
                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full mx-auto">
                        <form action="{{ route('admin.storeAdmin') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full"> {{-- Added w-full for grid consistency --}}
                                <div class="col-span-1"> {{-- Explicitly setting col-span for consistency --}}
                                    <div class="mb-4">
                                        {{-- Labels now include icons and text-indigo-700 font-bold text-lg mb-2 for consistency --}}
                                        <label for="name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-user fa-lg me-2 text-indigo-500"></i> Full Name
                                        </label>
                                        {{-- Input fields consistently use text-gray-800 bg-gray-100 placeholder-gray-500 --}}
                                        <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="email" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-envelope fa-lg me-2 text-indigo-500"></i> Email Address
                                        </label>
                                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('email') }}" required>
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
                                            <i class="fas fa-lock fa-lg me-2 text-indigo-500"></i> Password
                                        </label>
                                        <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" required>
                                        @error('password')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-lock-open fa-lg me-2 text-indigo-500"></i> Confirm Password
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4"> {{-- Changed from mb-6 to mb-4 for more typical spacing --}}
                                <label for="role" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                    <i class="fas fa-user-cog fa-lg me-2 text-indigo-500"></i> Admin Role
                                </label>
                                <select id="role" name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100">
                                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Regular Admin</option>
                                </select>
                                @error('role')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-wrap gap-4 mt-6"> {{-- Changed justify-end to flex-wrap and gap-4 for consistency with Club form --}}
                                <button type="submit" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-save me-2"></i> Create Admin
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </form>
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
        // All sidebar-related JavaScript is removed as per the design requirement.
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
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        background: #f9fafb;
        max-width: 100% !important;
    }

    /* Styles for the elevated card effect, previously called 'dashboard-card' */
    .dashboard-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        /* Removed transition as it's not strictly on the Admin form card from your example */
        width: 100% !important; /* Ensure it takes full width of its container */
    }

    /* Primary button styles */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease; /* Added transition for hover effect */
    }

    .btn-primary:hover {
        background-color: #6366f1;
        transform: translateY(-2px); /* Added hover transform */
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4); /* Added hover shadow */
    }

    /* Outline secondary button styles */
    .btn-outline-secondary {
        border-color: #d1d5db;
        color: #4b5563;
        font-weight: 500;
        border-radius: 0.75rem; /* Changed to 0.75rem for consistency with primary */
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Added subtle shadow for consistency */
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
        transform: translateY(-2px); /* Added hover transform */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Added hover shadow */
    }

    /* Specific text colors */
    .text-indigo-700 { color: #4338ca; }
    .text-indigo-500 { color: #6366f1; } /* Added for icon colors */


    /* Media queries for responsiveness */
    @media (max-width: 767.98px) {
        .text-4xl { font-size: 2.5rem !important; }
        /* Ensured buttons have enough spacing on small screens */
        .flex-wrap > .flex-grow {
            flex-grow: 1;
            min-width: 120px; /* Ensure buttons don't get too small */
        }
    }
</style>
@endpush
