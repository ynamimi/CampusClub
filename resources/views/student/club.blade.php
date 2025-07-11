@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 profile-container">
    <div class="row g-0" style="margin-top:70px">
        <div class="col-12">

            <!-- Main Content -->
            <div class="p-4">
                <h2 class="mb-4 text-dark fw-bold">
                    <i class="fas fa-users me-2 text-primary"></i> My Clubs & Activities
                </h2>

                @if(count($activities) === 0)
                <div class="card border-0 shadow-sm profile-card mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
                        <h5 class="text-dark mb-2">No Club Memberships Yet</h5>
                        <p class="text-muted mb-4">You haven't joined any clubs or activities yet.</p>
                        <a href="{{ route('student.clubs') }}" class="btn btn-gradient-blue px-4">
                            <i class="fas fa-plus me-1"></i> Browse Clubs
                        </a>
                    </div>
                </div>
                @else
                    @foreach($activities as $clubName => $registrations)
                    <div class="card border-0 shadow-sm profile-card mb-4">
                        <div class="card-header bg-gradient-blue text-black d-flex justify-content-between align-items-center">
                            <span class="fw-bold">
                                <i class="fas fa-users me-2"></i> {{ $clubName }}
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <div class="p-3">
                                <h5 class="text-dark mb-3">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i> Joined Activities
                                </h5>
                            </div>
                            <div class="list-group list-group-flush">
                                @foreach($registrations as $registration)
                                <div class="list-group-item p-3 event-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        {{-- Left side: Activity Name and Details --}}
                                        <a href="{{ route('club.events.show', $registration->activity_id) }}" class="text-decoration-none flex-grow-1 me-3">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark">{{ $registration->activity->name }}</span>
                                                <div class="d-flex align-items-center mt-1">
                                                    <span class="badge bg-light text-primary me-2">
                                                        <i class="far fa-calendar me-1"></i>
                                                        {{ $registration->activity->event_date->format('M d, Y') }}
                                                    </span>
                                                    <span class="badge bg-light text-primary">
                                                        <i class="far fa-clock me-1"></i>
                                                        {{ $registration->activity->event_time }}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>

                                        {{-- Right side: Unjoin Button --}}
                                        <form action="{{ route('club.activity.unjoin', ['clubId' => $registration->activity->club_id, 'activityId' => $registration->activity_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to unjoin from the event &quot;{{ $registration->activity->name }}&quot;? This action cannot be undone.')">
                                                <i class="fas fa-times-circle me-1"></i> Unjoin
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif

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
    /* Consistent with profile page styles */
    .profile-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--accent-purple), var(--primary-color));
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .profile-card {
        background: white;
        border-radius: 12px !important;
        overflow: hidden;
    }

    /* Event Item Styling */
    .event-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        border-radius: 0 !important;
    }

    .event-item:hover {
        background-color: #f8f9fa;
        border-left: 3px solid var(--accent-blue);
        transform: translateX(5px);
    }

    /* Badge Styling */
    .badge.bg-light {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }

    /* Button Styles - Consistent with profile page */
    .btn-gradient-blue {
        background: linear-gradient(135deg, var(--accent-blue), var(--primary-color));
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-purple {
        background: linear-gradient(135deg, var(--accent-purple), #9d4edd);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    /* Text Contrast Improvements */
    .text-dark {
        color: #343a40 !important;
    }

    /* Landscape Optimization */
    @media (orientation: landscape) {
        .profile-header {
            padding: 1rem !important;
        }

        .event-item {
            padding: 1rem 1.5rem;
        }
    }

    /* Mobile Optimization */
    @media (max-width: 576px) {
        .badge {
            font-size: 0.75rem;
        }
    }
</style>
@endpush
