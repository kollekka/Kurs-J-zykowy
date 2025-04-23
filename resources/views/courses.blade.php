<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Kursów</title>
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
          </ul>
          <!-- Tytuł na środku -->
          <span class="navbar-text mx-auto font-weight-bold" style="font-size: 1.5rem;">Lista Kursów</span>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
    </nav> 

    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Sekcja filtrów -->
            <div class="col-md-2 ml-0">
                <h5 class="mb-3" style="font-size: 1.2rem;">Filtry</h5>
                <form method="GET" action="{{ route('courses.index') }}">
                    <!-- Filtr: Poziom zaawansowania -->
                    <div class="form-group">
                        <label for="level">Poziom zaawansowania</label>
                        <select name="level" id="level" class="form-control">
                            <option value="">Wybierz poziom</option>
                            <option value="Beginner" {{ request('level') == 'Beginner' ? 'selected' : '' }}>Początkujący</option>
                            <option value="Intermediate" {{ request('level') == 'Intermediate' ? 'selected' : '' }}>Średniozaawansowany</option>
                            <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Zaawansowany</option>
                        </select>
                    </div>

                    <!-- Filtr: Język -->
                    <div class="form-group">
                        <label for="language">Język</label>
                        <input type="text" name="language" id="language" class="form-control" placeholder="Język" value="{{ request('language') }}">
                    </div>

                    <!-- Filtr: Cena -->
                    <div class="form-group">
                        <label for="max_price">Maksymalna cena</label>
                        <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Maksymalna cena" value="{{ request('max_price') }}">
                    </div>

                    <!-- Przycisk filtrowania -->
                    <button type="submit" class="btn btn-primary btn-block">Filtruj</button>
                </form>
            </div>

            <!-- Separator między filtrami a kursami -->
            <div class="col-md-1 d-flex justify-content-center">
                <div style="width: 1px; height: 220%; background-color: #ccc;"></div>
            </div>

            <!-- Lista kursów -->
            <div class="col-md-9">
                <div class="row justify-content-center">
                    @foreach ($courses as $course)
                        <div class="col-md-3 mb-4"> <!-- 4 kolumny w jednym wierszu -->
                            <div class="card h-100 d-flex flex-column">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $course->name }}</h5>
                                    <p class="card-text">{{ $course->language }} - {{ $course->level }}</p>
                                    <p class="card-text">Cena: ${{ $course->price }}</p>
                                    <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary mt-auto align-self-center">Zobacz Kurs</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginacja -->
                <div class="d-flex justify-content-center">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>