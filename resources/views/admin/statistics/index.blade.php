@extends('layouts.admin')

@section('title', 'Panel Statystyk Systemu')
@push('styles')
    <style>
        .chart-container {
            position: relative;
            margin: auto;
            height: 500px; 
            width: 100%;
            max-width: 600px; 
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .chart-container.full-width {
            max-width: 100%; 
        }
        .stat-card-link {
            text-decoration: none;
            color: inherit; 
        }
        .stat-card-link:hover {
            text-decoration: none;
            color: inherit;
        }
        .stat-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            text-align: center;
        }
        .stat-item h5 {
            color: #5a6268;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        .stat-item .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--accent-color);
        }
        .list-group-item.stat-list-item {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            margin-bottom: 8px;
            border-radius: 0.25rem; 
        }
        .section-title {
            color: var(--main-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 10px;
            color: var(--accent-color);
        }
    </style>
@endpush

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0"><i class="fas fa-tachometer-alt mr-2"></i>Panel Statystyk</h1>
    </div>

    <h3 class="section-title mt-5"><i class="fas fa-info-circle"></i>Podsumowanie Systemu</h3>
    <div class="row mb-4">
        <div class="col-xl col-md-4 col-sm-6 mb-3">
            <div class="stat-item h-100">
                <h5><i class="fas fa-users mr-1"></i>Wszyscy Użytkownicy</h5>
                <p class="stat-value">{{ $stats['totalUsers'] }}</p>
            </div>
        </div>
        <div class="col-xl col-md-4 col-sm-6 mb-3">
            <div class="stat-item h-100">
                <h5><i class="fas fa-book-open mr-1"></i>Wszystkie Kursy</h5>
                <p class="stat-value">{{ $stats['totalCourses'] }}</p>
            </div>
        </div>
        <div class="col-xl col-md-4 col-sm-6 mb-3">
            <div class="stat-item h-100">
                <h5><i class="fas fa-chalkboard-teacher mr-1"></i>Instruktorzy</h5>
                <p class="stat-value">{{ $stats['totalInstructors'] }}</p>
            </div>
        </div>
        <div class="col-xl col-md-6 col-sm-6 mb-3">
            <div class="stat-item h-100">
                <h5><i class="fas fa-calendar-check mr-1"></i>Aktywne Kursy</h5>
                <p class="stat-value">{{ $stats['activeCoursesCount'] }}</p>
            </div>
        </div>
        <div class="col-xl col-md-6 col-sm-6 mb-3">
            <div class="stat-item h-100">
                <h5><i class="fas fa-star-half-alt mr-1"></i>Średnia Ocena Kursów</h5>
                <p class="stat-value">{{ $stats['averageCourseRating'] }} / 5</p>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <h3 class="section-title mt-5"><i class="fas fa-chart-pie"></i>Analiza Danych</h3>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card card-admin h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star mr-2"></i>Top 5 Kursów wg Ocen</h5>
                </div>
                <div class="card-body p-0">
                    @if($topRatedCourses->isEmpty())
                        <p class="text-center text-muted p-3">Brak ocenionych kursów.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($topRatedCourses as $index => $course)
                                <li class="list-group-item d-flex justify-content-between align-items-center stat-list-item">
                                    <div>
                                        <span class="font-weight-bold mr-2">{{ $index + 1 }}.</span>
                                        <a href="{{ route('admin.courses.show', $course->id) }}" class="text-decoration-none" style="color: var(--main-color);">
                                            {{ $course->name }}
                                        </a>
                                        <small class="text-muted">({{ $course->language }})</small>
                                    </div>
                                    <span class="badge badge-warning p-2" style="color: var(--main-color); font-size: 0.9rem;">
                                        <i class="fas fa-star"></i> {{ number_format($course->average_rating, 2) }} / 5
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-container">
                <h5 class="text-center mb-3" style="color: var(--main-color);">Top 5 Instruktorów wg Liczby Kursów</h5>
                <canvas id="instructorCoursesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12 mb-4">
            <div class="chart-container full-width">
                <h5 class="text-center mb-3" style="color: var(--main-color);">Rejestracje Nowych Użytkowników (ostatnie 6 miesięcy)</h5>
                <canvas id="userRegistrationsChart"></canvas>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <h3 class="section-title mt-5"><i class="fas fa-fire"></i>Ranking Popularności Kursów</h3>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-admin">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list-ol mr-2"></i>Top 5 Kursów wg Liczby Zapisów</h5>
                </div>
                <div class="card-body p-0">
                    @if($mostEnrolledCourses->isEmpty())
                        <p class="text-center text-muted p-3">Brak danych o zapisach na kursy.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($mostEnrolledCourses as $index => $course)
                                <li class="list-group-item d-flex justify-content-between align-items-center stat-list-item">
                                    <div>
                                        <span class="font-weight-bold mr-2">{{ $index + 1 }}.</span>
                                        <a href="{{ route('admin.courses.show', $course->id) }}" class="text-decoration-none" style="color: var(--main-color);">
                                            {{ $course->name }}
                                        </a>
                                        <small class="text-muted">({{ $course->language }})</small>
                                    </div>
                                    <span class="badge badge-pill p-2" style="background-color: var(--accent-color); color: white; font-size: 0.9rem;">
                                        {{ $course->enrollments_count }} {{ Str::plural('zapis', $course->enrollments_count) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Content Loaded. Initializing charts...');
    const instructorCoursesData = @json($instructorCourseCounts);
    console.log('Instructor Courses Data:', instructorCoursesData);
    const instructorCanvas = document.getElementById('instructorCoursesChart');
    console.log('Instructor Canvas Element:', instructorCanvas);

    if (instructorCoursesData && instructorCoursesData.length > 0) {
        if (instructorCanvas) {
            const instructorCtx = instructorCanvas.getContext('2d');
            new Chart(instructorCtx, {
                type: 'bar',
                data: {
                    labels: instructorCoursesData.map(item => item.full_name || 'Nieznany Instruktor'), 
                    datasets: [{
                        label: 'Liczba prowadzonych kursów',
                        data: instructorCoursesData.map(item => item.courses_count),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
            });
        } 
    } 

    const userRegistrationsData = @json($userRegistrationsMonthly);
    console.log('User Registrations Data:', userRegistrationsData);
    const userRegCanvas = document.getElementById('userRegistrationsChart');
    console.log('User Registrations Canvas Element:', userRegCanvas);

    if (userRegistrationsData && userRegistrationsData.length > 0) {
        if (userRegCanvas) {
            const userRegCtx = userRegCanvas.getContext('2d');
            console.log('Initializing User Registrations Chart.');
            new Chart(userRegCtx, {
                type: 'line',
                data: {
                    labels: userRegistrationsData.map(item => item.month),
                    datasets: [{
                        label: 'Nowi użytkownicy',
                        data: userRegistrationsData.map(item => item.total),
                        borderColor: 'rgba(230, 126, 34, 0.9)',
                        backgroundColor: 'rgba(230, 126, 34, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
            });
        } 
    } 
});
</script>
@endpush