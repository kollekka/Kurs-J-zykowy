<!-- filepath: c:\Users\adria\Desktop\projekt laravel\Kurs-J-zykowy\resources\views\admin\editCourse.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Kurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
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
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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
        <h1 class="mb-4">Edytuj Kurs</h1>
        <form action="{{ route('admin.updateCourse', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nazwa Kursu</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $course->name }}" required>
            </div>
            <div class="form-group">
                <label for="language">Język</label>
                <input type="text" id="language" name="language" class="form-control" value="{{ $course->language }}" required>
            </div>
            <div class="form-group">
                <label for="level">Poziom</label>
                <select id="level" name="level" class="form-control" required>
                    <option value="Beginner" {{ $course->level == 'Beginner' ? 'selected' : '' }}>Początkujący</option>
                    <option value="Intermediate" {{ $course->level == 'Intermediate' ? 'selected' : '' }}>Średniozaawansowany</option>
                    <option value="Advanced" {{ $course->level == 'Advanced' ? 'selected' : '' }}>Zaawansowany</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Cena</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ $course->price }}" step="0.01" required>
            </div>

            <h3>Lekcje</h3>
            <ul class="list-group mb-3">
                @foreach ($course->lessons as $lesson)
                    <li class="list-group-item">
                        <strong>{{ $lesson->order }}. {{ $lesson->title }}</strong>
                        <p>{{ $lesson->content }}</p>
                        <a href="{{ route('admin.editLesson', $lesson->id) }}" class="btn btn-sm btn-warning">Edytuj</a>
                    </li>
                @endforeach
            </ul>

            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Powrót</a>
        </form>
    </div>
</body>
</html>