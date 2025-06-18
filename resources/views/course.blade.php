<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --main-color: #2c3e50;
            --accent-color: #e67e22;
            --hover-color: #d35400;
            --light-bg: #f8f9fa;
        }

        body {
            background-color: var(--light-bg);
            padding-top: 80px;
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

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(45deg, var(--main-color), var(--accent-color));
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
        }

        .list-group-item {
            border: none;
            margin-bottom: 0.5rem;
            border-radius: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .lessons-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .lesson-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lesson-item h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .lesson-item small {
            color: #7f8c8d;
        }

        .lesson-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 15px;
        }

        .lesson-badge.upcoming {
            background-color: #f39c12;
            color: white;
        }

        .lesson-badge.completed {
            background-color: #27ae60;
            color: white;
        }

        .course-info {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .course-info h1 {
            font-size: 2rem;
            font-weight: bold;
            color: var(--main-color);
            margin-bottom: 1.5rem;
        }

        .course-info .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .course-info .btn-primary:hover {
            background-color: var(--hover-color);
            transform: scale(1.05);
        }

        .course-info .btn-outline-primary {
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .course-info .btn-outline-primary:hover {
            background-color: var(--main-color);
            color: white;
        }

    .desc-instructor-row {
        display: flex;
        width: 100%;
        margin-bottom: 1.5rem;
        align-items: flex-start;
    }
    .course-description {
        background: #fff;
        border-radius: 15px 0 0 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        padding: 16px 20px;
        flex: 1 1 0;
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        line-height: 1.5;
        border-right: 1px solid #eee;
        min-width: 0;
    }
    .instructor-box {
        background: #f9f9f9;
        border-radius: 0 15px 15px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        padding: 16px 24px;
        flex: 0 0 240px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 180px;
        max-width: 300px;
        font-size: 1rem;
    }
    .instructor-box h5 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    @media (max-width: 991px) {
        .desc-instructor-row {
            flex-direction: column;
        }
        .course-description, .instructor-box {
            border-radius: 15px;
            border-right: none;
            max-width: 100%;
        }
        .instructor-box {
            margin-top: 1rem;
        }
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        @if (Auth::user())
        <a class="navbar-brand" href="{{ route('user.profile') }}"><i class="fas fa-user-circle mr-2"></i>{{ Auth::user()->name }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <a class="navbar-brand" href="{{ route('login') }}"><i class="fas fa-hand-wave mr-2"></i>Guest</a>
        @endif
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('main') }}"><i class="fas fa-home mr-1"></i>Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('courses.index') }}"><i class="fas fa-book-open mr-1"></i>Courses</a>
            </li>
            @if (Auth::user() && Auth::user()->is_admin)
              <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tools mr-1"></i>Admin Panel</a>
              </li>
            @endif
          </ul>
          @if (Auth::check())
          <form action="{{ route('logout') }}" method="POST" class="form-inline my-2 my-lg-0">
              @csrf
              <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
          </form>
          @endif
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="course-info shadow-lg" style="background: linear-gradient(120deg, #fff 70%, #f8f9fa 100%); border: 1px solid #ececec;">
            <div class="d-flex flex-wrap align-items-start justify-content-between">
                <div style="flex:1 1 340px; min-width:260px;">
                    <h1 class="mb-3" style="font-weight:700; color:var(--main-color); letter-spacing:0.5px;">{{ $course->name }}</h1>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div class="mb-2"><i class="fas fa-language mr-2 text-secondary"></i><strong>Language:</strong> {{ $course->language }}</div>
                            <div class="mb-2"><i class="fas fa-signal mr-2 text-secondary"></i><strong>Level:</strong> {{ $course->level }}</div>
                            <div class="mb-2"><i class="fas fa-calendar-plus mr-2 text-secondary"></i><strong>Start:</strong> {{ $course->start_date }} <strong>End:</strong> {{ $course->end_date }}</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="mb-2"><i class="fas fa-users mr-2 text-secondary"></i><strong>Spots:</strong> {{ $course->group_size - count($course->enrollments) }}/{{ $course->group_size }}</div>
                            <div class="price-tag shadow-sm" style="font-size:2.1rem; color:var(--accent-color); font-weight:700; background:#fffbe9; border-radius:18px; padding:0.5rem 1.5rem; margin-right:1.5rem;">
                            ${{ $course->price }}
                        </div>
                        </div>
                    </div>
                    <div class="mb-3" style="font-size:1.08rem; color:#444;">
                        {{ $course->description }}
                    </div>
                    `
                </div>
                <div class="instructor-box ml-md-4 mt-4 mt-md-0 shadow-sm" style="background:#f7f7fa; border:1px solid #ececec; min-width:220px; max-width:300px;">
                    <h5 class="mb-2" style="font-weight:600; color:var(--main-color);"><i class="fas fa-chalkboard-teacher mr-2"></i>Instructor</h5>
                    <div class="mb-1" style="font-size:1.1rem;">
                        <i class="fas fa-user mr-2"></i>
                        {{ $course->instructor->full_name }}
                    </div>
                    @if(!empty($course->instructor->bio))
                        <div class="mt-2 text-muted" style="font-size:0.97em;">
                            {{ $course->instructor->bio }}
                        </div>
                    @endif
                </div>
            </div>
            </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-book-open mr-2"></i>Lessons</h4>
                    </div>
                    <div class="card-body lessons-container">
                        <ul class="list-group">
                            @foreach ($course->lessons->sortBy(function($lesson) { return $lesson->date . ' ' . $lesson->time; }) as $index => $lesson)
                                <li class="list-group-item">
                                    <div class="lesson-item">
                                        <div>
                                            <h5>{{ $lesson->order }}. {{ $lesson->title }}</h5>
                                            <small>{{ $lesson->date }} at {{ $lesson->time }}</small>
                                        </div>
                                        <span class="lesson-badge {{ $currentDate > $lesson->date . ' ' . $lesson->time ? 'completed' : 'upcoming' }}">
                                            {{ $currentDate > $lesson->date . ' ' . $lesson->time ? 'Completed' : 'Upcoming' }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-pen mr-2"></i>Add your opinion</h5>
                    </div>
                    <div class="card-body">
                        @if(Auth::check() && $opinions->contains('user_id', Auth::id()))
                            <div class="alert alert-info">You have already added an opinion</div>
                        @elseif(Auth::check() && $course->enrollments->contains('user_id', Auth::id()))
                            <form action="{{ route('opinions.store', $course->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="opinion_text">Your opinion</label>
                                    <textarea name="opinion" id="opinion_text" class="form-control @error('opinion') is-invalid @enderror" rows="3" required>{{ old('opinion') }}</textarea>
                                    @error('opinion')
                                        <div class="invalid-feedback"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rating_value">Rating</label>
                                    <select name="rating" id="rating_value" class="form-control @error('rating') is-invalid @enderror" required>
                                        <option value="" {{ old('rating') ? '' : 'selected' }} disabled>Select rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}★</option>
                                        @endfor
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback"></div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Add opinion</button>
                            </form>
                        @elseif(Auth::check())
                            <div class="alert alert-warning">You must be enrolled in the course to add an opinion</div>
                        @else
                            <div class="alert alert-info">Log in to add an opinion</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-comments mr-2"></i>Other users' opinions</h5>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @foreach($opinions as $opinion)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>{{ $opinion->user->name }}</h6>
                                    <div>
                                        @for ($i = 0; $i < $opinion->rating; $i++)
                                            <span class="text-warning">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0">{{ $opinion->opinion }}</p>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>