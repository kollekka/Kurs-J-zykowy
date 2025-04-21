<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
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
            </div>
        </div>
    </div>
</body>
</html>