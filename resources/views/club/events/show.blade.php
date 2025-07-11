@extends('layouts.app')

@section('content')
<div class="container activity-container py-5">
    <!-- Header Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h1 class="activity-title mb-3">{{ $activity->name }}</h1>
            <div class="activity-meta d-flex justify-content-center align-items-center gap-3 mb-4">
                <span class="badge bg-primary rounded-pill px-3 py-2">
                    <i class="fas fa-calendar-day me-2"></i>{{ $activity->event_date->format('F j, Y') }}
                </span>
                <span class="badge bg-secondary rounded-pill px-3 py-2">
                    <i class="fas fa-clock me-2"></i>{{ date('h:i A', strtotime($activity->start_time)) }} - {{ date('h:i A', strtotime($activity->end_time)) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Notification Messages -->
    @if(session('success'))
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Poster Section -->
    @if($activity->poster)
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="activity-poster shadow-lg rounded-4 overflow-hidden">
                    <img src="{{ asset('storage/' . $activity->poster) }}"
                         alt="Activity Poster"
                         class="img-fluid w-100">
                </div>
            </div>
        </div>
    @endif

    <!-- Details Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="detail-item mb-4">
                        <h3 class="detail-heading d-flex align-items-center">
                            <span class="icon-circle bg-primary me-3">
                                <i class="fas fa-bullseye text-white"></i>
                            </span>
                            Objectives
                        </h3>
                        <p class="detail-content ps-5">{{ $activity->objectives ?? 'Not specified' }}</p>
                    </div>

                    <hr class="my-4">

                    <div class="detail-item">
                        <h3 class="detail-heading d-flex align-items-center">
                            <span class="icon-circle bg-primary me-3">
                                <i class="fas fa-tasks text-white"></i>
                            </span>
                            Activities
                        </h3>
                        <p class="detail-content ps-5">{{ $activity->activities ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <form action="{{ route('club.activity.join', [$club->id, $activity->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-join px-4 py-3">
                        <i class="fas fa-user-plus me-2"></i> Join This Event
                    </button>
                </form>

                <a href="{{ route('club.show', $club->id) }}" class="btn btn-outline-secondary btn-back px-4 py-3">
                    <i class="fas fa-arrow-left me-2"></i> Back to Club
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Join Button Handler
    const joinBtn = document.getElementById('joinBtn');
    if (joinBtn) {
        joinBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'Join Event?',
                text: 'Are you sure you want to join this event?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Join',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('joinForm').submit();
                }
            });
        });
    }

    // Unjoin Button Handler
    const unjoinBtn = document.getElementById('unjoinBtn');
    if (unjoinBtn) {
        unjoinBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'Unjoin Event?',
                text: 'Are you sure you want to unjoin this event?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Unjoin',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('unjoinForm').submit();
                }
            });
        });
    }
});
</script>
@endpush


<style>
    .activity-container {
        margin-top: 100px;
    }

    .activity-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.2;
    }

    .activity-meta .badge {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .activity-poster {
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .activity-poster:hover {
        transform: translateY(-5px);
    }

    .detail-heading {
        font-size: 1.4rem;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .detail-content {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #495057;
    }

    .btn-join {
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
    }

    .btn-join:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
    }

    .btn-back {
        font-size: 1.1rem;
        font-weight: 500;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 768px) {
        .activity-title {
            font-size: 2rem;
        }

        .activity-container {
            margin-top: 80px;
        }

        .activity-meta {
            flex-direction: column;
            gap: 0.5rem !important;
        }
    }
</style>
@endsection
