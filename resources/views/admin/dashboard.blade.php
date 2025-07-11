@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen">
    <div class="flex-1 flex flex-col">
        <main class="flex-1 flex flex-col items-center">
            <div class="w-full max-w-full px-4 py-8 md:px-8">
                <div class="dashboard-container"> {{-- Main content wrapper with consistent card styling --}}

                    {{-- Success Message --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Header for "Admin Dashboard" --}}
                    <h1 class="text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md mb-8" style="margin-top:50px">
                        Admin Dashboard
                    </h1>

                    {{-- Search Bar and Action Buttons --}}
                    <div class="mb-10 w-full">
                        <div style="display: flex; justify-content: center;">
                             <form method="GET" action="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 8px;">
                                 <input type="text" name="search" placeholder="Search Club..."
                                     class="border px-4 py-2 rounded"
                                     style="width: 500px;" />
                                 <button type="submit" style="display: inline-block; background-color: #168dfc; color: white; padding: 8px 20px; font-size: 16px; text-decoration: none;">
                                     Search
                                 </button>
                             </form>
                         </div>
                     </div>

                        {{-- Action Buttons --}}
                        <div style="margin-top: 50px; text-align: center;">
                        <div style="display: inline-block;">
                           <a href="{{ route('admin.createClub') }}"
                                 style="display: inline-block; background-color: #5B2C91; color: white; padding: 12px 24px; font-size: 18px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none; margin-right: 12px;">
                                 <i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Create Club
                                 </a>
                                 <a href="{{ route('admin.manageAdmins') }}"
                                 style="background-color: #5B2C91; color: white; padding: 12px 24px; font-size: 18px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-decoration: none;">
                                  <i class="fas fa-users-cog mr-2"></i> Manage Admins
                           </a>
                        </div>
                    </div>

                    {{-- Clubs Container (Grid View) --}}
                    <div class="w-full mt-8">
                        {{-- Changed grid classes to always show 3 columns on medium and larger screens --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @forelse($clubs as $club)
                                <div class="w-full">
                                    <a href="{{ route('admin.clubMembers', $club->id) }}" class="group block h-full">
                                        {{-- Added min-h-[200px] for consistent card height, adjusted for no image --}}
                                        <div class="card h-full min-h-[200px] border-0 shadow-2xl dashboard-card rounded-2xl overflow-hidden flex flex-col">
                                            {{-- Club Info --}}
                                            <div class="p-4 flex-1 flex flex-col">
                                                {{-- Added overflow-hidden and line-clamp-2 for consistent name display --}}
                                                <h3 class="text-base font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-2">{{ $club->name }}</h3>
                                                {{-- Replaced description with advisor name --}}
                                                <p class="text-sm text-gray-600 mb-3 flex-1">Advisor: <span class="font-medium">{{ $club->advisor_name ?? 'N/A' }}</span></p>
                                                <div class="flex justify-between text-xs text-gray-500 mt-auto"> {{-- mt-auto pushes to bottom --}}
                                                    <span><i class="fas fa-users mr-1"></i>{{ $club->registrations_count ?? 0 }} Members</span>

                                                    <span>Created {{ $club->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-10 text-gray-500 italic text-lg">
                                    No clubs found.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if($clubs->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $clubs->links() }}
                    </div>
                    @endif
                </div>
            </div>
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
    .card.dashboard-card { /* Target specifically cards with dashboard-card class */
        background: #ffffff;
        border-radius: 1rem !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Added transition for hover */
    }

    .card.dashboard-card:hover {
        transform: translateY(-4px); /* Subtle lift on hover */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); /* Slightly stronger shadow on hover */
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

    /* Error message styling (if applicable) */
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

    /* Form control styling (for search bar) */
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        background-color: #f3f4f6; /* gray-100 */
        color: #1f2937; /* gray-800 */
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
    .text-indigo-700 { color: var(--primary-color); }
    .text-blue-600 { color: var(--accent-blue); }
    .text-red-600 { color: #dc3545; }

    /* Table specific adjustments (if applicable, though not directly in this file) */
    .min-w-full {
        min-width: 100%;
    }
    .px-6.py-4, .px-6.py-5 {
        padding-top: 1.25rem;
        padding-bottom: 1.25rem;
    }
    .px-6.py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Club Card specific styling */
    .club-card { /* This class is no longer explicitly used, replaced by .card.dashboard-card */
        text-decoration: none;
    }

    /* Responsive grid adjustments */
    .grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr); /* Default to 1 column on extra small screens */
        gap: 1.5rem; /* gap-6 */
    }

    @media (min-width: 640px) { /* sm breakpoint */
        .grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 768px) { /* md breakpoint */
        .grid {
            grid-template-columns: repeat(3, 1fr); /* Consistent 3 columns from this size up */
        }
    }
    @media (min-width: 1024px) { /* lg breakpoint */
        .grid {
            grid-template-columns: repeat(3, 1fr); /* Consistent 3 columns from this size up */
        }
    }
    @media (min-width: 1280px) { /* xl breakpoint */
        .grid {
            grid-template-columns: repeat(3, 1fr); /* Consistent 3 columns from this size up */
        }
    }

    /* Added line-clamp utility for multi-line text truncation */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive Adjustments for overall layout */
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
        .flex-grow.sm\:flex-grow-0 {
            flex-grow: 1; /* Ensure buttons take full width on mobile */
        }
    }
</style>
@endpush
