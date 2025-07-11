@extends('layouts.app')

@section('content')
<div class="flex bg-gray-50 font-sans antialiased min-h-screen" > {{-- Added min-h-screen to ensure background covers full height --}}
    <div id="sidebar" class="bg-white text-gray-800 w-64 space-y-8 py-10 px-6 fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-xl border-r border-gray-200 md:translate-x-0" >
        <div class="flex items-center justify-between px-2 mb-10">
            <a href="#" class="text-gray-900 text-2xl font-extrabold flex items-center space-x-3 tracking-tight" style="margin-top: 80px;">
                <i class="fas fa-building fa-lg text-indigo-600"></i>
                <span>{{ $club->name ?? 'Club Name' }}</span>
            </a>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('president.dashboard', ['club_id' => $club->id]) }}" class="block py-3 px-4 rounded-lg transition duration-200 hover:bg-indigo-100 hover:text-indigo-700 flex items-center space-x-4 text-lg font-medium">
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
            {{-- Moved sidebar-close-btn to the bottom of the sidebar, as a nav item --}}
            <button id="sidebar-close-btn" class="md:hidden block py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-100 hover:text-gray-700 flex items-center space-x-4 text-lg font-medium mt-4">
                <i class="fas fa-times fa-lg"></i>
                <span>Close Sidebar</span> {{-- Added text for clarity --}}
            </button>
        </nav>
    </div>

    <div id="main-content" class="flex-1 flex flex-col transition-all duration-300 ease-in-out md:ml-64">
        {{-- Sidebar Toggle Button --}}
        <button id="sidebar-toggle-btn" class="fixed top-1/2 -translate-y-1/2 text-gray-700 focus:outline-none p-3 rounded-full bg-white shadow-lg z-40 hover:bg-gray-100 transition-all duration-300 ease-in-out">
            <i class="fas fa-bars fa-lg"></i>
        </button>

        <main class="flex-1 flex justify-center items-start">
            <div class="w-full max-w-full px-4 py-8 md:px-8"> {{-- Ensures content takes full available width --}}
                <div class="dashboard-container"> {{-- Removed px/py from here as it's now on the parent div --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-6 rounded-lg shadow-md">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- Highlighted President Overview Header --}}
                    <h1 class="text-center mb-10 text-white font-extrabold text-4xl bg-indigo-600 p-4 rounded-lg shadow-md" style="margin-top:70px">President Overview</h1>
                    {{-- Redesigned Performance Overview Section --}}
                    <div class="performance-overview-section mt-12 p-6 bg-white rounded-2xl shadow-xl"> {{-- Enhanced shadow to shadow-xl --}}
                        <h2 class="text-center text-gray-800 font-extrabold text-3xl mb-8">Performance Overview</h2>

                        <div class="text-center mb-12">
                            <button class="btn btn-primary px-6 py-3 text-lg rounded-xl shadow-md hover:shadow-lg transition-all duration-300" data-bs-toggle="modal" data-bs-target="#targetModal"> {{-- Added data-bs-toggle and data-bs-target for Bootstrap modal --}}
                                <i class="fas fa-bullseye me-2"></i> Set Target Points
                            </button>
                            <p class="mt-4 text-xl text-gray-700">Current Target: <span class="font-bold text-indigo-700">{{ number_format($targetPoints ?? 0) }}</span> points</p>
                        </div>

                        {{-- Charts Section - Now 3 in a row --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                            {{-- Progress Towards Goals Chart (Doughnut) --}}
                            <div class="col-span-1">
                                <div class="card h-full border-0 shadow-2xl dashboard-card rounded-2xl"> {{-- Shadow-2xl for prominence --}}
                                    <div class="card-header bg-indigo-600 text-white py-4 px-5 rounded-t-2xl">
                                        <h5 class="mb-0 text-xl font-semibold"><i class="fas fa-chart-pie me-3 icon-hover-effect"></i> Progress Towards Goals</h5>
                                    </div>
                                    <div class="card-body flex flex-col items-center justify-center p-6 bg-white rounded-b-2xl">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="goalsProgressChart"></canvas>
                                        </div>
                                        <p class="mt-4 mb-0 text-gray-700 text-lg">Target: <span class="font-bold text-indigo-700">{{ number_format($targetPoints ?? 0) }}</span> points</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Accumulated Points Chart (Pie Chart) --}}
                            <div class="col-span-1">
                                <div class="card h-full border-0 shadow-2xl dashboard-card rounded-2xl"> {{-- Shadow-2xl for prominence --}}
                                    <div class="card-header bg-indigo-600 text-white py-4 px-5 rounded-t-2xl">
                                        <h5 class="mb-0 text-xl font-semibold"><i class="fas fa-chart-pie me-3 icon-hover-effect"></i> Total Accumulated Points</h5>
                                    </div>
                                    <div class="card-body flex flex-col items-center justify-center p-6 bg-white rounded-b-2xl">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="accumulatedPointsChart"></canvas>
                                        </div>
                                        <p class="mt-4 mb-0 text-gray-700 text-lg">Total points: <span class="font-bold text-indigo-700">{{ number_format($totalPoints ?? 0) }}</span></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Club Members (Gender Distribution) Chart (Bar Chart) --}}
                            <div class="col-span-1">
                                <div class="card h-full border-0 shadow-2xl dashboard-card rounded-2xl"> {{-- Shadow-2xl for prominence --}}
                                    <div class="card-header bg-indigo-600 text-white py-4 px-5 rounded-t-2xl">
                                        <h5 class="mb-0 text-xl font-semibold"><i class="fas fa-venus-mars me-3 icon-hover-effect"></i> Club Members (Gender Distribution)</h5>
                                    </div>
                                    <div class="card-body flex flex-col items-center justify-center p-6 bg-white rounded-b-2xl">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="membersChart"></canvas>
                                        </div>
                                        <p class="mt-4 mb-0 text-gray-700 text-lg">Total members: <span class="font-bold text-indigo-700">{{ $membersCount ?? 0 }}</span> (<span class="font-bold text-pink-600">{{ $femaleCount ?? 0 }}</span> female, <span class="font-bold text-blue-600">{{ $maleCount ?? 0 }}</span> male)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Organizational Chart and Contact Info Centered Wrapper --}}
                        <div class="max-w-4xl mx-auto w-full"> {{-- New wrapper for centering --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-12"> {{-- Kept gap-2 for minimal spacing --}}
                                <div class="col-md-6">
                                    <div class="card h-full border-0 shadow-2xl dashboard-card rounded-2xl"> {{-- Shadow-2xl for prominence --}}
                                        <div class="card-header bg-indigo-600 text-white py-4 px-5 rounded-t-2xl">
                                            <h5 class="mb-0 text-xl font-semibold"><i class="fas fa-sitemap me-3 icon-hover-effect"></i> Organisational Chart</h5>
                                        </div>
                                        <div class="card-body text-center p-6 bg-white rounded-b-2xl">
                                            @if(isset($club->org_chart) && $club->org_chart)
                                                <img src="{{ asset('storage/org_charts/'.$club->org_chart) }}" alt="Organizational Chart" class="img-fluid rounded-lg shadow-md max-h-96 w-auto mx-auto border border-gray-200">
                                            @else
                                                <p class="text-gray-600 mb-2 text-lg">No organizational chart uploaded yet.</p>
                                                <small class="text-gray-500 text-base">Upload your club's organizational chart in the "Update Club Details" section.</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-full border-0 shadow-2xl dashboard-card rounded-2xl"> {{-- Shadow-2xl for prominence --}}
                                        <div class="card-header bg-indigo-600 text-white py-4 px-5 rounded-t-2xl">
                                            <h5 class="mb-0 text-xl font-semibold"><i class="fas fa-address-book me-3 icon-hover-effect"></i> Club Contact Information</h5>
                                        </div>
                                        <div class="card-body p-6 bg-white rounded-b-2xl">
                                            <div class="space-y-2"> {{-- Adjusted space-y to be more compact --}}
                                                <p class="text-lg">
                                                    <strong class="text-indigo-700">
                                                        <i class="fas fa-phone me-3"></i>President's Phone:
                                                    </strong>
                                                    {{ $club->president->contact_phone ?? 'N/A' }}
                                                </p>

                                                <!-- Club Email (from clubs table) -->
                                                <p class="text-lg">
                                                    <strong class="text-indigo-700">
                                                        <i class="fas fa-envelope me-3"></i>Club Email:
                                                    </strong>
                                                    <a href="mailto:{{ $club->email }}" class="text-blue-600 hover:underline transition duration-200">
                                                        {{ $club->email ?? 'N/A' }}
                                                    </a>
                                                </p>
                                                <div class="pt-3 border-t border-gray-200 mt-4"> {{-- Separator for social media, adjusted top margin --}}
                                                    <h6 class="text-indigo-700 font-bold mb-3 text-lg">Connect with us:</h6>
                                                    <div class="flex flex-wrap items-center gap-4 justify-start"> {{-- Adjusted gap for more compact layout --}}
                                                        @if(isset($club->instagram_link) && $club->instagram_link)
                                                            <a href="{{ $club->instagram_link }}" target="_blank" class="social-icon-wrapper instagram-bg group">
                                                                <i class="fab fa-instagram instagram-icon social-media-icon group-hover:scale-110"></i>
                                                            </a>
                                                        @endif
                                                        @if(isset($club->x_link) && $club->x_link)
                                                            <a href="{{ $club->x_link }}" target="_blank" class="social-icon-wrapper twitter-bg group">
                                                                <i class="fab fa-twitter twitter-icon social-media-icon group-hover:scale-110"></i>
                                                            </a>
                                                        @endif
                                                        @if(isset($club->tiktok_link) && $club->tiktok_link)
                                                            <a href="{{ $club->tiktok_link }}" target="_blank" class="social-icon-wrapper tiktok-bg group">
                                                                <i class="fab fa-tiktok tiktok-icon social-media-icon group-hover:scale-110"></i>
                                                            </a>
                                                        @endif
                                                        @if(empty($club->instagram_link) && empty($club->x_link) && empty($club->tiktok_link))
                                                            <p class="text-gray-600 text-base">No social media links provided yet.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="targetModal" tabindex="-1" aria-labelledby="targetModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-xl shadow-2xl">
                        <div class="modal-header bg-indigo-600 text-white py-4 px-5 rounded-t-xl">
                            <h5 class="modal-title text-xl font-semibold" id="targetModalLabel">
                                <i class="fas fa-bullseye me-3"></i> Set Target Points
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('president.setTarget', $club->id ?? 1) }}" method="POST">
                            @csrf
                            <div class="modal-body p-6">
                                <div class="mb-4 form-group">
                                    <label for="targetPoints" class="form-label text-indigo-700 font-bold text-lg mb-2">New Target Points:</label>
                                    <input type="number" class="form-control form-control-lg px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" id="targetPoints" name="targetPoints" value="{{ $targetPoints ?? 0 }}" required min="0">
                                </div>
                            </div>
                            <div class="modal-footer flex justify-end space-x-3 p-5 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                                <button type="submit" class="btn btn-primary px-5 py-2.5 rounded-lg text-white font-semibold shadow-md hover:shadow-lg transition duration-200">Save Changes</button>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- Bootstrap 5 JS Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Load Tailwind CSS from CDN
    const tailwindScript = document.createElement('script');
    tailwindScript.src = "https://cdn.tailwindcss.com";
    document.head.appendChild(tailwindScript);

    document.addEventListener('DOMContentLoaded', function() {
        // Debugging check
        console.log('Chart.js version:', Chart.version);

        // Retrieve data from Blade variables and ensure they are numbers
        // Using Number() constructor to safely convert string output from Blade to numbers
        const totalPoints = Number('{{ $totalPoints ?? 0 }}');
        const targetPoints = Number('{{ $targetPoints ?? 0 }}');
        const femaleCount = Number('{{ $femaleCount ?? 0 }}');
        const maleCount = Number('{{ $maleCount ?? 0 }}');

        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarCloseBtn = document.getElementById('sidebar-close-btn');
        const mainScrollArea = document.getElementById('main-scroll-area'); // Get the scrollable area

        // Function to set sidebar and button position
        function setSidebarAndButtonPosition() {
            if (window.innerWidth >= 768) { // Desktop view
                sidebar.classList.remove('-translate-x-full'); // Ensure sidebar is open
                sidebarToggleBtn.classList.add('hidden'); // Hide toggle button on desktop
                document.body.classList.add('sidebar-open'); // Keep body class for consistent styling
                mainContent.classList.add('md:ml-64'); // Ensure main content is pushed on desktop
            } else { // Mobile view
                // If sidebar is currently open, keep it open, otherwise hide it
                if (!document.body.classList.contains('sidebar-open')) {
                    sidebar.classList.add('-translate-x-full');
                }
                sidebarToggleBtn.classList.remove('hidden'); // Show toggle button on mobile
                mainContent.classList.remove('md:ml-64'); // Remove margin on mobile
            }
            updateToggleButtonPosition(); // Update button position based on sidebar state
        }

        // Function to update the toggle button's left position and icon
        function updateToggleButtonPosition() {
            if (window.innerWidth >= 768) {
                // On desktop, the toggle button is hidden, so no need to update its position or icon
                return;
            }

            if (sidebar.classList.contains('-translate-x-full')) {
                // Sidebar is hidden (closed)
                sidebarToggleBtn.style.left = '1rem'; // Small offset from left edge
                sidebarToggleBtn.innerHTML = '<i class="fas fa-bars fa-lg"></i>'; // Bars icon
            } else {
                // Sidebar is visible (open)
                sidebarToggleBtn.style.left = sidebar.offsetWidth + 'px'; // Position right of sidebar
                sidebarToggleBtn.innerHTML = '&lt;'; // Left arrow icon as plain text
            }
        }

        // Function to toggle sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            document.body.classList.toggle('sidebar-open'); // Toggle body class
            updateToggleButtonPosition(); // Update button position immediately
        }

        // Event listeners for sidebar toggle
        sidebarToggleBtn.addEventListener('click', toggleSidebar);
        sidebarCloseBtn.addEventListener('click', toggleSidebar);

        // Adjust layout on window resize
        window.addEventListener('resize', setSidebarAndButtonPosition);

        // Initialize sidebar state and button position on load
        setSidebarAndButtonPosition();

        // Custom Chart.js plugin to draw percentage in the center of the doughnut chart
        const doughnutTextCenter = {
            id: 'doughnutTextCenter',
            beforeDraw(chart) {
                if (chart.config.type === 'doughnut') {
                    const { ctx, width, height } = chart;
                    ctx.restore();
                    const fontSize = (height / 114).toFixed(2);
                    ctx.font = `${fontSize}em sans-serif`;
                    ctx.textBaseline = 'middle';

                    const text = `${completedPercentage.toFixed(1)}%`;
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }
        };

        // 1. Goals Progress Chart (Doughnut)
        const completedPercentage = targetPoints > 0 ? (totalPoints / targetPoints) * 100 : 0;
        const remainingPercentage = 100 - completedPercentage;

        new Chart(document.getElementById('goalsProgressChart'), {
            type: 'doughnut',
            data: {
                labels: ['Achieved', 'Remaining'],
                datasets: [{
                    data: [completedPercentage, remainingPercentage],
                    backgroundColor: ['#4f46e5', '#e0e7ff'], // Indigo-600 and light indigo
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', // Make it a ring
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#343a40', // Dark text for labels
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed.toFixed(1) + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            },
            plugins: [doughnutTextCenter] // Register the custom plugin
        });

        // 2. Total Accumulated Points Chart (Pie Chart)
        const pointsRemainingForPie = targetPoints - totalPoints;
        new Chart(document.getElementById('accumulatedPointsChart'), {
            type: 'pie', // Changed to pie chart
            data: {
                labels: ['Accumulated Points', 'Points Remaining'], // Labels for pie slices
                datasets: [{
                    data: [totalPoints, pointsRemainingForPie > 0 ? pointsRemainingForPie : 0],
                    backgroundColor: ['#36a2eb', '#ffce56'], // Blue for accumulated, Yellow for remaining
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#343a40',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed; // Display raw value for pie chart
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });


        // 3. Club Members (Gender Distribution) Chart (Bar Chart)
        new Chart(document.getElementById('membersChart'), {
            type: 'bar',
            data: {
                labels: ['Female', 'Male'],
                datasets: [
                    {
                        label: 'Number of Members',
                        data: [femaleCount, maleCount],
                        backgroundColor: ['#db2777', '#2563eb'], // Pink-600 for Female, Blue-600 for Male
                        borderColor: ['#ac2f6b', '#1c50a0'],
                        borderWidth: 1,
                        borderRadius: 5,
                        barThickness: 50
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10 // Adjust step size as needed
                        },
                        grid: {
                            color: '#e9ecef'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // No need for legend as labels are clear
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed.y + ' members';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

@push('styles')
{{-- Bootstrap 5 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0V4LLanw2qksYuRlEzO+tcaEPQogQ0KaoIF2g/2g4k1c8C42n2k/K2Q+4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* Custom CSS for gradients and card styles */
    :root {
        --primary-color: #4f46e5; /* Indigo-600 */
        --secondary-color: #3730a3; /* Indigo-900 */
        --accent-blue: #2563eb; /* Blue-600 */
        --accent-purple: #9333ea; /* Purple-600 */
        --accent-pink: #db2777; /* Pink-600 */
    }

    /* General body styling */
    body {
        font-family: 'Inter', sans-serif;
    }

    .dashboard-container {
        background: #f9fafb; /* Lighter, subtle background */
        /* Removed min-height: 100vh; from here to avoid conflicts with main container */
    }

    /* Sidebar specific styles */
    #sidebar {
        background-color: white; /* Solid white background */
        border-right: 1px solid #e5e7eb; /* Subtle light gray border */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Softer shadow */
    }

    #sidebar .text-2xl {
        font-size: 1.75rem; /* Slightly smaller title for minimalism */
        font-weight: 700; /* Bold */
        letter-spacing: -0.025em; /* tracking-tight */
    }

    #sidebar nav a {
        padding-top: 0.75rem; /* py-3 */
        padding-bottom: 0.75rem; /* py-3 */
        padding-left: 1rem; /* px-4 */
        padding-right: 1rem; /* px-4 */
        border-radius: 0.5rem; /* rounded-lg */
        font-weight: 500;
        color: #4b5563; /* gray-700 */
    }

    #sidebar nav a:hover {
        background-color: #e0e7ff; /* indigo-100 */
        color: #4338ca; /* indigo-700 */
    }

    #sidebar nav a i {
        color: #6366f1; /* indigo-500 */
        transition: color 0.2s ease-in-out;
    }

    #sidebar nav a:hover i {
        color: #4338ca; /* indigo-700 */
    }

    #sidebar nav a.hover\:bg-red-100:hover {
        background-color: #fee2e2; /* red-100 */
        color: #b91c1c; /* red-700 */
    }

    #sidebar nav a.hover\:bg-red-100:hover i {
        color: #ef4444; /* red-500 */
    }

    /* Main content toggle button */
    #sidebar-toggle-btn {
        background-color: white;
        border-radius: 9999px; /* full rounded */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }

    #sidebar-toggle-btn:hover {
        background-color: #f3f4f6;
    }

    /* Card styles */
    .dashboard-card {
        background: #ffffff; /* Solid white background */
        border-radius: 1rem !important; /* rounded-2xl */
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* shadow-2xl */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px); /* Subtle lift */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); /* Slightly stronger shadow on hover */
    }

    .dashboard-card .card-header {
        background-color: #4f46e5; /* primary-color (indigo-600) */
        border-bottom: none;
        padding: 1rem 1.25rem; /* py-4 px-5 */
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
        font-weight: 600;
        font-size: 1.125rem; /* text-lg */
    }

    .dashboard-card .card-body {
        padding: 1.5rem; /* p-6 */
        background-color: white;
        border-bottom-left-radius: 1rem !important;
        border-bottom-right-radius: 1rem !important;
    }

    /* Navigation Card Specific Styles */
    .dashboard-nav-card {
        background: #ffffff; /* Solid white background */
        border-radius: 1rem !important; /* rounded-2xl */
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* shadow-2xl */
    }

    .dashboard-nav-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); /* Slightly more prominent shadow */
        border-color: #a5b4fc; /* indigo-200 */
    }

    .dashboard-nav-card .card-body {
        padding: 1.25rem; /* p-5 */
    }

    .dashboard-nav-card i {
        color: #4f46e5; /* Indigo-600 */
        transition: color 0.3s ease;
    }

    #sidebar nav a:hover i {
        color: #4338ca; /* indigo-700 */
    }

    /* Form and Button Styles */
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem; /* rounded-lg */
        border: 1px solid #d1d5db; /* gray-300 */
        transition: all 0.2s ease;
    }

    .form-control-lg:focus {
        border-color: #6366f1; /* indigo-500 */
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25); /* ring-2 indigo-500 */
    }

    .btn-primary {
        background-color: #4f46e5; /* indigo-600 */
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 0.75rem; /* rounded-xl */
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3); /* Shadow based on primary color */
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        background-color: #6366f1; /* indigo-500 */
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border-color: #d1d5db; /* gray-300 */
        color: #4b5563; /* gray-700 */
        font-weight: 500;
        transition: all 0.2s ease;
        border-radius: 0.5rem; /* rounded-lg */
    }

    .btn-outline-secondary:hover {
        background-color: #e5e7eb; /* gray-200 */
        border-color: #9ca3af; /* gray-400 */
    }

    /* Chart Container Styling */
    .chart-container {
        position: relative;
        height: 250px; /* Fixed height for charts */
        width: 100%;
        margin-bottom: 1.5rem; /* mb-6 */
    }

    /* Text colors */
    .text-primary { color: #4f46e5; } /* indigo-600 */
    .text-dark { color: #1f2937; } /* gray-900 */
    .text-muted { color: #6b7280; } /* gray-500 */
    .text-secondary { color: #9ca3af; } /* gray-400 */
    .text-indigo-700 { color: #4338ca; }
    .text-pink-600 { color: #db2777; }
    .text-blue-600 { color: #2563eb; }

    /* Custom style for icon hover effect */
    .icon-hover-effect {
        transition: transform 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .icon-hover-effect:hover {
        transform: translateY(-2px) scale(1.1); /* Subtle lift and slight enlarge */
        color: #e0e7ff; /* Lighter color on hover for contrast */
    }

    /* Social Media Icon Specific Colors and Styling */
    .social-icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 3.5rem; /* w-14 */
        height: 3.5rem; /* h-14 */
        border-radius: 9999px; /* rounded-full */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease-in-out;
        text-decoration: none;
        flex-shrink: 0; /* Prevent shrinking */
    }

    .social-icon-wrapper:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15), 0 4px 6px -2px rgba(0, 0, 0, 0.08);
    }

    /* Specific background colors for wrappers */
    .instagram-bg {
        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
    }
    .twitter-bg {
        background-color: #1DA1F2; /* Twitter blue */
    }
    .tiktok-bg {
        background-color: #000000; /* TikTok black */
    }

    /* Icon colors - these should be white for contrast on the colored backgrounds */
    .social-media-icon {
        font-size: 2.25rem; /* text-4xl equivalent */
        color: white; /* Make icons white for better contrast on colored backgrounds */
        transition: transform 0.2s ease-in-out;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .dashboard-container { padding-left: 1rem !important; padding-right: 1rem !important; } /* Smaller padding on mobile */
        .text-4xl { font-size: 2.5rem !important; }
        .text-3xl { font-size: 2rem !important; }
        .chart-container { height: 200px; }
        .dashboard-nav-card .card-body { padding: 1rem; }
        .dashboard-nav-card i { font-size: 2.5rem !important; } /* Smaller icons on mobile */
    }
</style>
@endpush
