@extends('layouts.admin')

@section('title', 'Dodaj Nowego Instruktora')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-plus mr-2"></i>Dodaj Nowego Instruktora</h4>
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

                <form action="{{ route('admin.instructors.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="full_name">Imię i Nazwisko</label>
                        <input type="text" class="form-control form-control-admin" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Adres email</label>
                        <input type="email" class="form-control form-control-admin" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="bio">Biografia / Opis</label>
                        <textarea class="form-control form-control-admin" id="bio" name="bio" rows="5" required>{{ old('bio') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-save mr-1"></i> Dodaj Instruktora</button>
                    <a href="{{ route('admin.instructors.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection