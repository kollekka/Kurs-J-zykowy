@extends('layouts.admin')

@section('title', 'Dodaj Nowego Użytkownika')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-plus mr-2"></i>Dodaj Nowego Użytkownika</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Wystąpiły błędy:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nazwa użytkownika</label>
                        <input type="text" class="form-control form-control-admin" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Adres email</label>
                        <input type="email" class="form-control form-control-admin" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Hasło</label>
                        <input type="password" class="form-control form-control-admin" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Potwierdź hasło</label>
                        <input type="password" class="form-control form-control-admin" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">Czy administrator?</label>
                    </div>

                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-save mr-1"></i> Dodaj Użytkownika</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection