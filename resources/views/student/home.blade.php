@extends('layouts.app')

@section('content')
    <style>
        /* Custom styles for the club page */
        .btn-outline-primary {
            transition: all 0.3s ease;
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .btn-outline-primary:hover {
            background-color: #0b5ed7;
            color: white;
            border-color: #0b5ed7;
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .hero-section {
            background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)),
                        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .hero-section .btn-light {
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .hero-section .btn-light:hover {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .club-img-container {
            height: 180px;
            overflow: hidden;
        }

        .club-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .club-card:hover .club-img {
            transform: scale(1.05);
        }

        .hero-section .btn-light:hover i {
            color: white;
        }

        .shadow-lg-hover {
            transition: all 0.3s ease;
        }

        .shadow-lg-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }

        .category-title {
            position: relative;
            padding-bottom: 10px;
        }

        .category-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #0d6efd;
        }
    </style>

    <div class="container-fluid px-0">
        <div class="hero-section py-5" style="margin-top: -80px; padding-top: 50px;">
            <div class="container py-5">
                <div class="text-center text-black py-4" style="margin-top:120px">
                    <h1 class="display-3 fw-bold mb-3">CAMPUS CLUBS</h1>
                    <p class="lead mb-4">Find your tribe. Fuel your passion. Forge connections.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#public" class="btn btn-light btn-lg px-4 rounded-pill shadow-sm fw-bold">
                            <i class="fas fa-users me-2"></i>Public Clubs
                        </a>
                        <a href="#faculty" class="btn btn-light btn-lg px-4 rounded-pill fw-bold">
                            <i class="fas fa-graduation-cap me-2"></i>Faculty Clubs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5">
            <section id="public" class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="display-5 fw-bold category-title">
                            Public Clubs
                        </h2>
                    </div>
                    <a href="{{ route('clubs.category', 'public') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                        View All <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($clubs->where('type', 'public')->take(3) as $club)
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-lg-hover">
                                <div class="card-img-top position-relative overflow-hidden">
                                    <div class="ratio ratio-16x9">
                                        <img src="{{ Storage::url($club->image) }}"
                                            class="img-fluid object-fit-cover"
                                            alt="{{ $club->name }}">
                                    </div>
                                </div>
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold mb-0">{{ $club['name'] }}</h5>
                                        <span class="badge bg-primary rounded-pill px-3">
                                            <i class="fas fa-users me-1"></i> 30+
                                        </span>
                                    </div>
                                    <p class="text-muted mb-3 flex-grow-1">{{ Str::limit($club['description'] ?? 'Join this vibrant community of students sharing common interests', 100) }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('club.show', $club['id']) }}" class="btn btn-primary rounded-pill w-100 py-2">
                                            Explore <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="faculty" class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="display-5 fw-bold category-title">
                            Faculty Clubs
                        </h2>
                    </div>
                    <a href="{{ route('clubs.category', 'faculty') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                        View All <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($clubs->where('type', 'faculty')->take(3) as $club)
                        <div class="col-lg-4 col-md-6">
                            <div class="card border-0 h-100 shadow-lg-hover">
                                <div class="card-img-top position-relative overflow-hidden">
                                    <div class="ratio ratio-16x9">
                                        <img src="{{ Storage::url($club->image) }}"
                                            class="img-fluid object-fit-cover"
                                            alt="{{ $club->name }}">
                                    </div>
                                </div>
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title fw-bold mb-0">{{ $club['name'] }}</h5>
                                        <span class="badge bg-primary rounded-pill px-3">
                                            <i class="fas fa-graduation-cap me-1"></i> Dept.
                                        </span>
                                    </div>
                                    <p class="text-muted mb-3 flex-grow-1">{{ Str::limit($club['description'] ?? 'Department-specific club for academic collaboration', 100) }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('club.show', $club['id']) }}" class="btn btn-primary rounded-pill w-100 py-2">
                                            Explore <i class="fas fa-chevron-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
