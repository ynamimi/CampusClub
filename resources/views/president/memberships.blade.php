@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen">
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
            <a href="{{ route('president.memberships', $club->id ?? 1) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium active-nav-link">
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
    <div id="main-content" class="flex-1 flex flex-col md:ml-64">
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

                    <h1 class="text-center mb-10 text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md" style="margin-top:50px">Club Memberships</h1>

                    {{-- Search Members Card --}}
                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full">
                        <div class="card-body p-4">
                            <form method="GET" action="{{ route('president.memberships', $club->id) }}" class="row g-3 align-items-center">
                                <div class="col-12 col-md-8">
                                    <input type="text" name="search" placeholder="Search by name, email, course, or semester..." class="form-control form-control-lg icon-input-search" value="{{ request()->get('search') }}">
                                </div>
                                <div class="col-12 col-md-4">
                                    <button type="submit" class="btn btn-primary w-100 px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Current Members Card --}}
                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full">
                        <div class="card-header bg-gradient-purple text-white py-3" style="border-radius: 1rem 1rem 0 0 !important;">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i> Current Members</h5>
                        </div>
                        <div class="card-body p-0"> {{-- Removed padding from card-body as table will have its own padding --}}
                            @if($members->isEmpty())
                                <p class="text-center text-muted p-4 mb-0">No members found for this club.</p>
                            @else
                                <div class="table-responsive"> {{-- Added table-responsive for better mobile viewing --}}
                                    <table class="table table-hover mb-0"> {{-- Added table-hover for better UX --}}
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="text-primary">Full Name</th>
                                                <th scope="col" class="text-primary">Email</th>
                                                <th scope="col" class="text-primary">Course</th>
                                                <th scope="col" class="text-primary">Semester</th>
                                                <th scope="col" class="text-primary">Joined At</th>
                                                <th scope="col" class="text-primary">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($members as $member)
                                                <tr>
                                                    <td>{{ $member->fullname }}</td>
                                                    <td>{{ $member->email }}</td>
                                                    <td>{{ $member->course }}</td>
                                                    <td>{{ $member->semester }}</td>
                                                    <td>{{ $member->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="{{ route('president.editMember', ['member_id' => $member->id]) }}" class="btn btn-primary btn-sm me-2 rounded-xl">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <form action="{{ route('president.removeMember', ['member_id' => $member->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm rounded-xl" onclick="return confirm('Are you sure you want to remove this member?');">
                                                                <i class="fas fa-trash-alt"></i> Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
    // Load Tailwind CSS from CDN (Crucial for consistent design)
    if (!document.querySelector('script[src="https://cdn.tailwindcss.com"]')) {
        const tailwindScript = document.createElement('script');
        tailwindScript.src = "https://cdn.tailwindcss.com";
        document.head.appendChild(tailwindScript);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarCloseBtn = document.getElementById('sidebar-close-btn');

        function setSidebarAndButtonPosition() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarToggleBtn.classList.add('hidden'); // Hide toggle button on desktop
            } else {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
                sidebarToggleBtn.classList.remove('hidden'); // Show toggle button on mobile
            }
            updateToggleButtonPosition();
        }

        function updateToggleButtonPosition() {
            if (window.innerWidth >= 768) {
                sidebarToggleBtn.classList.add('hidden'); // Ensure hidden on desktop
                return;
            }

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebarToggleBtn.style.left = '1rem';
                sidebarToggleBtn.innerHTML = '<i class="fas fa-bars fa-lg"></i>';
            } else {
                sidebarToggleBtn.style.left = sidebar.offsetWidth + 'px';
                sidebarToggleBtn.innerHTML = '<i class="fas fa-times fa-lg"></i>';
            }
            sidebarToggleBtn.classList.remove('hidden'); // Always show when sidebar is being managed on mobile
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

    .btn-danger { /* For the "Remove" button */
        background-color: #ef4444; /* Red 500 */
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        background-color: #dc2626; /* Red 600 */
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
        color: white;
    }

    /* Gradient Backgrounds for Card Headers */
    .bg-gradient-blue {
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
    }
    .bg-gradient-purple {
        background: linear-gradient(135deg, var(--accent-purple), #a855f7); /* Purple 600 to Purple 500 */
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

    .icon-input-search {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3C!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.%3E%3Cpath fill='%236b7280' d='M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z'/%3E%3C/svg%3E");
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

    /* Table Specific Styles */
    .table {
        border-collapse: separate; /* Required for rounded corners on table */
        border-spacing: 0;
        /* border-radius: 8px; /* Apply to table itself, but not needed if card body is rounded */
        overflow: hidden; /* Ensures rounded corners are visible */
    }

    .table thead th {
        background-color: #f1f5f9; /* Light blue-gray for header */
        border-bottom: 2px solid var(--accent-blue);
        padding: 1rem;
        font-weight: 600;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #e0e7ff; /* Lighter indigo on hover */
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

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
        /* Adjust button alignment for small screens */
        .d-flex.flex-wrap.gap-2.justify-content-end {
            justify-content: flex-start !important;
        }
    }
</style>
@endpush
