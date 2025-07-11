@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: white; padding-top: 70px; overflow-x: hidden; margin-top:70px;">
    <!-- Category Title -->
    <h2 class="text-center display-5 fw-bold mb-4 position-relative">
        <span class="position-relative">
            {{ ucfirst($type) }} Clubs
            <span class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 4px;"></span>
        </span>
    </h2>

    <!-- Clubs Grid - Changed to 3 columns -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4" style="margin-top:40px">
        @foreach($clubs as $club)
            <div class="col">
                <div class="card border-0 h-100 shadow-lg-hover">
                    <div class="card-img-top position-relative overflow-hidden">
                        <div class="ratio ratio-16x9">
                            <img src="{{ Storage::url($club->image) }}"
                                class="img-fluid object-fit-cover"
                                alt="{{ $club->name }}">
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $club['name'] }}</h5>
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
    <!-- Back to Clubs Button -->
    <div class="text-center mt-5">
        <a href="{{ route('student.home') }}" class="btn btn-secondary">Back to Clubs</a>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Ensure consistent button styling */
    .btn {
        transition: all 0.3s ease;
        font-weight: 600;
        padding: 10px 25px;
        font-size: 1rem;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    /* Card shadow and hover effects */
    .shadow-lg-hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .shadow-lg-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    /* Consistent card image sizing */
    .ratio.ratio-16x9 {
        height: 180px;
    }

    /* Text style for category titles */
    .display-5 {
        font-size: 2.5rem;
        letter-spacing: -0.5px;
    }

    /* Ensure cards have equal height */
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-body {
        flex-grow: 1;
    }
</style>
@endsection

@section('scripts')
<script>
    // Scroll to top functionality
    document.addEventListener('DOMContentLoaded', function() {
        const backToTop = document.createElement('a');
        backToTop.id = 'back-to-top';
        backToTop.href = '#';
        backToTop.className = 'btn btn-primary position-fixed rounded-circle';
        backToTop.style.bottom = '20px';
        backToTop.style.right = '20px';
        backToTop.style.width = '50px';
        backToTop.style.height = '50px';
        backToTop.style.display = 'flex';
        backToTop.style.alignItems = 'center';
        backToTop.style.justifyContent = 'center';
        backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
        backToTop.title = 'Back to top';

        document.body.appendChild(backToTop);

        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });
    });
</script>
@endsection
