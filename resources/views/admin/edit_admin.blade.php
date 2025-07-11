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

                    {{-- Header for "Edit Admin", matching "Create New Admin" style --}}
                    <h1 class="text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md mb-8" style="margin-top:50px">Edit Admin</h1>

                    {{-- Form container, now using 'dashboard-card' for elevated look and consistent padding --}}
                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full mx-auto">
                        <form action="{{ route('admin.updateAdmin', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full"> {{-- Added w-full for grid consistency --}}
                                <div class="col-span-1 md:col-span-2"> {{-- Name field takes full width on mobile, full width on desktop --}}
                                    <div class="mb-4">
                                        {{-- Labels now include icons and text-indigo-700 font-bold text-lg mb-2 for consistency --}}
                                        <label for="name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-user fa-lg me-2 text-indigo-500"></i> Full Name
                                        </label>
                                        {{-- Input fields consistently use text-gray-800 bg-gray-100 placeholder-gray-500 --}}
                                        <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('name', $admin->name) }}" required>
                                        @error('name')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-2"> {{-- Email field takes full width on mobile, full width on desktop --}}
                                    <div class="mb-4">
                                        <label for="email" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-envelope fa-lg me-2 text-indigo-500"></i> Email Address
                                        </label>
                                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" value="{{ old('email', $admin->email) }}" required>
                                        @error('email')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4"> {{-- Role field takes full width --}}
                                <label for="role" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                    <i class="fas fa-user-cog fa-lg me-2 text-indigo-500"></i> Admin Role
                                </label>
                                <select id="role" name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100">
                                    <option value="super_admin" {{ (old('role', $admin->role) == 'super_admin') ? 'selected' : '' }}>Super Admin</option>
                                    <option value="admin" {{ (old('role', $admin->role) == 'admin') ? 'selected' : '' }}>Regular Admin</option>
                                </select>
                                @error('role')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-wrap gap-4 mt-6"> {{-- Changed justify-end to flex-wrap and gap-4 for consistency with Club form --}}
                                <button type="submit" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-save me-2"></i> Update Admin
                                </button>
                                <a href="{{ route('admin.manageAdmins') }}" class="btn btn-outline-secondary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
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
        --accent-blue: #4895ef; /* Adjusted to match your previous accent-blue */
        --accent-purple: #9333ea;
        --accent-pink: #db2777;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        background: linear-gradient(135deg, #ffffff 0%, #f1f8ff 100%); /* Matches the card background */
        border-left: 4px solid var(--accent-blue); /* Consistent left border */
        border-radius: 1rem; /* rounded-2xl */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* shadow-2xl */
        padding: 2rem; /* Consistent padding */
        margin-top: 2rem; /* Space from top */
        margin-bottom: 2rem; /* Space from bottom */
    }

    /* Header styling */
    .bg-indigo-600 {
        background-color: var(--primary-color); /* Matches primary color */
    }

    /* Styles for the elevated card effect, previously called 'dashboard-card' */
    .dashboard-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        width: 100% !important; /* Ensure it takes full width of its container */
    }

    /* Primary button styles */
    .btn-primary {
        background: linear-gradient(90deg, var(--accent-purple), var(--primary-color)); /* Gradient for primary buttons */
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #9d4edd, #5a7af0); /* Slightly darker on hover */
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        color: white;
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

    /* Success message background and border */
    .alert-success {
        background-color: #e6ffe6;
        border-color: #a3e6a3;
        color: #1a7a1a;
    }
    .alert-success .fas {
        color: #28a745;
    }
    .alert-success .btn-close {
        filter: invert(30%) sepia(80%) saturate(1500%) hue-rotate(80deg) brightness(90%) contrast(100%);
    }

    /* Error message styling */
    .bg-red-50 {
        background-color: #ffe6e6;
    }
    .border-red-200 {
        border-color: #e6a3a3;
    }
    .text-red-700 {
        color: #a71a1a;
    }
    .text-red-500 {
        color: #dc3545;
    }

    /* Form control styling */
    .w-full.px-4.py-3.border.border-gray-300.rounded-lg.focus\:ring-2.focus\:ring-indigo-500.focus\:border-transparent.transition.duration-200.text-gray-800.bg-gray-100.placeholder-gray-500 {
        padding: 0.75rem 1rem; /* py-3 px-4 */
        border-radius: 0.5rem; /* rounded-lg */
        border: 1px solid #d1d5db; /* gray-300 */
        background-color: #f3f4f6; /* gray-100 */
        color: #1f2937; /* gray-800 */
        transition: all 0.2s ease;
    }

    .w-full.px-4.py-3.border.border-gray-300.rounded-lg.focus\:ring-2.focus\:ring-indigo-500.focus\:border-transparent.transition.duration-200.text-gray-800.bg-gray-100.placeholder-gray-500:focus {
        border-color: #6366f1; /* indigo-500 */
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25); /* ring-2 indigo-500 */
    }

    /* Specific text colors */
    .text-indigo-700 { color: #4338ca; }
    .text-indigo-500 { color: #6366f1; }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .dashboard-container {
            padding: 1rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .text-4xl { font-size: 2.5rem !important; }
        .btn-primary, .btn-outline-secondary {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
        .grid-cols-1.md\:grid-cols-2 > div {
            width: 100%; /* Ensure columns stack on mobile */
        }
    }
</style>
@endpush
