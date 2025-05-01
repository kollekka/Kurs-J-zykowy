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
                      <form action="{{ route('user.update') }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="form-group">
                              <label for="name">Name</label>
                              <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                          </div>
                          <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                          </div>
                          <div class="form-group">
                              <label for="password">New Password (optional)</label>
                              <input type="password" id="password" name="password" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                          </div>
                          @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <p>{{ $error }}</p>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif
                          <button type="submit" class="btn btn-success">Save Changes</button>
                      </form>
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
                          <div class="row">
                              <!-- Lewa kolumna: podstawowe informacje -->
                              <div class="col-md-6">
                                  <h5>{{ $course->name }}</h5>
                                  <p>{{ $course->language }} - {{ $course->level }}</p>
                                  <p>Begins on: {{ $course->start_date }}</p>
                                  <p>Ends on: {{ $course->end_date }}</p>
                                  <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary btn-sm">View Course</a>
                              </div>
              
                              <!-- Prawa kolumna: dodatkowe informacje -->
                              <div class="col-md-6">
                                  <h6>Additional Information</h6>
                                  <p>Group Size: {{ $course->group_size }}</p>
                                  <p>Instructor: {{ $course->instructor->full_name }}</p>
                              </div>
                          </div>
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