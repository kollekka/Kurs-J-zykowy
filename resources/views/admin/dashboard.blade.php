<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .card-header {
            background: linear-gradient(45deg, var(--main-color), var(--accent-color));
            color: white !important;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
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

        #instructor_description {
            height: 300px;
            resize: none;
            border-radius: 15px !important;
        }

        .list-group-item {
            border: none;
            margin-bottom: 0.5rem;
            border-radius: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-sm {
            border-radius: 20px;
            padding: 0.25rem 1rem;
            margin-left: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-warning {
            background-color: #f1c40f;
            border-color: #f1c40f;
            color: var(--main-color);
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .alert-danger {
            border-radius: 15px;
            border: 2px solid #e74c3c;
        }

        .nav-pills .nav-link.active {
            background-color: var(--accent-color) !important;
        }
        .nav-pills {
        background: rgba(255,255,255,0.1);
        border-radius: 30px;
        padding: 5px;
        }

        .nav-pills .nav-link {
            color: var(--main-color) !important;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 30px;
            margin: 0 5px;
            padding: 12px 25px !important;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
            border: 2px solid var(--accent-color);
        }

        .nav-pills .nav-link.active {
            background: var(--accent-color) !important;
            color: white !important;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.4);
        }

        .nav-pills .nav-link:not(.active):hover {
            background: var(--hover-color) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .nav-pills .nav-link i {
            margin-right: 8px;
        }
        .nav-pills .nav-link::after {
            display: none !important;
        }
        .data-container {
        white-space: normal !important;  
        overflow-y: auto !important;      
        max-height: 300px;               
        word-break: break-word;          
        }

        
        .data-cell {
            min-width: 200px;                 
            padding: 10px;                    
        }

        
        .data-text {
            text-overflow: clip !important;   
            overflow: visible !important;     
        }
        .form-control{
            background-color: #f8f9fa !important;
            color: var(--main-color) !important;
            font-weight: 600 !important;
            height: auto !important;
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        @if (Auth::user())
        <a class="navbar-brand" href="{{ route('user.profile') }}">Hello, {{ Auth::user()->name ?? 'Guest' }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
        @else
        <a class="navbar-brand" href="{{ route('login') }}">Hello, Guest</a>
        @endif
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('main') }}">Home</a>
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

    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: var(--main-color);">Admin Dashboard</h1>
        <div class="row">
            <!-- Lewa kolumna - formularze -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Create New</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4" id="createTabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#createInstructor">Instructor</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#createCourse">Course</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Formularz instruktora -->
                            <div class="tab-pane fade show active" id="createInstructor">
                                <form action="{{ route('admin.addInstructor') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="instructor_name">Imię i nazwisko</label>
                                        <input type="text" id="instructor_name" name="full_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="instructor_email">Email</label>
                                        <input type="email" id="instructor_email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="instructor_description">Opis</label>
                                        <textarea id="instructor_description" name="bio" class="form-control" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block rounded-pill py-2">
                                        <i class="fas fa-plus mr-2"></i>Create Instructor
                                    </button>
                                </form>
                            </div>

                            <!-- Formularz kursu -->
                            <div class="tab-pane fade" id="createCourse">
                                <form action="{{ route('admin.addCourse') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="course_name">Nazwa Kursu</label>
                                        <input type="text" id="course_name" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_language">Język</label>
                                        <input type="text" id="course_language" name="language" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_level">Poziom</label>
                                        <select id="course_level" name="level" class="form-control" required>
                                            <option value="" disabled selected>Wybierz poziom</option>
                                            <option value="A1">A1</option>
                                            <option value="A2">A2</option>
                                            <option value="B1">B1</option>
                                            <option value="B2">B2</option>
                                            <option value="C1">C1</option>
                                            <option value="C2">C2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_start_date">Data rozpoczęcia</label>
                                        <input type="date" id="course_start_date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_end_date">Data zakończenia</label>
                                        <input type="date" id="course_end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_price">Cena</label>
                                        <input type="number" id="course_price" name="price" class="form-control" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_group_size">Rozmiar Grupy</label>
                                        <input type="number" id="course_group_size" name="group_size" class="form-control" step="1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_instructor">Instruktor</label>
                                        <select id="course_instructor" name="instructor_id" class="form-control" required>
                                            <option value="" disabled selected>Wybierz instruktora</option>
                                            @foreach ($instructors as $instructor)
                                                <option value="{{ $instructor->id }}">{{ $instructor->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-success btn-block rounded-pill py-2">
                                        <i class="fas fa-plus mr-2"></i>Create Course
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prawa kolumna - zarządzanie -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-tasks mr-2"></i>Management</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4" id="manageTabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#manageInstructors">Instructors</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#manageCourses">Courses</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Zarządzanie instruktorami -->
                            <div class="tab-pane fade show active" id="manageInstructors">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h5 class="mb-0">Instructors List</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach ($instructors as $instructor)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $instructor->full_name }}
                                                <div>
                                                    <a href="{{ route('admin.editInstructor', $instructor->id) }}" class="btn btn-warning btn-sm">Edytuj</a>
                                                    <form action="{{ route('admin.deleteInstructor', $instructor->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                                    </form>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Zarządzanie kursami -->
                            <div class="tab-pane fade" id="manageCourses">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h5 class="mb-0">Courses List</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @foreach ($courses as $course)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $course->name }}
                                                <div>
                                                    <a href="{{ route('admin.editCourse', $course->id) }}" class="btn btn-warning btn-sm">Edytuj</a>
                                                    <form action="{{ route('admin.deleteCourse', $course->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                                    </form>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>