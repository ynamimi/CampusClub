@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen"> {{-- Adopted from updateDetails --}}
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
            <a href="{{ route('president.activities', $club->id ?? 1) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
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
                <div class="dashboard-container"> {{-- This container is still used for content spacing/background within the main content area --}}
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

                    <h1 class="text-center mb-10 text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md" style="margin-top:50px">Manage Activities</h1>

                    <h1 class="text-center mb-4 text-indigo-700 font-extrabold text-3xl">Club Events Management</h1> {{-- Renamed for clarity --}}

                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full"> {{-- Updated card styles from updateDetails --}}
                        <div class="card-header bg-gradient-blue text-white py-3 rounded-top-lg-0 rounded-top-md-0 rounded-top-sm-0" style="border-radius: 1rem 1rem 0 0 !important;"> {{-- Adjusted border-radius for consistency --}}
                            <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Upcoming Events</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($upcomingActivities->isEmpty())
                                <p class="text-center text-muted p-4 mb-0">No upcoming events.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach($upcomingActivities as $activity)
                                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 px-4 activity-list-item">
                                            <div class="mb-2 mb-md-0">
                                                <h6 class="mb-1 text-dark">{{ $activity->name }}</h6>
                                                <span class="text-muted small"><i class="fas fa-calendar-day me-1"></i> {{ $activity->event_date->format('F d, Y') }}</span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('president.activities.update', $activity->id) }}" class="btn btn-primary btn-sm"> {{-- Changed to btn-primary --}}
                                                    <i class="fas fa-edit"></i> Update Details
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteActivityModal" data-activity-id="{{ $activity->id }}" data-activity-name="{{ $activity->name }}"> {{-- Changed to btn-danger --}}
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full"> {{-- Updated card styles from updateDetails --}}
                        <div class="card-header bg-gradient-purple text-white py-3 rounded-top-lg-0 rounded-top-md-0 rounded-top-sm-0" style="border-radius: 1rem 1rem 0 0 !important;"> {{-- Adjusted border-radius for consistency --}}
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i> Past Events</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($pastActivities->isEmpty())
                                <p class="text-center text-muted p-4 mb-0">No past events.</p>
                            @else
                                <ul class="list-group list-group-flush">
                                    @foreach($pastActivities as $activity)
                                        <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 px-4 activity-list-item">
                                            <div class="mb-2 mb-md-0">
                                                <h6 class="mb-1 text-dark">{{ $activity->name }}</h6>
                                                <span class="text-muted small"><i class="fas fa-calendar-day me-1"></i> {{ $activity->event_date->format('F d, Y') }}</span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('president.activities.update', $activity->id) }}" class="btn btn-primary btn-sm"> {{-- Changed to btn-primary --}}
                                                    <i class="fas fa-edit"></i> Update Details
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteActivityModal" data-activity-id="{{ $activity->id }}" data-activity-name="{{ $activity->name }}"> {{-- Changed to btn-danger --}}
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-6"> {{-- Adjusted margin for consistency --}}
                        <a href="{{ route('president.createActivity', $club->id) }}" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow"> {{-- Adopted btn-primary style --}}
                            <i class="fas fa-plus-circle me-2"></i> Create New Event
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- Delete Activity Modal (remains the same as its styling is driven by Bootstrap and common styles) --}}
<div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-labelledby="deleteActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-purple text-white">
                <h5 class="modal-title" id="deleteActivityModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteActivityForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center py-4">
                    <p class="lead mb-3">Are you sure you want to delete the event "<strong id="activityNamePlaceholder"></strong>"?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Load Tailwind CSS from CDN (Crucial for updateDetails design)
    const tailwindScript = document.createElement('script');
    tailwindScript.src = "https://cdn.tailwindcss.com";
    document.head.appendChild(tailwindScript);

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle Functionality (Copied directly from updateDetails)
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
                sidebarToggleBtn.innerHTML = '&lt;';
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

        // Modal functionality for delete activity
        var deleteActivityModal = document.getElementById('deleteActivityModal');
        deleteActivityModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var activityId = button.getAttribute('data-activity-id');
            var activityName = button.getAttribute('data-activity-name');

            var activityNamePlaceholder = deleteActivityModal.querySelector('#activityNamePlaceholder');
            var deleteActivityForm = document.getElementById('deleteActivityForm');

            activityNamePlaceholder.textContent = activityName;
            deleteActivityForm.action = `/president/{{ $club->id }}/activities/${activityId}`;
        });
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Adopted Root Colors from updateDetails */
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

    /* Keep this dashboard-container for the main content block's background,
       but the overall page background is handled by the parent flex div. */
    .dashboard-container {
        background: #f9fafb;
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Sidebar styles - Copied directly from updateDetails */
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
        background-color: #e0e7ff;
        color: #4338ca;
    }

    #sidebar nav a i {
        color: #6366f1;
        transition: color 0.2s ease-in-out;
    }

    #sidebar nav a:hover i {
        color: #4338ca;
    }

    #sidebar nav a.hover\:bg-red-100:hover {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    #sidebar nav a.hover\:bg-red-100:hover i {
        color: #ef4444;
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

    /* Dashboard Card Styling - Adapted from updateDetails */
    .dashboard-card {
        background: #ffffff;
        border-radius: 1rem !important; /* Larger border-radius */
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* Stronger shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100% !important; /* Ensure it takes full width */
    }

    .dashboard-card:hover {
        transform: translateY(-4px); /* Increased lift */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card .card-header {
        /* This applies to custom gradients, ensure it's still prominent */
        border-bottom: none;
        padding: 1rem 1.25rem;
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
        font-weight: 600;
        font-size: 1.125rem;
    }

    .dashboard-card .card-body {
        padding: 1.5rem; /* Increased padding */
        background-color: white;
        border-bottom-left-radius: 1rem !important;
        border-bottom-right-radius: 1rem !important;
    }

    /* Navigation Card Specific Styles (Now within sidebar, but kept for consistency if used elsewhere) */
    .dashboard-nav-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* Match main card shadow */
    }

    .dashboard-nav-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border-color: #a5b4fc;
    }

    .dashboard-nav-card .card-body {
        padding: 1.25rem;
    }

    .dashboard-nav-card i {
        color: #4f46e5;
        transition: color 0.3s ease;
    }

    /* Button Styles - Adapted from updateDetails */
    .btn-primary {
        background-color: var(--primary-color); /* Use variable for consistency */
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem; /* Larger border-radius */
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        background-color: #6366f1; /* Slightly different hover color */
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border-color: #d1d5db;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 0.5rem;
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
    }

    /* Gradient Buttons for card headers (specific to activities page) */
    .bg-gradient-blue {
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
    }
    .btn-gradient-blue { /* Keeping this for the 'Create New Event' button if needed */
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }
    .btn-gradient-blue:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }

    .bg-gradient-purple {
        background: linear-gradient(135deg, var(--accent-purple), #9d4edd);
    }
    /* btn-gradient-purple was for delete buttons, now using btn-danger */
    .btn-danger {
        background-color: #dc3545; /* Bootstrap default danger */
        border-color: #dc3545;
        color: white;
        font-weight: 600;
        border-radius: 0.75rem; /* Match other buttons */
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }


    /* Text Colors - Adopted from updateDetails */
    .text-primary { color: var(--primary-color); }
    .text-dark { color: #1f2937; }
    .text-muted { color: #6b7280; }
    .text-secondary { color: #9ca3af; }
    .text-indigo-700 { color: #4338ca; }
    .text-pink-600 { color: #db2777; }
    .text-blue-600 { color: #2563eb; }

    .icon-hover-effect {
        transition: transform 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .icon-hover-effect:hover {
        transform: translateY(-2px) scale(1.1);
        color: #e0e7ff;
    }

    /* Activity List Specific Styles - Keep for list items */
    .activity-list-item {
        border-top: 1px solid #e9ecef;
        transition: background-color 0.3s ease;
    }

    .activity-list-item:first-child {
        border-top: none;
    }

    .activity-list-item:hover {
        background-color: #e9f5ff;
    }

    /* Responsive Adjustments - Adapted from updateDetails */
    @media (max-width: 767.98px) {
        .dashboard-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        .text-4xl { font-size: 2.5rem !important; }
        .text-3xl { font-size: 2rem !important; }
        /* Removed dashboard-nav-card responsive styles as they are now in sidebar */
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

    @media (orientation: landscape) {
        /* No specific landscape adjustments needed from updateDetails for the main content */
    }
</style>
@endpush
