<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        .card {
            min-height: 600px; 
        }
        #instructor_description {
            height: 300px; 
            resize: none; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        @if (Auth::user())
        <a class="navbar-brand" href="{{ route('user.profile') }}">Hello, {{ Auth::user()->name ?? 'Guest' }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <a class="navbar-brand" href="{{ route('login') }}">Hello, Guest</a>
        @endif
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('main') }}">Home <span class="sr-only">(current)</span></a>
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
      <div class="container mt-5">
        <h1 class="text-center mb-4">Witaj w panelu administratora!</h1>
        <div class="row">
            <!-- Sekcja dodawania instruktorów i kursów -->
            <div class="col-md-6">
                <!-- Dodawanie instruktorów -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Dodaj Instruktora</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.addInstructor') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="instructor_name">Imię i nazwisko</label>
                                <input type="text" id="instructor_name" name="full_name" class="form-control" placeholder="Wpisz imię i nazwisko" required>
                            </div>
                            <div class="form-group">
                                <label for="instructor_email">Email</label>
                                <input type="email" id="instructor_email" name="email" class="form-control" placeholder="Wpisz email" required>
                            </div>
                            <div class="form-group">
                                <label for="instructor_description">Opis</label>
                                <textarea id="instructor_description" name="bio" class="form-control" placeholder="Wpisz opis instruktora" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Dodaj Instruktora</button>
                        </form>
                    </div>
                </div>
    
                <!-- Dodawanie kursów -->
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Dodaj Kurs</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.addCourse') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="course_name">Nazwa Kursu</label>
                                <input type="text" id="course_name" name="name" class="form-control" placeholder="Wpisz nazwę kursu" required>
                            </div>
                            <div class="form-group">
                                <label for="course_language">Język</label>
                                <input type="text" id="course_language" name="language" class="form-control" placeholder="Wpisz język kursu" required>
                            </div>
                            <div class="form-group">
                                <label for="course_level">Poziom</label>
                                <select id="course_level" name="level" class="form-control" required>
                                    <option value="" disabled selected>Wybierz poziom</option>
                                    <option value="A1">A1</option>
                                    <option value="Intermediate">Średniozaawansowany</option>
                                    <option value="Advanced">Zaawansowany</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course_start_date">Data rozpoczęcia</label>
                                <input type="date" id="course_start_date" name="start_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="course_end_date">Data zakończenia</label>
                                <input type="date" id="course_end_date" name="end_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="course_price">Cena</label>
                                <input type="number" id="course_price" name="price" class="form-control" placeholder="Wpisz cenę kursu" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="course_instructor">Instruktor</label>
                                <select id="course_instructor" name="instructor_id" class="form-control" required>
                                    <option value="" disabled selected>Wybierz instruktora</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Dodaj Kurs</button>
                        </form>
                    </div>
                </div>
            </div>
    
            <!-- Sekcja list instruktorów i kursów -->
            <!-- Lista instruktorów -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Lista Instruktorów</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($instructors as $instructor)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $instructor->full_name }}
                                <div>
                                    <a href="{{ route('admin.editInstructor', $instructor->id) }}" class="btn btn-warning btn-sm">Edytuj</a>
                                    <form action="{{ route('admin.deleteInstructor', $instructor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tego instruktora?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Lista kursów -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Lista Kursów</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($courses as $course)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $course->name }}
                                <div>
                                    <a href="{{ route('admin.editCourse', $course->id) }}" class="btn btn-warning btn-sm">Edytuj</a>
                                    <form action="{{ route('admin.deleteCourse', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten kurs?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>