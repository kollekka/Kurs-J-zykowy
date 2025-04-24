{{-- filepath: c:\Users\adria\Desktop\projekt laravel\Kurs-J-zykowy\resources\views\user.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <!-- Pasek nawigacyjny -->
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
    <!-- Główna zawartość -->
    <div class="container mt-4">
        <div class="row">
            <!-- Profil użytkownika po lewej -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Your Profile</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Joined on:</strong> {{ $user->created_at->format('d M Y') }}</p>
                        <a href="#" class="btn btn-warning">Edit Profile</a>
                    </div>
                </div>
            </div>

            <!-- Lista kursów po prawej -->
            <div class="col-md-8">
                <h3>Your Courses</h3>
                @if($courses->isEmpty())
                    <p>You are not enrolled in any courses yet.</p>
                @else
                    <ul class="list-group">
                        @foreach ($courses as $course)
                            <li class="list-group-item">
                                <h5>{{ $course->name }}</h5>
                                <p>{{ $course->language }} - {{ $course->level }}</p>
                                <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary btn-sm">View Course</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j6v9KR9sAEqfh5nhuwj9" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFwAIlUjPpGa26cq9A9cUG657M" crossorigin="anonymous"></script>
</body>
</html>