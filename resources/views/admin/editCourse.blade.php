<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Kurs</title>
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
            margin-bottom: 1rem;
            height: 100%;
        }

        .card-header {
            background: linear-gradient(45deg, var(--main-color), var(--accent-color)) !important;
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            transform: scale(1.03);
        }

        .lesson-list {
            max-height: 250px; /* Zmniejszona wysokość */
            overflow-y: auto;
            margin: 0.5rem -1rem;
            padding: 0 1rem;
        }

        .lesson-item {
            background: white;
            border-radius: 10px;
            padding: 0.6rem;
            margin-bottom: 0.3rem; /* Mniejsze marginesy */
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            min-height: 80px; /* Stała wysokość dla każdej lekcji */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .lesson-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .lesson-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.3rem;
        }
        .form-control{
            height:auto !important;
        }

        @media (min-width: 992px) {
            .container {
                max-width: 1400px;
            }
            
            .dual-column {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.5rem;
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

    <div class="container">
        <div class="dual-column">
            <!-- Lewa karta - Edycja kursu -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-edit mr-2"></i>Edytuj Kurs</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.updateCourse', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nazwa Kursu</label>
                                    <input type="text" name="name" class="form-control" value="{{ $course->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Język</label>
                                    <input type="text" name="language" class="form-control" value="{{ $course->language }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Poziom</label>
                                    <select name="level" class="form-control" required>
                                        <option value="A1" {{ $course->level == 'A1' ? 'selected' : '' }}>A1</option>
                                        <option value="A2" {{ $course->level == 'A2' ? 'selected' : '' }}>A2</option>
                                        <option value="B1" {{ $course->level == 'B1' ? ' selected' : '' }}>B1</option>
                                        <option value="B2" {{ $course->level == 'B2' ? 'selected' : '' }}>B2</option>
                                        <option value="C1" {{ $course->level == 'C1' ? 'selected' : '' }}>C1</option>
                                        <option value="C2" {{ $course->level == 'C2' ? 'selected' : '' }}>C2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cena (zł)</label>
                                    <input type="number" name="price" class="form-control" value="{{ $course->price }}" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label>Liczba miejsc</label>
                                    <input type="number" name="group_size" class="form-control" value="{{ $course->group_size }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Data rozpoczęcia</label>
                                            <input type="date" name="start_date" class="form-control" value="{{ $course->start_date }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Data zakończenia</label>
                                            <input type="date" name="end_date" class="form-control" value="{{ $course->end_date }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lista lekcji -->
                        <div class="mt-4">
                            <h5><i class="fas fa-book-open mr-2"></i>Lekcje kursu ({{ $course->lessons->count() }})</h5>
                            <div class="lesson-list">
                                @foreach ($course->lessons as $lesson)
                                <div class="lesson-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Lekcja {{ $lesson->order }}: {{ $lesson->title }}</strong>
                                            <div class="lesson-info">
                                                {{ \Carbon\Carbon::parse($lesson->date)->format('d.m.Y') }} 
                                                | {{ $lesson->time }} 
                                                | Czas trwania: {{ \Carbon\Carbon::parse($lesson->duration)->format('H:i') }}
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.editLesson', $lesson->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Powrót
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Zapisz zmiany
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Prawa karta - Dodawanie lekcji -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Dodaj Lekcję</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.addLesson') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tytuł lekcji</label>
                                    <input type="text" name="title" class="form-control" required>
                                    @error('title')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Czas trwania</label>
                                    <input type="time" name="duration" class="form-control" 
                                           min="00:30" max="02:00" step="300" 
                                           value="01:00" required>
                                    @error('duration')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Data lekcji</label>
                                    <input type="date" name="date" class="form-control" 
                                           min="{{ $course->lessons->last()->date ?? now()->format('Y-m-d') }}" 
                                           required>
                                    @error('date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Godzina rozpoczęcia</label>
                                    <input type="time" name="time" class="form-control" 
                                           min="08:00" max="20:00" required>
                                    @error('time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Opis lekcji</label>
                            <textarea name="content" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus mr-2"></i>Dodaj Lekcję
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>