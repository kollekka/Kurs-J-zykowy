<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --main-color: #2c3e50;
            --accent-color: #e67e22;
            --hover-color: #d35400;
        }

        body {
            padding-top: 56px;
            background: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .card-header {
            background: var(--main-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
        }

        .btn-success {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: var(--hover-color);
            transform: scale(1.05);
        }

        .list-group-item {
            margin-bottom: 1rem;
            border: none;
            border-radius: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .course-divider {
            border-right: 2px solid #eee;
        }

        .rating-badge {
            background: var(--accent-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .alert-danger {
            border-radius: 10px;
        }

        .nav-link {
            position: relative;
            padding: 0.5rem 1rem !important;
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

        .navbar-brand {
        color: var(--accent-color) !important;
        font-weight: 600;
        transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ff944d !important;
            transform: translateX(3px);
        }
    </style>
</head>
<body>
    <!-- Navbar (bez zmian strukturalnych) -->
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
                  <a class="nav-link" href="{{ route('main') }}">Home</a>
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

    <!-- Główna zawartość -->
    <div class="container mt-5">
        <div class="row">
            <!-- Profil użytkownika -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Your Profile</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" 
                                       class="form-control border-0 rounded-pill shadow-sm"
                                       value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" 
                                       class="form-control border-0 rounded-pill shadow-sm"
                                       value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password (optional)</label>
                                <input type="password" id="password" name="password" 
                                       class="form-control border-0 rounded-pill shadow-sm">
                            </div>
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="form-control border-0 rounded-pill shadow-sm" required>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger py-2">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success btn-block rounded-pill">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista kursów -->
            <div class="col-md-8">
                <h3 class="mb-4" style="color: var(--main-color);">Your Courses</h3>
                @if($courses->isEmpty())
                    <div class="alert alert-info rounded-pill">
                        You are not enrolled in any courses yet.
                    </div>
                @else
                    <ul class="list-group">
                        @foreach ($courses as $course)
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-md-6 course-divider">
                                    <h5 class="text-accent">{{ $course->name }}</h5>
                                    <p class="mb-1">{{ $course->language }} - {{ $course->level }}</p>
                                    <small class="text-muted">
                                        {{ $course->start_date }} to {{ $course->end_date }}
                                    </small>
                                    <div class="mt-3">
                                        <a href="{{ route('course.show', $course->id) }}" 
                                           class="btn btn-primary btn-sm rounded-pill">
                                            View Course
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 pl-4">
                                    <h6 class="text-muted">Details</h6>
                                    <p class="mb-1">Group: {{ $course->group_size }}</p>
                                    <p class="mb-1">Instructor: {{ $course->instructor->full_name }}</p>
                                    <p class="mb-0">
                                        Rating: 
                                        <span class="rating-badge">
                                            {{ $course->opinions->avg('rating') ? number_format($course->opinions->avg('rating'), 2)." / 5" : 'No ratings yet' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Skrypty pozostają bez zmian -->
</body>
</html>