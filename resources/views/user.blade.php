<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --main-color: #2c3e50;
            --accent-color: #e67e22;
            --hover-color: #d35400;
        }

        body {
            padding-top: 56px;
            background: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .card-header {
            background: var(--main-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
        }

        .btn-success {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: var(--hover-color);
            transform: scale(1.05);
        }

        .list-group-item {
            margin-bottom: 1rem;
            border: none;
            border-radius: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .course-divider {
            border-right: 2px solid #eee;
        }

        .rating-badge {
            background: var(--accent-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }

        .alert-danger {
            border-radius: 10px;
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

        .form-control {
            background-color: rgb(230, 230, 230);
        }

        /* Profile Image Styles */
        .profile-image-container {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
        }

        .profile-image-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent-color);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .default-profile-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--main-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            border: 4px solid var(--accent-color);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .default-profile-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .image-upload-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--accent-color);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .image-upload-overlay:hover {
            background: var(--hover-color);
            transform: scale(1.1);
        }

        .custom-file-input {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }

        .image-preview {
            margin-top: 10px;
            display: none;
        }

        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            border: 2px solid var(--accent-color);
        }

        .remove-image-btn {
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -8px;
            right: -8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .remove-image-btn:hover {
            background: #c0392b;
            transform: scale(1.1);
        }
       
    .filter-form {
        background-color: #f8f9fa; 
        border: 1px solid #ddd; 
        border-radius: 8px; 
        padding: 15px; 
        margin-bottom: 20px; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filter-form label {
        font-weight: bold;
        color: #333; 
    }

    
    .filter-form select {
        border: 1px solid #ccc; 
        border-radius: 5px; 
        padding: 8px 12px; 
        font-size: 14px; 
        color: #555; 
        background-color: #fff;
        transition: border-color 0.3s ease;
    }

    .filter-form select:focus {
        border-color: #007bff; 
        outline: none; 
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
    }

    
    .filter-form button {
        background-color: #007bff; 
        color: #fff; 
        border: none; 
        border-radius: 5px; 
        padding: 10px 20px; 
        font-size: 14px; 
        cursor: pointer; 
        transition: background-color 0.3s ease;
    }

    .filter-form button:hover {
        background-color: #0056b3; 
    }

    .filter-form .btn-secondary {
        background-color: #6c757d; 
    }

    .filter-form .btn-secondary:hover {
        background-color: #5a6268; 
    }
    </style>
</head>
<body>
    <!-- Navbar (bez zmian strukturalnych) -->
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

    <!-- Główna zawartość -->
    <div class="container mt-5">
        <div class="row">
            <!-- Profil użytkownika -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Your Profile</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data"> {{-- Moved form tag here and added enctype --}}
                            @csrf
                            @method('PUT')

                            <!-- Profile Image Section -->
                        <div class="profile-image-container">
                            <div class="profile-image-wrapper">
                                @if($user->profile_image && Storage::disk('public')->exists($user->profile_image))
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                        alt="Profile Image" 
                                        class="profile-image" 
                                        id="profileDisplay">
                                @else
                                    <div class="default-profile-icon" id="profileDisplay">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div class="image-upload-overlay" onclick="document.getElementById('profileImageInput').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <p class="text-muted mb-0">Click camera to change photo</p>
                        </div>

                            <!-- Hidden file input -->
                            <input type="file"
                                   id="profileImageInput"
                                   name="profile_image"
                                   accept="image/*"
                                   class="custom-file-input"
                                   onchange="previewImage(this)">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" 
                                       class="form-control border-0 rounded-pill shadow-sm"
                                       value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" 
                                       class="form-control border-0 rounded-pill shadow-sm"
                                       value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password (optional)</label>
                                <input type="password" id="password" name="password"
                                       class="form-control border-0 rounded-pill shadow-sm">
                            </div>
                            <div class="form-group">
                                <label for="current_password">Current Password (to save changes)</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="form-control border-0 rounded-pill shadow-sm" required>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger py-2">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success btn-block rounded-pill">
                                Save Changes
                            </button>
                        </form>

                        @if($user->profile_image && Storage::disk('public')->exists($user->profile_image))
                            <form action="{{ route('user.remove-profile-image') }}" method="POST" class="text-center mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm text-danger p-0"
                                        onclick="return confirm('Are you sure you want to remove your profile photo?')">
                                    <i class="fas fa-trash-alt"></i> Remove photo
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        
            
<div class="col-md-8">
    <h3 class="mb-4" style="color: var(--main-color);">Your Courses</h3>

    <!-- Formularz wyszukiwania i sortowania -->
    <form action="{{ route('user.profile') }}" method="GET" class="mb-4">
        <div class="card shadow-sm border-0 rounded-lg mb-3">
            <div class="card-body py-3">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4 mb-3 mb-md-0">
                        <label for="search" class="font-weight-bold" style="color: var(--main-color);">Search by Name:</label>
                        <input type="text" name="search" id="search" class="form-control border-0 rounded-pill shadow-sm"
                            value="{{ request('search') }}" placeholder="Course name">
                    </div>
                    <div class="form-group col-md-4 mb-3 mb-md-0">
                        <label for="language" class="font-weight-bold" style="color: var(--main-color);">Filter by Language:</label>
                        <select name="language" id="language" class="form-control border-0 rounded-pill shadow-sm">
                            <option value="">All Languages</option>
                            @foreach($languages as $language)
                                <option value="{{ $language }}" {{ request('language') === $language ? 'selected' : '' }}>
                                    {{ $language }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-3 mb-md-0">
                        <label for="sort" class="font-weight-bold" style="color: var(--main-color);">Sort by:</label>
                        <select name="sort" id="sort" class="form-control border-0 rounded-pill shadow-sm">
                            <option value="start_date_asc" {{ request('sort') === 'start_date_asc' ? 'selected' : '' }}>Start Date (Ascending)</option>
                            <option value="start_date_desc" {{ request('sort') === 'start_date_desc' ? 'selected' : '' }}>Start Date (Descending)</option>
                            <option value="rating_asc" {{ request('sort') === 'rating_asc' ? 'selected' : '' }}>Rating (Ascending)</option>
                            <option value="rating_desc" {{ request('sort') === 'rating_desc' ? 'selected' : '' }}>Rating (Descending)</option>
                        </select>
                    </div>
                </div>
                <div class="form-row mt-3 align-items-end">
                    <div class="form-group col-md-4 mb-2 mb-md-0">
                        <button type="submit" class="btn btn-success btn-block rounded-pill shadow-sm">
                            <i class="fas fa-filter mr-1"></i>Apply Filters
                        </button>
                    </div>
                    <div class="form-group col-md-4 mb-2 mb-md-0">
                        <a href="{{ route('user.profile') }}" class="btn btn-secondary btn-block rounded-pill shadow-sm">
                            <i class="fas fa-undo mr-1"></i>Clear Filters
                        </a>
                    </div>
                    <div class="form-group col-md-4 mb-0">
                        <select name="filter" id="filter" class="form-control border-0 rounded-pill shadow-sm" onchange="this.form.submit()">
                            <option value="upcoming" {{ $filter === 'upcoming' ? 'selected' : '' }}>Upcoming Courses</option>
                            <option value="past" {{ $filter === 'past' ? 'selected' : '' }}>Past Courses</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if($courses->isEmpty())
        <div class="alert alert-info rounded-pill">
            No courses found in this category.
        </div>
    @else
        <div style="max-height: 600px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
            <ul class="list-group">
                @foreach ($courses as $course)
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-md-6 course-divider">
                            <h5 class="text-accent">{{ $course->name }}</h5>
                            <p class="mb-1">{{ $course->language }} - {{ $course->level }}</p>
                            <p>Start Date: {{ $course->start_date }}</p>
                            <small class="text-muted">
                                {{ request('filter') === 'upcoming' ? 'Start: ' . $course->start_date : 'End: ' . $course->end_date }}
                            </small>
                            <div class="mt-3 d-flex align-items-center">
                                <a href="{{ route('course.show', $course->id) }}" 
                                class="btn btn-primary btn-sm rounded-pill">
                                    View Course
                                </a>
                                @if (now()->lt(\Carbon\Carbon::parse($course->end_date)))
                                <form action="{{ route('courses.unenroll', $course->id) }}" method="POST" class="d-inline ml-2" onsubmit="return confirm('Are you sure you want to unenroll from this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                        <i class="fas fa-times-circle mr-1"></i>Unenroll
                                    </button>
                                </form>
                                @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 pl-4">
                            <h6 class="text-muted">Details</h6>
                            <p class="mb-1">Group: {{ $course->group_size }}</p>
                            <p class="mb-1">Instructor: {{ $course->instructor->full_name }}</p>
                            <p class="mb-0">
                                Rating: 
                                <span class="rating-badge">
                                    {{ $course->opinions->avg('rating') ? number_format($course->opinions->avg('rating'), 2)." / 5" : 'No ratings yet' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
        </div>
    </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        function previewImage(input) {
            const currentDisplayElement = document.getElementById('profileDisplay');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    if (currentDisplayElement.tagName === 'IMG') {
                      
                        currentDisplayElement.src = e.target.result;
                    } else {
                        
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.alt = "Profile Preview";
                        newImg.className = 'profile-image'; 
                        newImg.id = 'profileDisplay';       
                        currentDisplayElement.parentNode.replaceChild(newImg, currentDisplayElement);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>