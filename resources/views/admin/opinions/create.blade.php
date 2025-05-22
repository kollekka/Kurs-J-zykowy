@extends('layouts.admin')

@section('title', 'Dodaj Nową Opinię (Admin)')

@section('content')
<div class="container-fluid">
    <div class="card card-admin">
        <div class="card-header">
            <h1 class="page-title mb-0">
                <i class="fas fa-comment-medical mr-2"></i>Dodaj Nową Opinię (jako Administrator)
            </h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.opinions.storeForAdmin') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="user_id">Użytkownik <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control form-control-admin @error('user_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Wybierz użytkownika</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="course_id">Kurs <span class="text-danger">*</span></label>
                    <select name="course_id" id="course_id" class="form-control form-control-admin @error('course_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>Wybierz kurs</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rating">Ocena (1-5) <span class="text-danger">*</span></label>
                    <input type="number" name="rating" id="rating" class="form-control form-control-admin @error('rating') is-invalid @enderror" value="{{ old('rating', 5) }}" min="1" max="5" required>
                    @error('rating')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="opinion">Treść opinii <span class="text-danger">*</span></label>
                    <textarea name="opinion" id="opinion" rows="5" class="form-control form-control-admin @error('opinion') is-invalid @enderror" required>{{ old('opinion') }}</textarea>
                    @error('opinion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-admin-primary">Dodaj Opinię</button>
                <a href="{{ route('admin.opinions.index') }}" class="btn btn-admin-secondary">Anuluj</a>
            </form>
        </div>
    </div>
</div>
@endsection