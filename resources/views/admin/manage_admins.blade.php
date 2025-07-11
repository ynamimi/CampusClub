@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen">
    <div class="flex-1 flex flex-col items-center">
        <main class="w-full max-w-full px-4 py-8 md:px-8">
            {{-- Main content wrapper with consistent card styling --}}
            <div class="dashboard-container">

                {{-- Header for "Manage Admins", matching "Create/Edit Admin" style --}}
                <h1 class="text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md mb-8" style="margin-top:50px">Manage Admins</h1>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Add Admin Button (moved inside dashboard-container for consistent padding) --}}
                <div class="mb-8 flex justify-end"> {{-- Align to right --}}
                    <a href="{{ route('admin.createAdmin') }}"
                       class="btn btn-primary px-6 py-3 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 flex items-center text-base font-semibold">
                        <i class="fas fa-user-plus mr-2"></i> Create Admin
                    </a>
                </div>

                {{-- Admins Table Container, now styled as a dashboard-card --}}
                <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full mx-auto"> {{-- Added dashboard-card styling --}}
                    <div class="overflow-x-auto"> {{-- Keep overflow-x-auto for responsiveness --}}
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                            <thead class="bg-indigo-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider rounded-tl-lg">#</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($admins as $index => $admin)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-5 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap font-medium text-gray-900">{{ $admin->name }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap">{{ $admin->email }}</td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $admin->role ?? 'Admin' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('admin.editAdmin', $admin->id) }}"
                                           class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out mr-4 inline-flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.deleteAdmin', $admin->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this admin? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition duration-150 ease-in-out inline-flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-5 text-center text-gray-500 italic">No admin accounts found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Back Button --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-center">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-full px-6 py-3 text-gray-700 hover:bg-gray-200 transition duration-150 ease-in-out flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                    </a>
                </div>

            </div> {{-- End dashboard-container --}}
        </main>
    </div>
</div>
@endsection

@push('styles')
{{-- Bootstrap 5 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0V4LLanw2qksYuRlEzO+tcaEPQogQ0KaoIF2g/2g4k1c8C42n2k/K2Q+4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* Custom CSS for gradients and card styles */
    :root {
        --primary-color: #4f46e5; /* Indigo-600 */
        --secondary-color: #3730a3; /* Indigo-900 */
        --accent-blue: #4895ef; /* Adjusted to match your previous accent-blue */
        --accent-purple: #9333ea; /* Purple-600 */
        --accent-pink: #db2777; /* Pink-600 */
    }

    /* General body styling */
    body {
        font-family: 'Inter', sans-serif;
    }

    /* Main content card styling, applied to dashboard-container to wrap the entire content */
    .dashboard-container {
        background: linear-gradient(135deg, #ffffff 0%, #f1f8ff 100%);
        border-left: 4px solid var(--accent-blue);
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
        transition: all 0.3s ease;
        border-radius: 9999px; /* rounded-full */
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #9d4edd, #5a7af0); /* Slightly darker on hover */
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        color: white;
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

    /* Error message styling (if applicable, though not directly in this file) */
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

    /* Form control styling (if applicable, though not directly in this file) */
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        background-color: #f3f4f6;
        color: #1f2937;
        transition: all 0.2s ease;
    }

    .form-control-lg:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
    }

    /* Back button specific styling */
    .btn-outline-secondary {
        border: 1px solid #d1d5db;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 9999px; /* rounded-full */
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
        color: #495057;
    }

    /* Text colors */
    .text-gray-700 { color: #4b5563; }
    .text-gray-800 { color: #1f2937; }
    .text-indigo-700 { color: var(--primary-color); } /* Consistent with primary color */
    .text-blue-600 { color: var(--accent-blue); }
    .text-red-600 { color: #dc3545; }

    /* Table specific adjustments for length and width */
    .min-w-full {
        min-width: 100%; /* Ensures table takes full width of its container */
    }
    .px-6.py-4, .px-6.py-5 {
        padding-top: 1.25rem; /* py-5 equivalent */
        padding-bottom: 1.25rem; /* py-5 equivalent */
    }
    .px-6.py-3 {
        padding-top: 1rem; /* py-4 equivalent */
        padding-bottom: 1rem; /* py-4 equivalent */
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .dashboard-container {
            padding: 1rem; /* Smaller padding on mobile */
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .text-3xl { font-size: 2rem !important; }
        .btn-primary, .btn-outline-secondary {
            padding: 0.75rem 1.25rem; /* Smaller button padding on mobile */
            font-size: 0.9rem;
        }
        .px-6.py-4, .px-6.py-5 {
            padding-top: 0.75rem; /* Smaller vertical padding for table cells on mobile */
            padding-bottom: 0.75rem;
        }
        .px-6.py-3 {
            padding-top: 0.6rem; /* Smaller vertical padding for table headers on mobile */
            padding-bottom: 0.6rem;
        }
    }
</style>
@endpush
