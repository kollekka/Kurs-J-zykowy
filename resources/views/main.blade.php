<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --main-color: #2c3e50;
            --accent-color: #e67e22;
            --hover-color: #d35400;
        }

        .navbar-brand {
            color: var(--accent-color) !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            color: var(--hover-color) !important;
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

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
            transform: scale(1.05);
        }

        .btn-outline-danger {
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .btn-outline-danger:hover {
            transform: scale(1.05);
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

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .course-price {
            font-size: 1.5rem;
            color: var(--main-color);
            font-weight: bold;
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

        .background-pattern {
            position: relative;
            overflow: hidden;
            padding: 4rem 0;
        }

        .background-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(44, 62, 80, 0.05) 25%, transparent 25%, transparent 75%, rgba(44, 62, 80, 0.05) 75%),
                        linear-gradient(45deg, rgba(44, 62, 80, 0.05) 25%, transparent 25%, transparent 75%, rgba(44, 62, 80, 0.05) 75%);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
            z-index: -1;
        }

        .course-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Original Navbar structure preserved -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        @if (Auth::user())
        <a class="navbar-brand" href="{{ route('user.profile') }}">Hello, {{ Auth::user()->name ?? 'Guest' }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <a class="navbar-brand" href="{{ route('login') }}">Hello, Guest</a>
        @endif
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('courses.index') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Info</a>
                </li>
                @if (Auth::user() && Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                </li>
                @endif
            </ul>
            @if (Auth::check())
            <form action="{{ route('logout') }}" method="POST" class="form-inline my-2 my-lg-0">
                @csrf
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Wyloguj</button>
            </form>
            @endif
        </div>
    </nav>

    <!-- Original Carousel structure preserved -->
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/carousel1.png')}}" alt="First slide">
            </div>
        </div>
    </div>
    <div class="courses-header">
        <h2>Our Courses</h2>
        <p class="lead text-muted mt-3">Discover your perfect language journey</p>
    </div>

    <!-- Original Courses Grid preserved -->
    <div class="container mt-4">
        <div class="row">
            @foreach ($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text">{{ $course->language }} - {{ $course->level }}</p>
                        <p class="course-price">${{ $course->price }}</p>
                        <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary">View Course</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Original Footer structure preserved -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} Kurs Językowy. All rights reserved.</p>
            <p class="mb-0">
                <a href="#" class="text-white mx-2">Privacy Policy</a> |
                <a href="#" class="text-white mx-2">Terms of Service</a> |
                <a href="#" class="text-white mx-2">Contact Us</a>
            </p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>