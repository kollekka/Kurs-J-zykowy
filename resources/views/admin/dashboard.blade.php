<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('user.profile') }}">Hello, {{ Auth::user()->name ?? 'Guest' }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
        </div>
      </nav>    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Witaj w panelu administratora!</h1>
        <div class="row">
            <!-- Kolumna do dodawania instruktorów -->
            <div class="col-md-6">
                <div class="card shadow-sm">
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
                                <textarea id="instructor_description" name="bio" class="form-control" placeholder="Wpisz opis instruktora" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Dodaj Instruktora</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolumna do dodawania kursów -->
            <div class="col-md-6">
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
                                    <option value="Beginner">Początkujący</option>
                                    <option value="Intermediate">Średniozaawansowany</option>
                                    <option value="Advanced">Zaawansowany</option>
                                </select>
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
        </div>
    </div>
</body>
</html>