<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admina')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --main-color: #2c3e50; 
            --accent-color: #e67e22; 
            --hover-color: #d35400; 
            --light-bg: #f8f9fa; 
            --card-header-bg-start: #34495e; 
            --card-header-bg-end: #2c3e50;   
        }

        body {
            background-color: var(--light-bg);
            padding-top: 70px; 
            font-family: 'Arial', sans-serif; 
        }

        .navbar-admin { 
            background: var(--main-color) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-admin .navbar-brand {
            color: var(--accent-color) !important;
            font-weight: 600;
        }

        .navbar-admin .nav-link {
            color: #ecf0f1 !important;
            margin: 0 10px;
        }
        .navbar-admin .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .btn-admin-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-admin-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
            transform: translateY(-2px);
        }
        .btn-admin-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-admin-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-2px);
        }
        .btn-admin-warning {
            background-color: #f1c40f;
            border-color: #f1c40f;
            color: var(--main-color);
             border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
         .btn-admin-warning:hover {
            background-color: #e0b30d;
            border-color: #d3a50c;
            transform: translateY(-2px);
        }

        .btn-admin-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
             border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-admin-danger:hover {
            background-color: #c0392b;
            border-color: #b33426;
            transform: translateY(-2px);
        }


        .card-admin { 
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .card-admin .card-header {
            background: linear-gradient(45deg, var(--card-header-bg-start), var(--card-header-bg-end));
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-admin .card-header h4, .card-admin .card-header h1 {
             margin-bottom: 0;
        }


        .table-admin { 
            margin-bottom: 0;
        }
        .table-admin th {
            background-color: #e9ecef; 
            color: var(--main-color);
            font-weight: 600;
        }
        .table-admin td, .table-admin th {
            vertical-align: middle;
        }

        .form-control-admin { 
            border-radius: 25px;
            border: 1px solid #ced4da;
            padding: 0.65rem 1.15rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }
        .form-control-admin:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
            background-color: #fff;
        }
        .page-title {
            color: var(--main-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        .action-buttons form {
            margin-right: 5px;
        }

    </style>
    @stack('styles') 
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin fixed-top">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt mr-1"></i>Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbarSupportedContent" aria-controls="adminNavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home mr-1"></i>Dashboard</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users mr-1"></i>Users</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.courses.index') }}"><i class="fas fa-book-open mr-1"></i>Courses</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.instructors.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.instructors.index') }}"><i class="fas fa-chalkboard-teacher mr-1"></i>Instructors</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.enrollments.index') }}"><i class="fas fa-user-check mr-1"></i>Enrollments</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.opinions.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.opinions.index') }}"><i class="fas fa-comments mr-1"></i>Reviews</a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.statistics.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.statistics.index') }}"><i class="fas fa-chart-bar mr-1"></i>Statistics</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.profile') }}"><i class="fas fa-user-circle mr-1"></i>{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm my-2 my-sm-0" type="submit"><i class="fas fa-sign-out-alt mr-1"></i>Logout</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </nav>


    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>
</html>
