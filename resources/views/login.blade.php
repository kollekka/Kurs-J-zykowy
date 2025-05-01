<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <h1>Logowanie</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" required>
        </div>
        @if ($errors->has('message'))
            <div class="text-danger">
               <p> {{ $errors->first('message') }} </p>
            </div>
         @endif

        <button type="submit">Zaloguj</button>
    </form>
</body>
</html>