
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Lekcję</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edytuj Lekcję</h1>
        <form action="{{ route('admin.updateLesson', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Tytuł lekcji</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $lesson->title }}" required>
            </div>

            <div class="form-group">
                <label for="content">Treść lekcji</label>
                <textarea name="content" id="content" class="form-control" rows="5">{{ $lesson->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="order">Kolejność</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ $lesson->order }}" required>
            </div>

            <div class="form-group">
                <label for="duration">Czas trwania (HH:MM)</label>
                <input type="time" name="duration" id="duration" class="form-control" value="{{ $lesson->duration }}" required>
            </div>

            <div class="form-group">
                <label for="date">Data lekcji</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $lesson->date }}" required>
            </div>

            <div class="form-group">
                <label for="time">Godzina lekcji</label>
                <input type="time" name="time" id="time" class="form-control" value="{{ $lesson->time }}" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Zapisz zmiany</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-block">Powrót</a>
        </form>
    </div>
</body>
</html>