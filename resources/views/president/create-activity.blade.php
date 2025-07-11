@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen"> {{-- Kept bg-gray-50 for the main background --}}
    {{-- Sidebar --}}
    <div id="sidebar" class="bg-white text-gray-800 w-64 space-y-8 py-10 px-6 fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-xl border-r border-gray-200 md:translate-x-0" style="margin-top:50px">
        <div class="flex items-center justify-between px-2 mb-10">
            <a href="#" class="text-gray-900 text-2xl font-extrabold flex items-center space-x-3 tracking-tight">
                <i class="fas fa-building fa-lg text-indigo-600"></i>
                <span>{{ $club->name ?? 'Club Name' }}</span>
            </a>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('president.dashboard', $club->id ?? 1) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-home fa-lg text-indigo-500"></i>
                <span>Dashboard Home</span>
            </a>
            <a href="{{ route('president.updateDetails', $club->id ?? 1) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-edit fa-lg text-indigo-500"></i>
                <span>Update Club Details</span>
            </a>
            <a href="{{ route('president.activities', $club->id ?? 1) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium active-nav-link">
                <i class="fas fa-calendar-alt fa-lg text-indigo-500"></i>
                <span>Manage Activities</span>
            </a>
            <a href="{{ route('president.memberships', $club->id ?? 1) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
                <i class="fas fa-users fa-lg text-indigo-500"></i>
                <span>View Memberships</span>
            </a>
            <button id="sidebar-close-btn" class="md:hidden block py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-100 hover:text-gray-700 flex items-center space-x-4 text-lg font-medium mt-4">
                <i class="fas fa-times fa-lg"></i>
                <span>Close Sidebar</span>
            </button>
        </nav>
    </div>

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 ease-in-out md:ml-64">
        <button id="sidebar-toggle-btn" class="fixed top-1/2 -translate-y-1/2 text-gray-700 focus:outline-none p-3 rounded-full bg-white shadow-lg z-40 hover:bg-gray-100 transition-all duration-300 ease-in-out">
            <i class="fas fa-bars fa-lg"></i>
        </button>

        <main class="flex-1 flex justify-start items-start">
            <div class="w-full px-4 py-8">
                <div class="dashboard-container">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md" style="margin-top:50px">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-6 rounded-lg shadow-md" style="margin-top:50px">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <h1 class="text-center mb-10 text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md" style="margin-top:50px">Create New Event</h1>

                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full">
                        <div class="card-header bg-gradient-blue text-white py-3" style="border-radius: 1rem 1rem 0 0 !important;">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> New Event Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('president.storeActivity', $club->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="col-span-full">
                                        <div class="mb-3 form-group">
                                            <label for="name" class="form-label text-primary fw-bold">Event Name</label>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg icon-input-tag" value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <div class="mb-3 form-group">
                                            <label for="event_date" class="form-label text-primary fw-bold">Event Date</label>
                                            <input type="date" name="event_date" id="event_date" class="form-control form-control-lg icon-input-calendar" value="{{ old('event_date') }}" required>
                                            @error('event_date')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="mb-3 form-group">
                                                <label for="start_time" class="form-label text-primary fw-bold">Start Time</label>
                                                <input type="time" name="start_time" id="start_time" class="form-control form-control-lg icon-input-clock" value="{{ old('start_time') }}" required>
                                            </div>
                                            @error('start_time')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <div class="mb-3 form-group">
                                                <label for="end_time" class="form-label text-primary fw-bold">End Time</label>
                                                <input type="time" name="end_time" id="end_time" class="form-control form-control-lg icon-input-hourglass" value="{{ old('end_time') }}" required>
                                            </div>
                                            @error('end_time')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <div class="mb-3 form-group">
                                            <label for="poster" class="form-label text-primary fw-bold">Poster Image</label>
                                            {{-- File input cannot easily have a background icon like text inputs. Keeping it standard. --}}
                                            <input type="file" name="poster" id="poster" class="form-control form-control-lg file-input-custom" accept="image/*">
                                            <small class="form-text text-muted mt-2 d-block">Upload an image for your event poster.</small>
                                            @error('poster')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <div class="mb-3 form-group">
                                            <label for="venue" class="form-label text-primary fw-bold">Event Venue</label>
                                            <input type="text" name="venue" id="venue" class="form-control form-control-lg icon-input-tag" value="{{ old('venue') }}" required>
                                            @error('venue')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <div class="mb-3 form-group">
                                            <label for="objectives" class="form-label text-primary fw-bold">Event Objectives</label>
                                            <textarea name="objectives" id="objectives" class="form-control form-control-lg icon-input-bullseye textarea-icon-align-top" rows="4" required>{{ old('objectives') }}</textarea>
                                            @error('objectives')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <div class="mb-3 form-group">
                                            <label for="activities" class="form-label text-primary fw-bold">Activities to Do</label>
                                            <textarea name="activities" id="activities" class="form-control form-control-lg icon-input-list-check textarea-icon-align-top" rows="4" required>{{ old('activities') }}</textarea>
                                            @error('activities')
                                                <span class="text-danger fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                        <i class="fas fa-plus-circle me-1"></i> Create Event
                                    </button>
                                    <a href="{{ route('president.activities', $club->id) }}" class="btn btn-outline-secondary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Activities
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Load Tailwind CSS from CDN (Crucial for updateDetails design)
    // Only add if not already in layouts.app or other shared script
    if (!document.querySelector('script[src="https://cdn.tailwindcss.com"]')) {
        const tailwindScript = document.createElement('script');
        tailwindScript.src = "https://cdn.tailwindcss.com";
        document.head.appendChild(tailwindScript);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle Functionality (Copied directly from activities.blade.php)
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarCloseBtn = document.getElementById('sidebar-close-btn');

        function setSidebarAndButtonPosition() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarToggleBtn.classList.add('hidden');
            } else {
                if (!sidebar.classList.contains('-translate-x-full')) {
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
                sidebarToggleBtn.innerHTML = '<i class="fas fa-times fa-lg"></i>';
            }
        }

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            updateToggleButtonPosition();
        }

        sidebarToggleBtn.addEventListener('click', toggleSidebar);
        sidebarCloseBtn.addEventListener('click', toggleSidebar);
        window.addEventListener('resize', setSidebarAndButtonPosition);

        // Initial setup
        setSidebarAndButtonPosition();
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Adopted Root Colors from activities.blade.php */
    :root {
        --primary-color: #4f46e5; /* Indigo 600 */
        --secondary-color: #3730a3; /* Indigo 800 */
        --accent-blue: #2563eb; /* Blue 600 */
        --accent-purple: #9333ea; /* Purple 600 */
        --accent-pink: #db2777; /* Pink 600 */
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

    /* Sidebar styles */
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
        color: #4b5563;
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

    /* Active nav link style for the current page */
    .active-nav-link {
        background-color: #e0e7ff !important; /* Indigo 100 */
        color: #4338ca !important; /* Indigo 700 */
        font-weight: 600 !important; /* Slightly bolder */
    }
    .active-nav-link i {
        color: #4338ca !important; /* Match text color */
    }


    #sidebar-toggle-btn {
        background-color: white;
        border-radius: 9999px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }

    #sidebar-toggle-btn:hover {
        background-color: #f3f4f6;
    }

    /* Dashboard Card Styling */
    .dashboard-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100% !important;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card .card-header {
        border-bottom: none;
        padding: 1rem 1.25rem;
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
        font-weight: 600;
        font-size: 1.125rem;
    }

    .dashboard-card .card-body {
        padding: 1.5rem;
        background-color: white;
        border-bottom-left-radius: 1rem !important;
        border-bottom-right-radius: 1rem !important;
    }

    /* Button Styles */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        background-color: #6366f1;
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border-color: #d1d5db;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 0.75rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Gradient Backgrounds for Card Headers */
    .bg-gradient-blue {
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
    }

    /* Specific to the main page title in activities.blade */
    .bg-indigo-600 {
        background-color: #4f46e5;
    }

    /* --- REVISED CUSTOM STYLES FOR INPUTS WITH INNER ICONS --- */

    .form-control-lg {
        padding: 0.75rem 1rem;
        padding-left: 2.75rem; /* Sufficient padding for the icon */
        border-radius: 0.5rem;
        border: 1px solid #d1d5db; /* Gray 300 */
        transition: all 0.2s ease-in-out;
        background-color: #f3f4f6; /* Light gray background */
        color: #1f2937; /* Default text color */
        background-repeat: no-repeat;
        background-position: left 0.75rem center; /* Position the icon */
        background-size: 1.25rem; /* Size of the icon */
    }

    .form-control-lg:focus {
        border-color: var(--primary-color); /* Indigo 600 */
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2); /* Ring shadow */
        outline: none;
        background-color: #ffffff; /* White background on focus */
    }

    /* Specific icons using Font Awesome's data-uri for background-image */
    /* Example: https://fontawesome.com/docs/web/dig-deeper/css-transforms#data-uri-icons */

    .icon-input-tag {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M0 96C0 78.3 14.3 64 32 64H480c17.7 0 32 14.3 32 32V416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V96zm64 96V320c0 17.7 14.3 32 32 32H288c17.7 0 32-14.3 32-32V192c0-17.7-14.3-32-32-32H96c-17.7 0-32 14.3-32 32zm256-32H448V320c0 17.7 14.3 32 32 32s32-14.3 32-32V160c0-17.7-14.3-32-32-32H352c-17.7 0-32 14.3-32 32zm-64-32h-64v-64c0-17.7-14.3-32-32-32s-32 14.3-32 32v64h-64c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32v-64h64c17.7 0 32-14.3 32-32s-14.3-32-32-32z'/%3E%3C/svg%3E");
    }
    .icon-input-calendar {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112c0-26.5 21.5-48 48-48H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zm64 80v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16zm128 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V272c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16zm-128 96v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V368c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16zm-64 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V368c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm256 0v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V368c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16z'/%3E%3C/svg%3E");
    }
    .icon-input-clock {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 232V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z'/%3E%3C/svg%3E");
    }
    .icon-input-hourglass {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 384 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M32 0C14.3 0 0 14.3 0 32V64 352c0 17.7 14.3 32 32 32H64v64c0 17.7 14.3 32 32 32H288c17.7 0 32-14.3 32-32V384h32c17.7 0 32-14.3 32-32V64 32c0-17.7-14.3-32-32-32H32zM96 288v64H288V288L224 192 96 288zM288 64H96V160L224 256 288 160V64z'/%3E%3C/svg%3E");
    }
    .icon-input-bullseye {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M224 0c70.7 0 128 57.3 128 128s-57.3 128-128 128S96 198.7 96 128S153.3 0 224 0zM432 288c-4.6 0-9.2-1-13.4-2.9C365.1 267.4 313.3 256 256 256H192c-57.3 0-109.1 11.4-162.6 29.1c-4.2 1.8-8.8 2.9-13.4 2.9C14.3 288 0 302.3 0 320V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V320c0-17.7-14.3-32-32-32z'/%3E%3C/svg%3E");
    }
    .icon-input-list-check {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M64 80c0-26.5 21.5-48 48-48H336c26.5 0 48 21.5 48 48V224H64V80zm0 176H448V432c0 26.5-21.5 48-48 48H112c-26.5 0-48-21.5-48-48V256zm352-72c0 13.3-10.7 24-24 24s-24-10.7-24-24V144c0-13.3 10.7-24 24-24s24 10.7 24 24v40z'/%3E%3C/svg%3E");
    }

    /* Adjust background position for textareas to align icon at top */
    .textarea-icon-align-top {
        background-position: left 0.75rem top 0.75rem; /* Align icon to top-left for textareas */
    }

    /* File input custom styling (remains mostly the same as it's a browser-controlled element) */
    .file-input-custom {
        padding-left: 1rem !important; /* No icon background image for file input directly */
        background-image: none !important; /* Ensure no background image for file inputs */
    }

    /* Form Label Styling */
    .form-label {
        font-weight: 600;
        color: #1f2937; /* Darker text for labels */
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Text Colors */
    .text-primary { color: var(--primary-color); }
    .text-dark { color: #1f2937; }
    .text-muted { color: #6b7280; }
    .text-indigo-500 { color: #6366f1; }
    .text-indigo-600 { color: #4f46e5; }
    .text-indigo-700 { color: #4338ca; }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .dashboard-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        .text-4xl { font-size: 2.5rem !important; }
        .text-3xl { font-size: 2rem !important; }
        .activity-list-item {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .activity-list-item .d-flex.flex-wrap.gap-2 {
            width: 100%;
            justify-content: flex-start;
            margin-top: 0.5rem;
        }
    }
</style>
@endpush
