<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --main-color: #2c3e50;
            --accent-color: #e67e22;
            --hover-color: #d35400;
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
</head>
<body>
    <!-- Original Navbar structure preserved -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        @if (Auth::user())
        <a class="navbar-brand" href="{{ route('user.profile') }}"><i class="fas fa-user-circle mr-2"></i>{{ Auth::user()->name }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <a class="navbar-brand" href="{{ route('login') }}"><i class="fas fa-hand-wave mr-2"></i>Gość</a>
        @endif
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('main') }}"><i class="fas fa-home mr-1"></i>Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('courses.index') }}"><i class="fas fa-book-open mr-1"></i>Kursy</a>
            </li>
            @if (Auth::user() && Auth::user()->is_admin)
              <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tools mr-1"></i>Panel Admina</a>
              </li>
            @endif
          </ul>
          @if (Auth::check())
          <form action="{{ route('logout') }}" method="POST" class="form-inline my-2 my-lg-0">
              @csrf
              <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"><i class="fas fa-sign-out-alt mr-2"></i>Wyloguj</button>
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