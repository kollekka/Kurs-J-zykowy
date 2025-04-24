<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }}</title>
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
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    <div class="container mt-4">
        <div class="row">
            <!-- Główna sekcja kursu -->
            <div class="col-md-8">
                <h1>{{ $course->name }}</h1>
                <p><strong>Language:</strong> {{ $course->language }}</p>
                <p><strong>Level:</strong> {{ $course->level }}</p>
                <p><strong>Start Date:</strong> {{ $course->start_date }}</p>
                <p><strong>End Date:</strong> {{ $course->end_date }}</p>
                <p><strong>Price:</strong> ${{ $course->price }}</p>
                <p><strong>Description:</strong> {{ $course->description ?? 'No description available.' }}</p>

                <!-- Sekcja lekcji -->
                <!-- Sekcja lekcji -->
                <div class="mt-4">
                    <h3>Lessons</h3>
                    <ul class="list-group">
                        @foreach ($course->lessons as $index => $lesson)
                            <li class="list-group-item">
                                @if ($course->enrollments->contains('user_id', Auth::id()) || $index === 0)
                                    <!-- Jeśli użytkownik jest zapisany lub to pierwsza lekcja -->
                                    <strong>{{ $lesson->order }}. {{ $lesson->title }}</strong>
                                    <p><strong>Content: </strong> {{ $lesson->content }}</p>
                                @else
                                    <!-- Jeśli użytkownik nie jest zapisany i to nie pierwsza lekcja -->
                                    <strong>{{ $lesson->order }}. {{ $lesson->title }}</strong>
                                    <p>Not available. Enroll in the course to access this lesson.</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($course->enrollments->contains('user_id', Auth::id()))
                    <!-- Jeśli użytkownik jest zapisany -->
                    <button class="btn btn-secondary" disabled>You are already enrolled</button>
                @else
                    <!-- Jeśli użytkownik nie jest zapisany -->
                    <a href="{{ route('enroll.show', $course->id) }}" class="btn btn-primary">Take Part in Course</a>
                @endif

                <a href="{{ url('/main') }}" class="btn btn-primary">Back to Courses</a>
            </div>

            <!-- Sekcja instruktora -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Instructor</h5>
                        <p><strong>Name:</strong> {{ $course->instructor->full_name }}</p>
                        <p><strong>Email:</strong> {{ $course->instructor->email }}</p>
                        <p><strong>Bio:</strong> {{ $course->instructor->bio ?? 'No bio available.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>