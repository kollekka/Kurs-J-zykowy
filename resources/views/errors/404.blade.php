<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Strona nie znaleziona</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
            transform: scale(1.05);
        }

        .error-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .error-code {
            font-size: 7rem;
            font-weight: bold;
            color: var(--accent-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        @if (Auth::user())
        <a class="navbar-brand" href="{{ route('user.profile') }}"><i class="fas fa-user-circle mr-2"></i>{{ Auth::user()->name }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
              <li class="nav-item">
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

    <div class="container error-container">
        <div>
            <h1 class="error-code">404</h1>
            <h2 class="mb-3">Oops! Strona nie została znaleziona.</h2>
            <p class="lead mb-4">
                Przepraszamy, ale strona, której szukasz, nie istnieje, została przeniesiona lub jest tymczasowo niedostępna.
            </p>
            <a href="{{ route('main') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-home mr-2"></i>Wróć na stronę główną
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>