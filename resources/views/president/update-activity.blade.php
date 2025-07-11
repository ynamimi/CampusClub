@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen"> {{-- Consistent background and font --}}
    {{-- Sidebar (Copied from updateDetails.blade.php) --}}
    <div id="sidebar" class="bg-white text-gray-800 w-64 space-y-8 py-10 px-6 fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-xl border-r border-gray-200 md:translate-x-0" style="margin-top:50px">
        <div class="flex items-center justify-between px-2 mb-10">
            <a href="#" class="text-gray-900 text-2xl font-extrabold flex items-center space-x-3 tracking-tight">
                <i class="fas fa-building fa-lg text-indigo-600"></i>
                <span>{{ $activity->club->name ?? 'Club Name' }}</span> {{-- Use activity's club name --}}
            </a>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('president.dashboard', $activity->club_id) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-home fa-lg text-indigo-500"></i>
                <span>Dashboard Home</span>
            </a>
            <a href="{{ route('president.updateDetails', $activity->club_id) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-edit fa-lg text-indigo-500"></i>
                <span>Update Club Details</span>
            </a>
            <a href="{{ route('president.activities', $activity->club_id) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-calendar-alt fa-lg text-indigo-500"></i>
                <span>Manage Activities</span>
            </a>
            <a href="{{ route('president.memberships', $activity->club_id) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-users fa-lg text-indigo-500"></i>
                <span>View Memberships</span>
            </a>
            <button id="sidebar-close-btn" class="md:hidden block py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-100 hover:text-gray-700 flex items-center space-x-4 text-lg font-medium mt-4">
                <i class="fas fa-times fa-lg"></i>
                <span>Close Sidebar</span>
            </button>
        </nav>
    </div>

    {{-- Main Content Area --}}
    <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 ease-in-out md:ml-64">
        {{-- Sidebar Toggle Button --}}
        <button id="sidebar-toggle-btn" class="fixed top-1/2 -translate-y-1/2 text-gray-700 focus:outline-none p-3 rounded-full bg-white shadow-lg z-40 hover:bg-gray-100 transition-all duration-300 ease-in-out">
            <i class="fas fa-bars fa-lg"></i>
        </button>

        <main class="flex-1 flex justify-start items-start">
            <div class="w-full px-4 py-8">
                <div class="dashboard-container"> {{-- This container will get Tailwind styles --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md" style="margin-top:50px">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-6 rounded-lg shadow-md" style="margin-top:50px">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <h1 class="text-center mb-10 text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md" style="margin-top:50px">Update Event Details</h1>

                    <h1 class="text-center mb-4 text-indigo-700 font-extrabold text-3xl">Manage Event Information</h1>

                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full">
                        <form action="{{ route('president.activities.storeUpdate', $activity->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST') {{-- Or @method('PUT') for RESTful update --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                <div class="col-span-full"> {{-- Full width for event name --}}
                                    <div class="mb-4">
                                        <label for="name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-tag fa-lg me-2 text-indigo-500"></i> Event Name
                                        </label>
                                        <input type="text" name="name" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('name') border-red-500 @enderror" value="{{ old('name', $activity->name) }}" required>
                                        @error('name')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-1">
                                    <div class="mb-4">
                                        <label for="event_date" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-calendar-day fa-lg me-2 text-indigo-500"></i> Event Date
                                        </label>
                                        <input type="date" name="event_date" id="event_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('event_date') border-red-500 @enderror" value="{{ old('event_date', $activity->event_date->format('Y-m-d')) }}" required>
                                        @error('event_date')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-1 grid grid-cols-2 gap-6">
                                    <div>
                                        <div class="mb-4">
                                            <label for="start_time" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-clock fa-lg me-2 text-indigo-500"></i> Start Time
                                            </label>
                                            <input type="time" name="start_time" id="start_time" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('start_time') border-red-500 @enderror" value="{{ old('start_time', $activity->start_time) }}" required>
                                            @error('start_time')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mb-4">
                                            <label for="end_time" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                                <i class="fas fa-hourglass-end fa-lg me-2 text-indigo-500"></i> End Time
                                            </label>
                                            <input type="time" name="end_time" id="end_time" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('end_time') border-red-500 @enderror" value="{{ old('end_time', $activity->end_time) }}" required>
                                            @error('end_time')
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <div class="mb-4">
                                        <label for="poster" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-image fa-lg me-2 text-indigo-500"></i> Poster Image
                                        </label>
                                        <input type="file" name="poster" id="poster" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-gray-800 bg-gray-100 @error('poster') border-red-500 @enderror" accept="image/*">
                                        @if($activity->poster)
                                            <small class="text-gray-600 mt-2 block">Current Poster: <a href="{{ asset('storage/' . $activity->poster) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">View Current Poster</a></small>
                                            <img src="{{ asset('storage/' . $activity->poster) }}" alt="Poster Image" class="rounded mt-2" style="max-height: 150px;">
                                        @else
                                            <small class="text-gray-600 mt-2 block">No poster image uploaded yet.</small>
                                        @endif
                                        @error('poster')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <div class="mb-4">
                                        <label for="venue" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-map-marker-alt fa-lg me-2 text-indigo-500"></i> Venue
                                        </label>
                                        <input type="text" name="venue" id="venue" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('venue') border-red-500 @enderror" value="{{ old('venue', $activity->venue ?? '') }}" placeholder="e.g., Lecture Hall, Anjung Siswa">
                                        @error('venue')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <div class="mb-4">
                                        <label for="objectives" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-bullseye fa-lg me-2 text-indigo-500"></i> Event Objectives
                                        </label>
                                        <textarea name="objectives" id="objectives" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('objectives') border-red-500 @enderror" rows="4" required>{{ old('objectives', $activity->objectives) }}</textarea>
                                        @error('objectives')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <div class="mb-4">
                                        <label for="activities" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-list-check fa-lg me-2 text-indigo-500"></i> Activities to Do
                                        </label>
                                        <textarea name="activities" id="activities" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500 @error('activities') border-red-500 @enderror" rows="4" required>{{ old('activities', $activity->activities) }}</textarea>
                                        @error('activities')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-4 mt-6">
                                <a href="{{ route('president.activities', $activity->club_id) }}" class="btn btn-outline-secondary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Activities
                                </a>
                                @if($activity->id)
                                    <a href="{{ route('president.generatePDF', $activity->id) }}" class="btn btn-purple px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                        <i class="fas fa-file-pdf me-2"></i> Generate PDF
                                    </a>
                                @endif
                                <button type="submit" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-save me-2"></i> Update Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

---

@push('scripts')
<script>
    // Load Tailwind CSS from CDN
    // This script ensures Tailwind is loaded if not already included in layouts.app
    const tailwindScript = document.createElement('script');
    tailwindScript.src = "https://cdn.tailwindcss.com";
    document.head.appendChild(tailwindScript);

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle Functionality (Copied from updateDetails.blade.php)
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarCloseBtn = document.getElementById('sidebar-close-btn');

        function setSidebarAndButtonPosition() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarToggleBtn.classList.add('hidden');
                document.body.classList.add('sidebar-open');
            } else {
                if (!document.body.classList.contains('sidebar-open')) {
                    sidebar.classList.add('-translate-x-full');
                }
                sidebarToggleBtn.classList.remove('hidden');
            }
            updateToggleButtonPosition();
        }

        function updateToggleButtonPosition() {
            if (window.innerWidth >= 768) return;

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebarToggleBtn.style.left = '1rem';
                sidebarToggleBtn.innerHTML = '<i class="fas fa-bars fa-lg"></i>';
            } else {
                sidebarToggleBtn.style.left = sidebar.offsetWidth + 'px';
                sidebarToggleBtn.innerHTML = '&lt;'; // Chevron left
            }
        }

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            document.body.classList.toggle('sidebar-open');
            updateToggleButtonPosition();
        }

        sidebarToggleBtn.addEventListener('click', toggleSidebar);
        sidebarCloseBtn.addEventListener('click', toggleSidebar);
        window.addEventListener('resize', setSidebarAndButtonPosition);

        setSidebarAndButtonPosition();
    });
</script>
@endpush

---

@push('styles')
{{-- Include Bootstrap and Font Awesome if not already in layouts.app --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Tailwind-inspired color palette for consistency */
    :root {
        --primary-color: #4f46e5; /* Indigo 600 */
        --secondary-color: #3730a3; /* Indigo 800 */
        --accent-blue: #2563eb; /* Blue 600 */
        --accent-purple: #9333ea; /* Purple 600 */
        --accent-pink: #db2777; /* Pink 600 */
    }

    body {
        font-family: 'Inter', sans-serif; /* Consistent font */
    }

    /* Override Bootstrap container for full width with Tailwind */
    .dashboard-container {
        background: #f9fafb; /* Light gray background */
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Sidebar styles (Copied from updateDetails.blade.php) */
    #sidebar {
        background-color: white;
        border-right: 1px solid #e5e7eb;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    #sidebar .text-2xl {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    #sidebar nav a {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        color: #4b5563; /* Gray 700 */
    }

    #sidebar nav a:hover {
        background-color: #e0e7ff; /* Indigo 100 */
        color: #4338ca; /* Indigo 700 */
    }

    #sidebar nav a i {
        color: #6366f1; /* Indigo 500 */
        transition: color 0.2s ease-in-out;
    }

    #sidebar nav a:hover i {
        color: #4338ca; /* Indigo 700 */
    }

    #sidebar nav a.hover\:bg-red-100:hover {
        background-color: #fee2e2; /* Red 100 */
        color: #b91c1c; /* Red 700 */
    }

    #sidebar nav a.hover\:bg-red-100:hover i {
        color: #ef4444; /* Red 500 */
    }

    #sidebar-toggle-btn {
        background-color: white;
        border-radius: 9999px; /* Full rounded */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }

    #sidebar-toggle-btn:hover {
        background-color: #f3f4f6; /* Gray 100 */
    }

    /* Card styles (Copied from updateDetails.blade.php) */
    .dashboard-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* Larger shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100% !important;
    }

    .dashboard-card:hover {
        transform: translateY(-4px); /* More pronounced lift */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    /* Form input styles (adapted from updateDetails.blade.php) */
    .w-full.px-4.py-3.border.border-gray-300.rounded-lg.focus\:ring-2.focus\:ring-indigo-500.focus\:border-transparent.transition.duration-200.text-gray-800.bg-gray-100.placeholder-gray-500 {
        /* These classes are directly from updateDetails.blade.php for consistency */
    }

    /* File input specific styling (adapted from updateDetails.blade.php) */
    input[type="file"].file\:mr-4.file\:py-2.file\:px-4.file\:rounded-full.file\:border-0.file\:text-sm.file\:font-semibold.file\:bg-indigo-50.file\:text-indigo-700.hover\:file\:bg-indigo-100 {
        /* These classes are directly from updateDetails.blade.php for consistency */
    }

    /* Buttons (adapted from updateDetails.blade.php) */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem; /* Rounded-xl in Tailwind */
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        background-color: #6366f1; /* Slightly lighter indigo on hover */
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border-color: #d1d5db; /* Gray 300 */
        color: #4b5563; /* Gray 700 */
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 0.75rem; /* Rounded-xl for consistency */
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb; /* Gray 200 */
        border-color: #9ca3af; /* Gray 400 */
    }

    .btn-purple {
        background-color: var(--accent-purple); /* Using the purple accent color */
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(147, 51, 234, 0.3);
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        background-color: #a855f7; /* Slightly lighter purple on hover */
        box-shadow: 0 6px 15px rgba(147, 51, 234, 0.4);
        color: white;
    }

    /* Text Colors (Copied for consistency) */
    .text-indigo-700 { color: #4338ca; }
    .text-pink-600 { color: #db2777; }
    .text-blue-600 { color: #2563eb; }
    .text-red-500 { color: #ef4444; } /* For error messages */
    .text-gray-600 { color: #4b5563; } /* For small descriptive text */

    /* Image preview styling */
    img[alt="Poster Image"] {
        border: 1px solid #e0eeef; /* Light border */
        padding: 5px;
        max-width: 100%; /* Ensure it's responsive */
        height: auto;
    }

    /* Responsive adjustments (Copied from updateDetails.blade.php) */
    @media (max-width: 767.98px) {
        .dashboard-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        .text-4xl { font-size: 2.5rem !important; }
        .text-3xl { font-size: 2rem !important; }
        .dashboard-nav-card .card-body { padding: 1rem; }
        .dashboard-nav-card i { font-size: 2.5rem !important; }
    }
</style>
@endpush
