@extends('layouts.app')

@section('title', 'Course List')

@push('styles')
<style>
    :root {
        --main-color: #2c3e50;
        --accent-color: #e67e22;
        --hover-color: #d35400;
        --light-bg: #f8f9fa;
    }

    body {
        background-color: var(--light-bg);
        overflow-x: hidden;
    }

    .page-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    .page-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.5rem;
        padding: 0.5rem;
        width: 100%;
    }

    .container-fluid {
        max-width: 100%;
        padding: 0 0.5rem;
    }

    .filter-sidebar {
        width: 24rem;
        height: 32rem;
        border-right: 1px;
        background: white;
        padding: 1.25rem;
        position: fixed;
        left: 20px;
        top: 80px;
        bottom: 0;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
    }

    .filter-sidebar h4 {
        color: var(--main-color);
        font-weight: 600;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--accent-color);
    }

    .filter-group {
        margin-bottom: 1.25rem;
        width: 100%;
    }

    .filter-group label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control {
        font-size: 0.9rem;
        padding: 0.4rem 0.75rem;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.15);
    }

    .price-slider {
        padding: 0.5rem 0;
    }

    .price-display {
        text-align: center;
        font-size: 1.2rem;
        color: var(--accent-color);
        font-weight: 600;
        margin: 0.5rem 0;
    }

    input[type="range"] {
        width: 100%;
        height: 8px;
        border-radius: 4px;
        background: #e9ecef;
        outline: none;
        -webkit-appearance: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--accent-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter {
        background: var(--accent-color);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        width: 100%;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-filter:hover {
        background: var(--hover-color);
        transform: translateY(-2px);
    }

    .course-content {
        flex: 1;
        margin-left: 250px;
        padding: 1.5rem;
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    @media (min-width: 1400px) {
        .course-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 1800px) {
        .course-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        height: 230px;
        min-width: 500px;
        transition: all 0.3s ease;
        background: linear-gradient(to right bottom, #ffffff, #f8f9fa);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .card-body {
        padding: 1.25rem;
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 1.25rem;
        height: 100%;
    }

    .course-info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-right: 1rem;
    }

    .course-meta {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        border-left: 1px solid #eee;
        padding-left: 1rem;
        min-width: 150px;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--main-color);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .badge-container {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .badge-language, .badge-level {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-language {
        background: var(--accent-color);
        color: white;
    }

    .badge-level {
        background: var(--main-color);
        color: white;
    }

    .course-dates {
        font-size: 0.9rem;
        color: #666;
    }

    .price-tag {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--accent-color);
        margin: 1rem 0;
        text-shadow: 1px 1px 0 rgba(0,0,0,0.05);
    }

    .btn-details {
        background: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 0.6rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        width: 100%;
        margin-top: auto;
    }

    .btn-details:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-details i {
        margin-right: 0.5rem;
    }

    .progress {
        height: 6px;
        border-radius: 3px;
        background: #e9ecef;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(to right, var(--accent-color), var(--hover-color));
    }

    @media (min-width: 1600px) {
        .course-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 2000px) {
        .course-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="filter-sidebar">
        <h4><i class="fas fa-filter mr-2"></i>Filters</h4>
        <form method="GET" action="{{ route('courses.index') }}">
            <div class="filter-group">
                <label for="level">Proficiency Level</label>
                <select name="level" id="level" class="form-control">
                    <option value="">All Levels</option>
                    <option value="A1" {{ request('level') == 'A1' ? 'selected' : '' }}>Beginner (A1)</option>
                    <option value="A2" {{ request('level') == 'A2' ? 'selected' : '' }}>Elementary (A2)</option>
                    <option value="B1" {{ request('level') == 'B1' ? 'selected' : '' }}>Intermediate (B1)</option>
                    <option value="B2" {{ request('level') == 'B2' ? 'selected' : '' }}>Upper Intermediate (B2)</option>
                    <option value="C1" {{ request('level') == 'C1' ? 'selected' : '' }}>Advanced (C1)</option>
                    <option value="C2" {{ request('level') == 'C2' ? 'selected' : '' }}>Mastery (C2)</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="language">Language</label>
                <select name="language" id="language" class="form-control">
                    <option value="">All Languages</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language }}" {{ request('language') == $language ? 'selected' : '' }}>
                            {{ $language }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="max_price">Maximum Price</label>
                <div class="price-display">
                    <span id="price_value">${{ request('max_price', 1000) }}</span>
                </div>
                <div class="price-slider">
                    <input type="range"
                           name="max_price"
                           id="max_price"
                           min="0"
                           max="1000"
                           step="10"
                           value="{{ request('max_price', 1000) }}"
                           oninput="document.getElementById('price_value').innerText = '$' + this.value">
                    <div class="d-flex justify-content-between mt-2">
                        <small>$0</small>
                        <small>$1000</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-filter">
                <i class="fas fa-search mr-2"></i>Search Courses
            </button>
        </form>
    </div>

    <div class="course-content">
        <div class="course-grid">
            @foreach ($courses as $course)
                <div class="card">
                    <div class="card-body">
                        <div class="course-info">
                            <div>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-language">{{ $course->language }}</span>
                                    <span class="badge-level">Level {{ $course->level }}</span>
                                </div>
                                <h5 class="card-title">{{ $course->name }}</h5>
                                <p class="mb-2">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ date('M d, Y', strtotime($course->start_date)) }} -
                                    {{ date('M d, Y', strtotime($course->end_date)) }}
                                </p>
                            </div>
                            <div class="progress-container">
                                <small class="d-flex justify-content-between mb-1">
                                    <span>Available Seats:</span>
                                    <span>{{ count($course->enrollments) }}/{{ $course->group_size }}</span>
                                </small>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar"
                                         style="width: {{ (count($course->enrollments)/$course->group_size)*100 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="course-meta">
                            <div class="price-tag">${{ $course->price }}</div>
                            <a href="{{ route('course.show', $course->id) }}" class="btn-details">
                                <i class="fas fa-info-circle mr-2"></i>Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $courses->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
