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
                            <option value="A1" {{ request('level') == 'A1' ? 'selected' : '' }}>A1</option>
                            <option value="A2" {{ request('level') == 'A2' ? 'selected' : '' }}>A2</option>
                            <option value="B1" {{ request('level') == 'B1' ? 'selected' : '' }}>B1</option>
                            <option value="B2" {{ request('level') == 'B2' ? 'selected' : '' }}>B2</option>
                            <option value="C1" {{ request('level') == 'C1' ? 'selected' : '' }}>C1</option>
                            <option value="C2" {{ request('level') == 'C2' ? 'selected' : '' }}>C2</option>
                        </select>
                    </div>

                    <!-- Filtr: Język -->
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

                    <!-- Filtr: Cena -->
                    <div class="form-group">
                      <label for="max_price">Maksymalna cena: <span id="price_value">{{ request('max_price', 1000) }}</span> zł</label>
                      <input type="range" name="max_price" id="max_price" class="form-control-range" 
                             min="0" max="1000" step="10" 
                             value="{{ request('max_price', 0) }}" 
                             oninput="document.getElementById('price_value').innerText = this.value">
                  </div>

                    <!-- Przycisk filtrowania -->
                    <button type="submit" class="btn btn-primary btn-block">Filtruj</button>
                </form>
            </div>

            <!-- Separator między filtrami a kursami -->
            <div class="col-md-1 d-flex justify-content-center">
                <div style="width: 1px; height: 100%; background-color: #ccc;"></div>
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
                                    <p class="card-text">Data rozpoczęcia: {{ $course->start_date }}</p>
                                    <p class="card-text">Data zakończenia: {{ $course->end_date }}</p>
                                    <p class="card-test">Liczba miejsc: {{ count($course->enrollments) }} / {{ $course->group_size }}<p>
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