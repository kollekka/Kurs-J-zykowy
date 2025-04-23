<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Instruktora</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edytuj Instruktora</h1>
        <form action="{{ route('admin.updateInstructor', $instructor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="full_name">Imię i nazwisko</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="{{ $instructor->full_name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $instructor->email }}" required>
            </div>
            <div class="form-group">
                <label for="bio">Opis</label>
                <textarea id="bio" name="bio" class="form-control" required>{{ $instructor->bio }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Powrót</a>
        </form>
    </div>
</body>
</html>