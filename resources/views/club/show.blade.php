@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 profile-container">
    <div class="row g-0">
        <div class="col-12" style="margin-top:70px">
            <!-- Club Content Section -->
            <div class="p-4">
                <h1 class="text-center mb-4 text-dark fw-bold">
                    <i class="fas fa-users me-2 text-primary"></i> {{ $club->name }}
                </h1>

                <!-- Club Info Card -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; width: 100%; max-width: 1200px; margin: 0 auto;">
                    <div class="card-body p-4">
                        <div class="row g-0 align-items-stretch">
                            <!-- Club Image Column -->
                            <div class="col-xl-3 col-lg-4 col-md-5 text-center d-flex flex-column">
                            @if($club->image)
                                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                                    <img src="{{ Storage::url($club->image) }}"
                                        alt="{{ $club->name }}"
                                        class="img-fluid rounded-3 shadow"
                                        style="max-height: 400px; width: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                                    <div class="avatar-placeholder-lg rounded-3 d-flex flex-column justify-content-center align-items-center w-100">
                                        <i class="fas fa-users fa-4x mb-3"></i>
                                        <span class="text-muted">Club Image</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Club Details Column -->
                        <div class="col ps-4">
                            <div class="d-flex flex-column h-100">
                                <div class="flex-grow-1">
                                    <h2 class="text-primary mb-3">{{ $club->name }}</h2>
                                    <div class="mb-4">
                                        <p class="text-dark text-justify fs-5 mb-0" style="line-height: 1.7;">
                                            {{ $club->description ?? 'No description provided yet.' }}
                                        </p>
                                    </div>
                                    <div class="d-flex flex-wrap gap-3 mt-4">
                                        <!-- Club Metadata -->
                                        @if($club->establishment_date)
                                        <div class="d-flex align-items-center bg-light rounded-3 p-3 flex-grow-1" style="min-width: 200px;">
                                            <div class="icon-circle bg-primary-light text-primary me-3">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 small text-muted">Established</p>
                                                <p class="mb-0 fw-bold">{{ $club->establishment_date->format('F Y') }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="d-flex align-items-center bg-light rounded-3 p-3 flex-grow-1" style="min-width: 200px;">
                                            <div class="icon-circle bg-primary-light text-primary me-3">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 small text-muted">Members</p>
                                                <p class="mb-0 fw-bold">{{ $club->registrations->count() }}</p>
                                            </div>
                                        </div>

                                        @if($club->meeting_schedule)
                                        <div class="d-flex align-items-center bg-light rounded-3 p-3 flex-grow-1" style="min-width: 200px;">
                                            <div class="icon-circle bg-primary-light text-primary me-3">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 small text-muted">Meets</p>
                                                <p class="mb-0 fw-bold">{{ $club->meeting_schedule }}</p>
                                            </div>
                                        </div>
                                        @endif

                                        @if($club->location)
                                        <div class="d-flex align-items-center bg-light rounded-3 p-3 flex-grow-1" style="min-width: 200px;">
                                            <div class="icon-circle bg-primary-light text-primary me-3">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 small text-muted">Location</p>
                                                <p class="mb-0 fw-bold">{{ $club->location }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Social Links and Join Button -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <div class="social-links mb-2 mb-md-0">
                                        @if($club->instagram_link)
                                        <a href="{{ $club->instagram_link }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fab fa-instagram me-1"></i> Instagram
                                        </a>
                                        @endif
                                        @if($club->tiktok_link)
                                        <a href="{{ $club->tiktok_link }}" target="_blank" class="btn btn-sm btn-outline-dark me-2">
                                            <i class="fab fa-tiktok me-1"></i> TikTok
                                        </a>
                                        @endif
                                        @if($club->x_link)
                                        <a href="{{ $club->x_link }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fab fa-twitter me-1"></i> Twitter
                                        </a>
                                        @endif
                                    </div>

                                    <a href="{{ route('club.register', $club->id) }}"
                                    class="btn btn-gradient-blue px-4 py-2">
                                        <i class="fas fa-user-plus me-2"></i> Join Our Club
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Section -->
                <ul class="nav nav-tabs mb-3" id="clubTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active tab-button"
                                id="organisation-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#organisation"
                                type="button"
                                role="tab">
                            <i class="fas fa-sitemap me-1"></i> Organisational Chart
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tab-button"
                                id="activities-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#activities"
                                type="button"
                                role="tab">
                            <i class="fas fa-calendar-alt me-1"></i> Activities
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tab-button"
                                id="performance-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#performance"
                                type="button"
                                role="tab">
                            <i class="fas fa-chart-line me-1"></i> Performance
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tab-button"
                                id="contact-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#contact"
                                type="button"
                                role="tab">
                            <i class="fas fa-envelope me-1"></i> Contact Us
                        </button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content p-3 border-top-0 border rounded-bottom">
                    <!-- Organisation Tab -->
                    <div class="tab-pane fade show active" id="organisation" role="tabpanel">
                        @if($club->org_chart)
                            <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; overflow: hidden; width: 100%; max-width: 1200px; margin: 0 auto;">
                                <div class="card-header bg-gradient-primary text-white py-3">
                                    <h3 class="mb-0">
                                        <i class="fas fa-sitemap me-2"></i>
                                        {{ $club->name }} Organizational Structure
                                    </h3>
                                    <p class="mb-0 mt-1 small opacity-75">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Leadership hierarchy and reporting structure
                                    </p>
                                </div>
                                <div class="card-body p-4">
                                    <div class="alert alert-info bg-primary-light border-primary mb-4 text-start d-flex align-items-center">
                                        <i class="fas fa-info-circle fa-lg me-3 text-primary"></i>
                                        <div>
                                            This chart illustrates the complete organizational framework of {{ $club->name }},
                                            showing departments, teams, and reporting relationships.
                                        </div>
                                    </div>

                                    <div class="org-chart-container bg-white rounded-lg p-3 shadow-sm mb-4"
                                        style="border: 1px dashed rgba(0,0,0,0.1);">
                                        <img src="{{ asset('storage/org_charts/'.$club->org_chart) }}"
                                            class="img-fluid rounded-lg shadow"
                                            alt="{{ $club->name }} Organizational Chart"
                                            style="max-width: 100%; max-height: 65vh; object-fit: contain; display: block; margin: 0 auto;">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                                <div class="card-header bg-gradient-primary text-white py-3">
                                    <h3 class="mb-0">
                                        <i class="fas fa-sitemap me-2"></i>
                                        Organizational Chart
                                    </h3>
                                </div>
                                <div class="card-body text-center p-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon bg-primary-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                                            style="width: 80px; height: 80px;">
                                            <i class="fas fa-sitemap fa-3x text-primary"></i>
                                        </div>
                                        <h4 class="text-dark mb-3">Organization Structure Coming Soon</h4>
                                        <p class="text-muted mb-4">
                                            The organizational framework for {{ $club->name }} is currently being prepared.
                                            Check back later to view the complete leadership hierarchy.
                                        </p>
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="#" class="btn btn-primary">
                                                <i class="fas fa-sync-alt me-2"></i> Check Again Later
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($club->leadership_description)
                        <div class="card border-0 shadow-lg mt-4" style="border-radius: 15px;">
                            <div class="card-header bg-gradient-primary text-white py-3 rounded-top">
                                <h3 class="mb-0">
                                    <i class="fas fa-users me-2"></i>
                                    Key Leadership Team
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10">
                                        {!! $club->leadership_description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Activities Tab -->
                    <div class="tab-pane fade" id="activities" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden; width: 100%; max-width: 1200px; margin: 0 auto;">
                                    <div class="card-header bg-gradient-primary text-white py-3">
                                        <h3 class="mb-0">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            Club Activities & Events
                                        </h3>
                                        <p class="mb-0 mt-1 small opacity-75">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Explore upcoming and past events hosted by {{ $club->name }}
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-4">
                                            <!-- Upcoming Events Column -->
                                            <div class="col-lg-6">
                                                <div class="card shadow-sm h-100">
                                                    <div class="card-header bg-primary text-white py-3">
                                                        <h4 class="mb-0 d-flex align-items-center">
                                                            <i class="fas fa-calendar-plus me-2"></i>
                                                            Upcoming Events
                                                            <span class="badge bg-white text-primary ms-auto">
                                                                {{ $club->activities->where('event_date', '>=', now())->count() }}
                                                            </span>
                                                        </h4>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        @if($club->activities->where('event_date', '>=', now())->count() > 0)
                                                            <div class="list-group list-group-flush">
                                                                @foreach($club->activities->where('event_date', '>=', now()) as $index => $activity)
                                                                    <a href="{{ route('club.events.show', $activity->id) }}"
                                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="badge bg-primary rounded-circle me-3" style="width: 28px; height: 28px; line-height: 28px;">
                                                                                {{ $index + 1 }}
                                                                            </span>
                                                                            <span class="text-dark">{{ $activity->name }}</span>
                                                                        </div>
                                                                        <span class="badge bg-primary rounded-pill">
                                                                            {{ $activity->event_date->format('M d, Y') }}
                                                                        </span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-center py-5">
                                                                <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                                                                <h5 class="text-muted">No Upcoming Events</h5>
                                                                <p class="small text-muted">Check back later for scheduled activities</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Past Events Column -->
                                            <div class="col-lg-6">
                                                <div class="card shadow-sm h-100">
                                                    <div class="card-header bg-secondary text-white py-3">
                                                        <h4 class="mb-0 d-flex align-items-center">
                                                            <i class="fas fa-history me-2"></i>
                                                            Past Events
                                                            <span class="badge bg-white text-secondary ms-auto">
                                                                {{ $club->activities->where('event_date', '<', now())->count() }}
                                                            </span>
                                                        </h4>
                                                    </div>
                                                    <div class="card-body p-0">
                                                        @if($club->activities->where('event_date', '<', now())->count() > 0)
                                                            <div class="list-group list-group-flush">
                                                                @foreach($club->activities->where('event_date', '<', now()) as $index => $activity)
                                                                    <a href="{{ route('club.events.show', $activity->id) }}"
                                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="badge bg-secondary rounded-circle me-3" style="width: 28px; height: 28px; line-height: 28px;">
                                                                                {{ $index + 1 }}
                                                                            </span>
                                                                            <span class="text-muted">{{ $activity->name }}</span>
                                                                        </div>
                                                                        <span class="badge bg-secondary rounded-pill">
                                                                            {{ $activity->event_date->format('M d, Y') }}
                                                                        </span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-center py-5">
                                                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                                                <h5 class="text-muted">No Past Events</h5>
                                                                <p class="small text-muted">This club hasn't held any events yet</p>
                                                            </div>
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

                    <!-- Performance Tab -->
                    <div class="tab-pane fade" id="performance" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden; width: 100%; max-width: 1200px; margin: 0 auto;">
                                    <div class="card-header bg-gradient-primary text-white py-3">
                                        <h3 class="mb-0">
                                            <i class="fas fa-chart-line me-2"></i>
                                            Club Performance Metrics
                                        </h3>
                                        <p class="mb-0 mt-1 small opacity-75">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Track the club's progress and statistics
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-4 justify-content-center">
                                            <!-- Progress Chart -->
                                            <div class="col-md-6 col-lg-4 d-flex">
                                                <div class="card shadow-sm w-100">
                                                    <div class="card-header bg-primary text-white py-3">
                                                        <h5 class="mb-0">Progress Towards Goals</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @php
                                                            // Calculate points from events (100 points per event)
                                                            $eventPoints = $club->activities->where('event_date', '<', now())->count() * 100;
                                                            $additionalPoints = $club->performanceMetrics->total_points ?? 0;
                                                            $totalPoints = $eventPoints + $additionalPoints;
                                                            $targetPoints = $club->target_points ?? 1000;
                                                            $percentage = $targetPoints > 0 ? min(100, ($totalPoints / $targetPoints) * 100) : 0;
                                                        @endphp

                                                        @if($targetPoints > 0)
                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <div style="height: 180px;">
                                                                        <canvas id="progressChart"></canvas>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="text-center">
                                                                        <h3 class="text-primary mb-2">{{ $totalPoints }} / {{ $targetPoints }}</h3>
                                                                        <p class="text-muted mb-2">Total Points</p>
                                                                        <div class="progress" style="height: 10px;">
                                                                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                                                        </div>
                                                                        <p class="small mt-2 mb-0">{{ number_format($percentage, 1) }}% completed</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="text-center py-4">
                                                                <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                                                                <p class="text-muted">No target points set yet</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Event Statistics -->
                                            <div class="col-md-6 col-lg-4 d-flex">
                                                <div class="card shadow-sm w-100">
                                                    <div class="card-header bg-primary text-white py-3">
                                                        <h5 class="mb-0">Event Statistics</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @php
                                                            $totalEvents = $club->activities->count();
                                                            $upcomingEvents = $club->activities->where('event_date', '>=', now())->count();
                                                            $pastEvents = $club->activities->where('event_date', '<', now())->count();

                                                            // Find the next upcoming event
                                                            $nextEvent = $club->activities->where('event_date', '>=', now())->sortBy('event_date')->first();
                                                        @endphp

                                                        @if($totalEvents > 0)
                                                            <div class="text-center">
                                                                <div class="row mb-4">
                                                                    <div class="col-4">
                                                                        <h3 class="text-primary">{{ $totalEvents }}</h3>
                                                                        <p class="small mb-0">Total</p>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <h3 class="text-primary">{{ $upcomingEvents }}</h3>
                                                                        <p class="small mb-0">Coming</p>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <h3 class="text-primary">{{ $pastEvents }}</h3>
                                                                        <p class="small mb-0">Past</p>
                                                                    </div>
                                                                </div>

                                                                @if($nextEvent)
                                                                    <div class="next-event-countdown mt-3">
                                                                        <h5 class="text-primary mb-2">Next Event Countdown</h5>
                                                                        <div class="countdown-timer" data-event-date="{{ $nextEvent->event_date->format('Y-m-d H:i:s') }}">
                                                                            <div class="d-flex justify-content-center">
                                                                                <div class="mx-2 text-center">
                                                                                    <div class="countdown-number days">00</div>
                                                                                    <div class="countdown-label small">Days</div>
                                                                                </div>
                                                                                <div class="mx-2 text-center">
                                                                                    <div class="countdown-number hours">00</div>
                                                                                    <div class="countdown-label small">Hours</div>
                                                                                </div>
                                                                                <div class="mx-2 text-center">
                                                                                    <div class="countdown-number minutes">00</div>
                                                                                    <div class="countdown-label small">Mins</div>
                                                                                </div>
                                                                                <div class="mx-2 text-center">
                                                                                    <div class="countdown-number seconds">00</div>
                                                                                    <div class="countdown-label small">Secs</div>
                                                                                </div>
                                                                            </div>
                                                                            <p class="mt-2 mb-0 small text-muted">{{ $nextEvent->name }}</p>
                                                                            <p class="small text-muted">{{ $nextEvent->event_date->format('M d, Y h:i A') }}</p>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="alert alert-info mt-3">
                                                                        <i class="fas fa-info-circle me-2"></i>
                                                                        No upcoming events scheduled
                                                                    </div>
                                                                    <p class="small text-muted mt-2">
                                                                            <i class="fas fa-calendar-check me-1"></i>
                                                                            {{ $club->activities->where('event_date', '<', now())->count() }} events completed
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="text-center py-4">
                                                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                                                <p class="text-muted">No events created yet</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Members Chart -->
                                            <div class="col-md-6 col-lg-4 d-flex">
                                                <div class="card shadow-sm w-100">
                                                    <div class="card-header bg-primary text-white py-3">
                                                        <h5 class="mb-0">Membership Distribution</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @php
                                                            $totalMembers = $club->registrations->count();
                                                            $femaleCount = $club->registrations->where('gender', 'female')->count();
                                                            $maleCount = $club->registrations->where('gender', 'male')->count();
                                                        @endphp

                                                        @if($totalMembers > 0)
                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <div style="height: 180px;">
                                                                        <canvas id="membersChart"></canvas>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="text-center">
                                                                        <h3 class="text-primary mb-2">{{ $totalMembers }}</h3>
                                                                        <p class="text-muted mb-2">Active Members</p>
                                                                        <div class="d-flex justify-content-center gap-3">
                                                                            <div>
                                                                                <span class="badge bg-pink">{{ $femaleCount }}</span>
                                                                                <p class="small mb-0">Female</p>
                                                                            </div>
                                                                            <div>
                                                                                <span class="badge bg-blue">{{ $maleCount }}</span>
                                                                                <p class="small mb-0">Male</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="text-center py-4">
                                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                                <p class="text-muted">No members registered yet</p>
                                                            </div>
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

                    <!-- Contact Us Tab -->
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden; width: 100%; max-width: 12000px; margin: 0 auto;">
                                    <div class="card-header bg-gradient-primary text-white py-3">
                                        <h3 class="mb-0">
                                            <i class="fas fa-envelope me-2"></i>
                                            Contact {{ $club->name }}
                                        </h3>
                                        <p class="mb-0 mt-1 small opacity-75">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Get in touch with the club leadership
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-4" style="align-content: center"

                                            <!-- Contact Info Column -->
                                            <div class="col-lg-5">
                                                <div class="card shadow-sm h-100">
                                                    <div class="card-header bg-primary text-white py-3">
                                                        <h4 class="mb-0">
                                                            <i class="fas fa-info-circle me-2"></i> Contact Information
                                                        </h4>
                                                    </div>
                                                    <div class="card-body p-4">
                                                        <div class="d-flex flex-column h-100">
                                                            <!-- Contact Details -->
                                                            <div class="mb-4">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <div class="icon-circle bg-primary-light text-primary me-3">
                                                                        <i class="fas fa-phone-alt"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0 text-dark">Phone Number</h6>
                                                                        <p class="mb-0 text-muted">
                                                                            @if($club->contact_phone)
                                                                                <a href="tel:{{ $club->contact_phone }}" class="text-decoration-none">{{ $club->contact_phone }}</a>
                                                                            @else
                                                                                Not provided
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center mb-3">
                                                                    <div class="icon-circle bg-primary-light text-primary me-3">
                                                                        <i class="fas fa-envelope"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0 text-dark">Email Address</h6>
                                                                        <p class="mb-0 text-muted">
                                                                            @if($club->contact_email)
                                                                                <a href="mailto:{{ $club->contact_email }}" class="text-decoration-none">{{ $club->contact_email }}</a>
                                                                            @else
                                                                                Not provided
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                    <div class="icon-circle bg-primary-light text-primary me-3">
                                                                        <i class="fas fa-clock"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0 text-dark">Response Time</h6>
                                                                        <p class="mb-0 text-muted">Typically within 24-48 hours</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Social Media Section -->
                                                            <div class="mt-auto pt-3 border-top">
                                                                <h5 class="text-dark mb-3">Connect With Us</h5>
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    @if($club->instagram_link)
                                                                    <a href="{{ $club->instagram_link }}" target="_blank" class="btn btn-dark rounded-pill px-3">
                                                                        <i class="fab fa-instagram me-2"></i> Instagram
                                                                    </a>
                                                                    @endif

                                                                    @if($club->tiktok_link)
                                                                    <a href="{{ $club->tiktok_link }}" target="_blank" class="btn btn-dark rounded-pill px-3">
                                                                        <i class="fab fa-tiktok me-2"></i> TikTok
                                                                    </a>
                                                                    @endif

                                                                    @if($club->x_link)
                                                                    <a href="{{ $club->x_link }}" target="_blank" class="btn btn-twitter rounded-pill px-3">
                                                                        <i class="fab fa-twitter me-2"></i> Twitter
                                                                    </a>
                                                                    @endif

                                                                    @if($club->facebook_link)
                                                                    <a href="{{ $club->facebook_link }}" target="_blank" class="btn btn-facebook rounded-pill px-3">
                                                                        <i class="fab fa-facebook-f me-2"></i> Facebook
                                                                    </a>
                                                                    @endif
                                                                </div>

                                                                @if(!$club->instagram_link && !$club->tiktok_link && !$club->x_link && !$club->facebook_link)
                                                                <div class="alert alert-info bg-primary-light border-primary text-start d-flex align-items-center mt-3">
                                                                    <i class="fas fa-info-circle fa-lg me-3 text-primary"></i>
                                                                    <div>
                                                                        This club hasn't added any social media links yet. Check back later!
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Map Column (if location is available) -->
                                            @if($club->location)
                                            <div class="col-12 mt-4">
                                                <div class="card shadow-sm">
                                                    <div class="card-header bg-primary text-white py-3">
                                                        <h4 class="mb-0">
                                                            <i class="fas fa-map-marked-alt me-2"></i> Find Us
                                                        </h4>
                                                    </div>
                                                    <div class="card-body p-0" style="height: 300px;">
                                                        <div class="map-container h-100 w-100 bg-light d-flex align-items-center justify-content-center">
                                                            <div class="text-center p-4">
                                                                <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                                                                <h5 class="text-dark">{{ $club->location }}</h5>
                                                                <p class="text-muted">Map integration would show here</p>
                                                                <a href="#" class="btn btn-outline-primary rounded-pill">
                                                                    <i class="fas fa-directions me-2"></i> Get Directions
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                    <a href="{{ route('student.home') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-home me-2"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Colorful Base Styles */
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-blue: #4895ef;
        --accent-purple: #7209b7;
        --accent-pink: #f72585;
    }

    .profile-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--accent-purple), var(--primary-color));
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .profile-card {
        background: linear-gradient(135deg, #ffffff 0%, #f1f8ff 100%);
        border-radius: 12px !important;
        border-left: 4px solid var(--accent-blue);
        max-width: 100% !important;
        margin-left: 0;
        margin-right: 0;
    }

    .card {
        flex: 1 1 45%; /* Adjusts the width of each card */
        min-width: 320px; /* Ensures the cards don't get too small */
        margin: 10px 0;  /* Adds vertical spacing between cards */
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2rem;
    }

    /* Text justification */
    .text-justify {
        text-align: justify;
        text-justify: inter-word;
    }

    /* Club Image Placeholder */
    .avatar-placeholder-lg {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #e0e0e0, #f5f5f5);
        border-radius: 12px;
        color: #999;
        font-size: 3rem;
    }

    /* Enhanced Tab Styling */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        font-weight: 500;
        border: 1px solid #dee2e6;
        border-bottom: none;
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
        margin-right: 0.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        background-color: white;
        color: #6c757d;
    }

    .nav-tabs .nav-link.active {
        background-color: var(--primary-color);
        color: white;
        border-color: #dee2e6;
        border-bottom-color: transparent;
        font-weight: 600;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
        color: var(--primary-color);
    }

    .tab-content {
        background-color: white;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.5rem 0.5rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
    }

    /* Button Styles */
    .btn-gradient-blue {
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-blue:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }

    .btn-outline-secondary {
        border-color: #dee2e6;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    /* Badge Styles */
    .badge.bg-pink { background-color: rgba(255, 99, 132, 0.8); }
    .badge.bg-blue { background-color: rgba(54, 162, 235, 0.8); }

    /* Custom styles for the wider club card */
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .bg-primary-light {
        background-color: rgba(67, 97, 238, 0.1);
    }

    .btn-gradient-blue {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-blue:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: white;
    }

    .avatar-placeholder-lg {
        height: 220px;
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
        color: #aaa;
        transition: all 0.3s ease;
    }

    .org-chart-container {
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .org-chart-container:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    /* Performance tab specific styles */
    #performance .card {
        margin-bottom: 0; /* Remove bottom margin since we have gap in the row */
        height: 100%; /* Make cards equal height */
    }

    /* Activities tab specific styles */
    #activities .card {
        margin: 0 auto; /* Center the card */
    }

    /* Make sure cards in performance tab are properly aligned */
    #performance .row {
        align-items: stretch; /* Make cards stretch to same height */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #performance .col-md-6 {
            flex: 0 0 100%; /* Full width on mobile */
            max-width: 100%;
        }

        .col-xl-1 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
        .col-xl-11 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }
    }

    @media (max-width: 768px) {
        .col-lg-2 {
            flex: 0 0 25%;
            max-width: 25%;
        }
        .col-lg-10 {
            flex: 0 0 75%;
            max-width: 75%;
        }
        .d-flex.flex-wrap > div {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .nav-tabs .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }

        .avatar-placeholder-lg {
            height: 150px;
            font-size: 2rem;
        }
        .profile-card {
            margin-left: -15px;
            margin-right: -15px;
        }
        .card-header h3 {
            font-size: 1.4rem;
        }

        .empty-state-icon {
            width: 60px !important;
            height: 60px !important;
        }

        .card {
            flex: 1 1 100%;  /* Stacks the cards vertically on smaller screens */
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress Chart (Doughnut)
    const progressCtx = document.getElementById('progressChart')?.getContext('2d');
    if (progressCtx) {
        // Get the PHP calculated values
        const totalPoints = {{ $totalPoints ?? 0 }};
        const targetPoints = {{ $targetPoints ?? 1000 }};
        const remainingPoints = Math.max(0, targetPoints - totalPoints);

        new Chart(progressCtx, {
            type: 'doughnut',
            data: {
                labels: ['Achieved', 'Remaining'],
                datasets: [{
                    data: [totalPoints, remainingPoints],
                    backgroundColor: ['#4bc0c0', '#e0e0e0'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + ' points';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Members Chart (Bar)
    const membersCtx = document.getElementById('membersChart')?.getContext('2d');
    if (membersCtx) {
        new Chart(membersCtx, {
            type: 'bar',
            data: {
                labels: ['Female', 'Male'],
                datasets: [{
                    label: 'Members',
                    data: [
                        {{ $club->registrations->where('gender', 'female')->count() }},
                        {{ $club->registrations->where('gender', 'male')->count() }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + ' members';
                            }
                        }
                    }
                },
                barPercentage: 0.5
            }
        });
    }

    // Tab click handler to ensure proper styling
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('text-white');
                btn.style.backgroundColor = 'white';
                btn.style.color = '#6c757d';
            });

            this.classList.add('active');
            this.style.backgroundColor = '#4361ee';
            this.style.color = 'white';
        });
    });
});
</script>
@endpush
