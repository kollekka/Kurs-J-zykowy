@extends('layouts.app')

@section('title', 'Main Page')

@push('styles')
<style>
    :root {
        --main-color: #2c3e50;
        --accent-color: #e67e22;
        --hover-color: #d35400;
    }
    body {
    overflow-x: hidden;
    }
    .navbar {
        background: var(--main-color) !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .navbar-brand {
        color: var(--accent-color) !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        color: var(--hover-color) !important;
        transform: translateX(3px);
    }

    .nav-link {
        color: #ecf0f1 !important;
        position: relative;
        margin: 0 2px;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent-color);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .btn-outline-danger {
        border: 2px solid #e74c3c;
        color: #e74c3c;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: #e74c3c;
        color: white;
        transform: scale(1.05);
    }

    .carousel-item img {
        height: 60vh;
        object-fit: cover;
        filter: brightness(0.8);
    }

    .card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: none;
        border-radius: 15px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    footer {
        background: linear-gradient(to right, #2c3e50, #3498db);
        padding: 2rem 0;
        margin-top: 4rem;
    }

    .nav-link {
        position: relative;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .badge-language {
        background: var(--accent-color);
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .badge-level {
        background: var(--main-color);
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .price-tag {
        color: var(--accent-color);
        font-size: 1.5rem;
        font-weight: 700;
        margin: 1rem 0;
        text-align: center;
    }

    .progress-bar {
        background-color: var(--accent-color);
        height: 5px;
        border-radius: 2px;
    }

    .course-meta {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .card-title {
        color: var(--main-color);
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .courses-header {
        text-align: center;
        margin: 4rem 0;
        position: relative;
        padding: 1rem 0;
    }

    .courses-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--main-color);
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        display: inline-block;
        background: linear-gradient(45deg, var(--accent-color), var(--hover-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .courses-header h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: var(--accent-color);
        border-radius: 2px;
    }

    .course-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
    <div class="carousel-wrapper" style="width:100vw;position:relative;left:50%;right:50%;margin-left:-50vw;margin-top:-25px;">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/carousel1.png')}}" alt="First slide" style="height:60vh;object-fit:cover;">
            </div>
        </div>
    </div>
</div>
    <div class="courses-header">
        <h2>Our Courses</h2>
        <p class="lead text-muted mt-3">Discover your perfect language journey</p>
    </div>

    <!-- Courses Grid -->
    <div class="container mt-4">
        <div class="row">
            @foreach ($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge-language">{{ $course->language }}</span>
                            <span class="badge-level">{{ $course->level }}</span>
                        </div>
                        
                        <h5 class="card-title">{{ $course->name }}</h5>
                        
                        <div class="course-meta">
                            <p class="mb-2">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $course->start_date }} - {{ $course->end_date }}
                            </p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Zajęte miejsca:</span>
                                    <span>{{ count($course->enrollments) }}/{{ $course->group_size }}</span>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" 
                                         style="width: {{ (count($course->enrollments)/$course->group_size)*100 }}%">
                                    </div>
                                </div>
                            </div>
                            
                            <p class="price-tag">{{ $course->price }} zł</p>
                        </div>
                        
                        <a href="{{ route('course.show', $course->id) }}" 
                           class="btn btn-primary btn-block rounded-pill">
                            <i class="fas fa-info-circle mr-2"></i>Szczegóły kursu
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container mt-5 text-center">
        <h4 class="mb-4">Rozkład kursów według języka</h4>
        <div style="max-width: 550px; margin: auto;">
            <canvas id="languageChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const hue = Math.floor((360 / count) * i);
            colors.push(`hsl(${hue}, 70%, 60%)`);
        }
        return colors;
    }

    const ctx = document.getElementById('languageChart').getContext('2d');

    const data = {
        labels: {!! json_encode($languageCounts->keys()) !!},
        datasets: [{
            data: {!! json_encode($languageCounts->values()) !!},
            backgroundColor: generateColors({{ count($languageCounts) }})
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'right'
                }
            }
        }
    };

    new Chart(ctx, config);
</script>
@endpush

@section('footer')
