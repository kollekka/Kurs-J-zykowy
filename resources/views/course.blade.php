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
                <p><strong>Group Size:</strong> {{ $course->group_size }}</p>
                <p><strong>Available Spots:</strong> {{ $course->group_size - count($course->enrollments) }}</p>
                <p><strong>Rating:</strong> {{ $rating ?? 'No rating available.' }}</p>
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
                                    <p><strong>Duration: </strong> {{ \Carbon\Carbon::parse($lesson->duration)->minute }} minutes</p>
                                    <p><strong>Start Date: </strong> {{ $lesson->date }}, {{$lesson->time}}</p>
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
                @elseif (count($course->enrollments) >= ($course->group_size))
                    <button class="btn btn-secondary" disabled>No spots avaiable</button>
                @else
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
                <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Comments</h5>
                          @foreach($opinions as $opinion)
                            <p><strong>Name: </strong> {{ $opinion->user->name }} <strong>Rating: </strong> {{ $opinion->rating }}</p>
                            <p><strong>Comment: </strong> {{ $opinion->opinion }}</p>
                          @endforeach
                          @if(Auth::check() && $opinions->contains('user_id', Auth::id()))
                              <p>You have already left a comment.</p>
                          @elseif(Auth::check() && $course->enrollments->contains('user_id', Auth::id()))
                          <form action="{{ route('opinions.store', $course->id) }}" method="POST">
                              @csrf
                              <div class="form-group">
                                  <label for="content">Add a Comment:</label>
                                  <textarea id="content" name="content" class="form-control" rows="3" placeholder="Write your comment here..." required></textarea>
                              </div>
                              <div class="form-group">
                                  <label for="rating">Rating:</label>
                                  <select id="rating" name="rating" class="form-control" required>
                                      <option value="" disabled selected>Select a rating</option>
                                      <option value="1">1 - Poor</option>
                                      <option value="2">2 - Fair</option>
                                      <option value="3">3 - Good</option>
                                      <option value="4">4 - Very Good</option>
                                      <option value="5">5 - Excellent</option>
                                  </select>
                              </div>
                              <input type="hidden" name="course_id" value="{{ $course->id }}">
                              <button type="submit" class="btn btn-primary">Submit Comment</button>
                          </form>
                      @elseif(Auth::check())
                          <p>You are not enrolled in this course. Enroll to leave a comment.</p>
                      @else
                          <p>You must be logged in to leave a comment.</p>
                      @endif
                  </div>
              </div>
            </div>
        </div>
    </div>
</body>
</html>