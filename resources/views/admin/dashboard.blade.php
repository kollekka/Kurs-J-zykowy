@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
    <style>
        :root {
            --main-color: #2c3e50;
            --accent-color: #e67e22;
            --hover-color: #d35400;
            --light-bg: #f8f9fa;
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
            margin: 0 10px;
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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(45deg, var(--main-color), var(--accent-color));
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 1.5rem;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
        }

        #instructor_description {
            height: 300px;
            resize: none;
            border-radius: 15px !important;
        }

        .list-group-item {
            border: none;
            margin-bottom: 0.5rem;
            border-radius: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-sm {
            border-radius: 20px;
            padding: 0.25rem 1rem;
            margin-left: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-warning {
            background-color: #f1c40f;
            border-color: #f1c40f;
            color: var(--main-color);
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .alert-danger {
            border-radius: 15px;
            border: 2px solid #e74c3c;
        }

        .nav-pills .nav-link.active {
            background-color: var(--accent-color) !important;
        }
        .nav-pills {
        background: rgba(255,255,255,0.1);
        border-radius: 30px;
        padding: 5px;
        }

        .nav-pills .nav-link {
            color: var(--main-color) !important;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 30px;
            margin: 0 5px;
            padding: 12px 25px !important;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
            border: 2px solid var(--accent-color);
        }

        .nav-pills .nav-link.active {
            background: var(--accent-color) !important;
            color: white !important;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.4);
        }

        .nav-pills .nav-link:not(.active):hover {
            background: var(--hover-color) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .nav-pills .nav-link i {
            margin-right: 8px;
        }
        .nav-pills .nav-link::after {
            display: none !important;
        }
        .data-container {
        white-space: normal !important;  
        overflow-y: auto !important;      
        max-height: 300px;               
        word-break: break-word;          
        }

        
        .data-cell {
            min-width: 200px;                 
            padding: 10px;                    
        }

        
        .data-text {
            text-overflow: clip !important;   
            overflow: visible !important;     
        }
        .form-control{
            background-color: #f8f9fa !important;
            color: var(--main-color) !important;
            font-weight: 600 !important;
            height: auto !important;
        }
        .list-group{
            margin-bottom: 10px;
            overflow-y: auto;
            overflow-x: hidden;
            max-height: 400px;;
            -webkit-overflow-scrolling: touch;
        }
        .stat-card-link {
            text-decoration: none;
            color: inherit; 
        }
        .stat-card-link:hover {
            text-decoration: none;
            color: inherit;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: var(--main-color);">Admin Dashboard</h1>
        <!-- Sekcja Statystyk -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-center mb-4" style="color: var(--main-color);">Statystyki Systemu</h2>
            </div>

            <!-- Użytkownicy -->
            @if(isset($stats['users']))
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <a href="{{ route('admin.users.index') }}" class="stat-card-link">
                    <div class="card text-white bg-primary shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2"><i class="fas fa-users fa-3x"></i></div>
                            <h5 class="card-title" style="font-size: 1.1rem;">Użytkownicy</h5>
                            <p class="card-text display-4 font-weight-bold" style="font-size: 2.5rem;">{{ $stats['users'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

           
            @if(isset($stats['courses']))
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <a href="{{ route('admin.courses.index') }}" class="stat-card-link">
                    <div class="card text-white bg-success shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2"><i class="fas fa-book-open fa-3x"></i></div>
                            <h5 class="card-title" style="font-size: 1.1rem;">Kursy</h5>
                            <p class="card-text display-4 font-weight-bold" style="font-size: 2.5rem;">{{ $stats['courses'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            
            @if(isset($stats['instructors']))
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <a href="{{ route('admin.instructors.index') }}" class="stat-card-link">
                    <div class="card text-white bg-info shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2"><i class="fas fa-chalkboard-teacher fa-3x"></i></div>
                            <h5 class="card-title" style="font-size: 1.1rem;">Instruktorzy</h5>
                            <p class="card-text display-4 font-weight-bold" style="font-size: 2.5rem;">{{ $stats['instructors'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            <!-- Zapisy -->
            @if(isset($stats['enrollments']))
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <a href="{{ route('admin.enrollments.index') }}" class="stat-card-link">
                    <div class="card text-white bg-secondary shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2"><i class="fas fa-user-check fa-3x"></i></div>
                            <h5 class="card-title" style="font-size: 1.1rem;">Zapisy</h5>
                            <p class="card-text display-4 font-weight-bold" style="font-size: 2.5rem;">{{ $stats['enrollments'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            <!-- Opinie -->
            @if(isset($stats['opinions']))
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <a href="{{ route('admin.opinions.index') }}" class="stat-card-link">
                    <div class="card text-white bg-danger shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2"><i class="fas fa-comments fa-3x"></i></div>
                            <h5 class="card-title" style="font-size: 1.1rem;">Opinie</h5>
                            <p class="card-text display-4 font-weight-bold" style="font-size: 2.5rem;">{{ $stats['opinions'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            <!-- Płatności -->
            @if(isset($stats['payments']))
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <a href="{{ route('admin.payments.index') }}" class="stat-card-link">
                    <div class="card text-white bg-dark shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-2"><i class="fas fa-credit-card fa-3x"></i></div>
                            <h5 class="card-title" style="font-size: 1.1rem;">Płatności</h5>
                            <p class="card-text display-4 font-weight-bold" style="font-size: 2.5rem;">{{ $stats['payments'] }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif


        </div>
    </div>
@endsection