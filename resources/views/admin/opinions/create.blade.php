@extends('layouts.admin')

@section('title', 'Add New Opinion (Admin)')

@section('content')
<div class="container-fluid">
    <div class="card card-admin">
        <div class="card-header">
            <h1 class="page-title mb-0">
                <i class="fas fa-comment-medical mr-2"></i>Add New Opinion 
            </h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.opinions.storeForAdmin') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="user_id">User <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control form-control-admin @error('user_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Select user</option>
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
                    <label for="course_id">Course <span class="text-danger">*</span></label>
                    <select name="course_id" id="course_id" class="form-control form-control-admin @error('course_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('course_id') ? '' : 'selected' }}>Select course</option>
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
                    <label for="rating">Rating (1-5) <span class="text-danger">*</span></label>
                    <input type="number" name="rating" id="rating" class="form-control form-control-admin @error('rating') is-invalid @enderror" value="{{ old('rating', 5) }}" min="1" max="5" required>
                    @error('rating')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="opinion">Opinion content <span class="text-danger">*</span></label>
                    <textarea name="opinion" id="opinion" rows="5" class="form-control form-control-admin @error('opinion') is-invalid @enderror" required maxlength="1000">{{ old('opinion') }}</textarea>
                    @error('opinion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-admin-primary">Add Opinion</button>
                <a href="{{ route('admin.opinions.index') }}" class="btn btn-admin-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection