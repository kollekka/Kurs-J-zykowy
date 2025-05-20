<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Instruktora</title>
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
            margin: 2rem auto;
            max-width: 800px;
        }

        .card-header {
            background: linear-gradient(45deg, var(--main-color), var(--accent-color));
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
        }

        textarea.form-control {
            border-radius: 15px;
            min-height: 150px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            transform: scale(1.05);
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
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Edytuj Instruktora</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.updateInstructor', $instructor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="full_name">Imię i nazwisko</label>
                        <input type="text" id="full_name" name="full_name" 
                               class="form-control" 
                               value="{{ $instructor->full_name }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               class="form-control" 
                               value="{{ $instructor->email }}" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="bio">Opis</label>
                        <textarea id="bio" name="bio" 
                                  class="form-control" 
                                  rows="5" 
                                  required>{{ $instructor->bio }}</textarea>
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
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>