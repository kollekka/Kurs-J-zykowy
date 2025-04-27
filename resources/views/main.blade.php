<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <!-- Bootstrap Navbar, slightly modified, upper left corner changed to Hello + username -->


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
<!-- Bootstrap Carousel, for the main page, change photos later. -->
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="{{ asset('images/carousel1.png')}}" alt="First slide">
    </div>
  </div>
</div>

<!-- Bootstrap Grid for Cards -->
<div class="container mt-4">
  <div class="row">
    @foreach ($courses as $course)
      <div class="col-md-4 mb-4"> <!-- 3 kolumny w jednym wierszu -->
        <div class="card" style="width: 100%;">
          <div class="card-body">
            <h5 class="card-title">{{ $course->name }}</h5>
            <p class="card-text">{{ $course->language }} - {{ $course->level }}</p>
            <p class="card-text">Price: ${{ $course->price }}</p>
            <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary">View Course</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
</body>
</html>