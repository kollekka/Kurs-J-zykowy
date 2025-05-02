<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Kursów</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
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

        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-top: 1rem;
        }

        .filter-section h5 {
            color: var(--main-color);
            font-weight: 600;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            padding: 0.5rem 1.25rem;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
        }

        .form-control-range::-webkit-slider-thumb {
            background: var(--accent-color);
            width: 20px;
            height: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .card-title {
            color: var(--main-color);
            font-weight: 600;
            font-size: 1.25rem;
        }

        .price-tag {
            color: var(--accent-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin: 1rem 0;
            text-align: center;
        }

        .separator {
            width: 1px;
            background: rgba(44,62,80,0.1);
            height: 80%;
            margin: 0 auto;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .course-meta {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .badge-language {
            background: var(--accent-color);
            color: white !important;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .badge-level {
            background: var(--main-color);
            color: white !important;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .progress-bar {
            background-color: var(--accent-color);
            height: 5px;
            border-radius: 2px;
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

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Filtry -->
            <div class="col-md-3">
                <div class="filter-section sticky-top">
                    <h5><i class="fas fa-filter mr-2"></i>Filtry</h5>
                    <form method="GET" action="{{ route('courses.index') }}">
                        <!-- Form fields unchanged -->
                        <div class="form-group">
                            <label for="level">Poziom zaawansowania</label>
                            <select name="level" id="level" class="form-control">
                              <option value="">Wybierz poziom</option>
                              <option value="A1" {{ request('level') == 'A1' ? 'selected' : '' }}>A1</option>
                              <option value="A2" {{ request('level') == 'A2' ? 'selected' : '' }}>A2</option>
                              <option value="B1" {{ request('level') == 'B1' ? 'selected' : '' }}>B1</option>
                              <option value="B2" {{ request('level') == 'B2' ? 'selected' : '' }}>B2</option>
                              <option value="C1" {{ request('level') == 'C1' ? 'selected' : '' }}>C1</option>
                              <option value="C2" {{ request('level') == 'C2' ? 'selected' : '' }}>C2</option>
                          </select>
                        </div>

                        <div class="form-group">
                            <label for="language">Język</label>
                            <select name="language" id="language" class="form-control">
                                <option value="">Wybierz język</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language }}" {{ request('language') == $language ? 'selected' : '' }}>
                                        {{ $language }}
                                    </option>    
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="max_price">Maksymalna cena: <span class="price-tag" id="price_value">{{ request('max_price', 1000) }}</span> zł</label>
                            <input type="range" name="max_price" id="max_price" class="form-control-range" 
                                min="0" max="1000" step="10" 
                                value="{{ request('max_price', 1000) }}" 
                                oninput="document.getElementById('price_value').innerText = this.value">
                            <div class="d-flex justify-content-between">
                                <small>0 zł</small>
                                <small>1000 zł</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block rounded-pill py-2 mt-3">
                            <i class="fas fa-filter mr-2"></i>Filtruj
                        </button>
                    </form>
                </div>
            </div>

            <!-- Separator -->
            <div class="col-md-1 d-none d-md-flex align-items-center">
                <div class="separator"></div>
            </div>

            <!-- Kursy -->
            <div class="col-md-8">
                <h3 class="mb-4" style="color: var(--main-color);"><i class="fas fa-graduation-cap mr-2"></i>Dostępne kursy</h3>
                <div class="row">
                    @foreach ($courses as $course)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge-language">{{ $course->language }}</span>
                                    <span class="badge-level">{{ $course->level }}</span>
                                </div>
                                
                                <h5 class="card-title">{{ $course->name }}</h5>
                                
                                <div class="course-meta">
                                    <p class="mb-2">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        {{ $course->start_date }} - {{ $course->end_date }}
                                    </p>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Zajęte miejsca:</span>
                                            <span>{{ count($course->enrollments) }}/{{ $course->group_size }}</span>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" 
                                                 style="width: {{ (count($course->enrollments)/$course->group_size)*100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="price-tag">{{ $course->price }} zł</p>
                                </div>
                                
                                <a href="{{ route('course.show', $course->id) }}" 
                                   class="btn btn-primary btn-block rounded-pill">
                                    <i class="fas fa-info-circle mr-2"></i>Szczegóły
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginacja -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $courses->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Ikony -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>