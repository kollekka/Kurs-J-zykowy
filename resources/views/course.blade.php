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

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            transform: scale(1.05);
        }

        .checked {
            color: #ffd700;
        }

        .course-info {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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

    <div class="container mt-4">
        <div class="row">
            <!-- Główna sekcja kursu -->
            <div class="col-md-8">
                <div class="course-info">
                    <h1 class="mb-4 ">{{ $course->name }}</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Język:</strong> {{ $course->language }}</p>
                            <p><strong>Poziom:</strong> {{ $course->level }}</p>
                            <p><strong>Data rozpoczęcia:</strong> {{ $course->start_date }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Data zakończenia:</strong> {{ $course->end_date }}</p>
                            <p><strong>Cena:</strong> ${{ $course->price }}</p>
                            <p><strong>Wolne miejsca:</strong> {{ $course->group_size - count($course->enrollments) }}/{{ $course->group_size }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4>Opis kursu</h4>
                        <p>{{ $course->description ?? 'Brak opisu kursu' }}</p>
                    </div>
                </div>

                <!-- Sekcja lekcji -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-book-open mr-2"></i>Lekcje</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($course->lessons as $index => $lesson)
                            <li class="list-group-item">
                                @if ($course->enrollments->contains('user_id', Auth::id()) || $index === 0)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5>{{ $lesson->order }}. {{ $lesson->title }}</h5>
                                            <p class="mb-0">{{ $lesson->content }}</p>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($lesson->duration)->minute }} minut, 
                                                {{ $lesson->date }}, {{$lesson->time}}
                                            </small>
                                        </div>
                                        <span class="badge {{ $currentDate > $lesson->date . ' ' . $lesson->time ? 'badge-success' : 'badge-warning' }}">
                                            {{ $currentDate > $lesson->date . ' ' . $lesson->time ? 'Zakończona' : 'Nadchodząca' }}
                                        </span>
                                    </div>
                                @else
                                    <h5>{{ $lesson->order }}. {{ $lesson->title }}</h5>
                                    <p class="text-muted">Zapisz się na kurs aby zobaczyć treść</p>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    @if ($course->enrollments->contains('user_id', Auth::id()))
                        <button class="btn btn-secondary" disabled>Jesteś już zapisany</button>
                    @elseif (count($course->enrollments) >= ($course->group_size))
                        <button class="btn btn-secondary" disabled>Brak wolnych miejsc</button>
                    @else
                        <a href="{{ route('enroll.show', $course->id) }}" class="btn btn-primary">Zapisz się na kurs</a>
                    @endif
                    <a href="{{ url('/main') }}" class="btn btn-outline-primary">Powrót do kursów</a>
                </div>
            </div>

            <!-- Sekcja instruktora i komentarzy -->
            <div class="col-md-4">
                <!-- Instruktor -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Instruktor</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $course->instructor->full_name }}</h5>
                        <p class="text-muted">{{ $course->instructor->email }}</p>
                        <p>{{ $course->instructor->bio ?? 'Brak informacji o instruktorze' }}</p>
                    </div>
                </div>

                <!-- Komentarze -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-comments mr-2"></i>Opinie</h4>
                    </div>
                    <div class="card-body">
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

                        @if(Auth::check() && $opinions->contains('user_id', Auth::id()))
                            <div class="alert alert-info">Już dodałeś opinię</div>
                        @elseif(Auth::check() && $course->enrollments->contains('user_id', Auth::id()))
                        <form action="{{ route('opinions.store', $course->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Twoja opinia</label>
                                <textarea name="content" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Ocena</label>
                                <select name="rating" class="form-control" required>
                                    <option value="" selected>Wybierz ocenę</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} gwiazd{{ $i == 1 ? 'ka' : 'ek' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Dodaj opinię</button>
                        </form>
                        @elseif(Auth::check())
                            <div class="alert alert-warning">Musisz być zapisany na kurs aby dodać opinię</div>
                        @else
                            <div class="alert alert-info">Zaloguj się aby dodać opinię</div>
                        @endif
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