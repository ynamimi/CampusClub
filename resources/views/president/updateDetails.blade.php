@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen"> {{-- Kept bg-gray-50 for the main background --}}
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

                    <h1 class="text-center mb-10 text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md" style="margin-top:50px">Update Club Details</h1>

                    <h1 class="text-center mb-4 text-indigo-700 font-extrabold text-3xl">Manage Club Information</h1>

                    <div class="card mb-5 border-0 shadow-2xl dashboard-card p-6 w-full">
                        <form method="POST" action="{{ route('president.updateDetails.submit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="club_name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-tag fa-lg me-2 text-indigo-500"></i> Club Name
                                        </label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="club_name" name="club_name" value="{{ old('club_name', $club->name ?? '') }}" required>
                                        @error('club_name')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="club_acronym" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-compress-alt fa-lg me-2 text-indigo-500"></i> Club Acronym
                                        </label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="club_acronym" name="club_acronym" value="{{ old('club_acronym', $club->acronym ?? '') }}">
                                        @error('club_acronym')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <div class="mb-4">
                                        <label for="club_description" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-align-left fa-lg me-2 text-indigo-500"></i> Club Description
                                        </label>
                                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="club_description" name="club_description" rows="4" required>{{ old('club_description', $club->description ?? '') }}</textarea>
                                        @error('club_description')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="club_type" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-bars fa-lg me-2 text-indigo-500"></i> Club Type
                                        </label>
                                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100" id="club_type" name="club_type" required>
                                            <option value="public" {{ old('club_type', $club->type ?? '') == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="faculty" {{ old('club_type', $club->type ?? '') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                        </select>
                                        @error('club_type')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="club_image" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-image fa-lg me-2 text-indigo-500"></i> Club Profile Image
                                        </label>

                                        <input type="file"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-gray-800 bg-gray-100"
                                            id="club_image" name="club_image">

                                        @if (!empty($club->image))
                                            <small class="text-gray-600 mt-2 block">
                                                Current Image:
                                                <a href="{{ Storage::url($club->image) }}" target="_blank"
                                                    class="text-indigo-600 font-bold hover:underline">View Current Image</a>
                                            </small>
                                        @else
                                            <small class="text-gray-600 mt-2 block">No profile image uploaded yet.</small>
                                        @endif

                                        @error('club_image')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <div class="mb-4">
                                        <label for="org_chart" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-sitemap fa-lg me-2 text-indigo-500"></i> Organizational Chart
                                        </label>
                                        <input type="file" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 text-gray-800 bg-gray-100" id="org_chart" name="org_chart">
                                        @if(isset($club->org_chart) && $club->org_chart)
                                            <small class="text-gray-600 mt-2 block">Current Chart: <a href="{{ asset('storage/' . $club->org_chart) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">View Current Chart</a></small>
                                        @else
                                            <small class="text-gray-600 mt-2 block">No organizational chart uploaded yet.</small>
                                        @endif
                                        @error('org_chart')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="advisor_name" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-user-graduate fa-lg me-2 text-indigo-500"></i> Advisor Name
                                        </label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="advisor_name" name="advisor_name" value="{{ old('advisor_name', $club->advisor_name ?? '') }}" placeholder="Enter advisor's name">
                                        @error('advisor_name')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-span-full mt-4">
                                    <h5 class="text-indigo-700 font-extrabold border-b pb-2 mb-4 text-xl">Contact Information & Social Media</h5>
                                </div>

                                {{-- New Email Input Field --}}
                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="contact_email" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fas fa-envelope fa-lg me-2 text-indigo-500"></i> Club Email
                                        </label>
                                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="contact_email" name="contact_email" value="{{ old('contact_email', $club->email ?? '') }}" placeholder="club@example.com">
                                        @error('contact_email')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="instagram_link" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fab fa-instagram fa-lg me-2 text-pink-600"></i> Instagram Link
                                        </label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="instagram_link" name="instagram_link" value="{{ old('instagram_link', $club->instagram_link ?? '') }}" placeholder="https://instagram.com/yourclub">
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
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="x_link" name="x_link" value="{{ old('x_link', $club->x_link ?? '') }}" placeholder="https://twitter.com/yourclub">
                                        @error('x_link')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="mb-4">
                                        <label for="tiktok_link" class="flex items-center text-indigo-700 font-bold text-lg mb-2">
                                            <i class="fab fa-tiktok fa-lg me-2 text-dark"></i> TikTok Link
                                        </label>
                                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 text-gray-800 bg-gray-100 placeholder-gray-500" id="tiktok_link" name="tiktok_link" value="{{ old('tiktok_link', $club->tiktok_link ?? '') }}" placeholder="https://tiktok.com/@yourclub">
                                        @error('tiktok_link')
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-4 mt-6">
                                <button type="submit" class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-save me-2"></i> Update Club Details
                                </button>
                                <a href="{{ route('president.dashboard', ['club_id' => $club->id ?? 0]) }}" class="btn btn-outline-secondary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex-grow">
                                    <i class="fas fa-tachometer-alt me-2"></i> Back to Dashboard
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
    // Load Tailwind CSS from CDN
    const tailwindScript = document.createElement('script');
    tailwindScript.src = "https://cdn.tailwindcss.com";
    document.head.appendChild(tailwindScript);

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar Toggle Functionality
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
        border-color: #a5b4fc;
    }

    .dashboard-card .card-header {
        background-color: #4f46e5;
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

    .dashboard-nav-card {
        background: #ffffff;
        border-radius: 1rem !important;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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

    .btn-primary {
        background-color: #4f46e5;
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
        border-radius: 0.5rem;
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb;
        border-color: #9ca3af;
    }

    .text-primary { color: #4f46e5; }
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
