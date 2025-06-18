@extends('layouts.admin')

@section('title')
    Edit Lesson: {{ $lesson->title }}
@endsection


@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0 text-white">
            <i class="fas fa-edit mr-2"></i>
            Edit lesson: <span class="text-white">{{ $lesson->title }}</span>
            @if($lesson->course)
            <small class="text-white">- In course: {{ $lesson->course->name }}</small>
            @endif
        </h1>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Lesson title <span class="text-danger">*</span></label>
                <input maxlength="100" type="text" name="title" id="title" class="form-control form-control-admin @error('title') is-invalid @enderror" value="{{ old('title', $lesson->title) }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration">Duration </label>
                        <input type="time" name="duration" id="duration" class="form-control form-control-admin @error('duration') is-invalid @enderror" value="{{ old('duration', $lesson->duration) }}" placeholder="np. 45">
                        @error('duration')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Lesson description/content</label>
                <textarea maxlength="1000" name="content" id="content" rows="4" class="form-control form-control-admin @error('content') is-invalid @enderror">{{ old('content', $lesson->content) }}</textarea>
                @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Lesson date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control form-control-admin @error('date') is-invalid @enderror" value="{{ old('date', $lesson->date) }}" required>
                        @error('date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time">Lesson time <span class="text-danger">*</span></label>
                        <input type="time" name="time" id="time" class="form-control form-control-admin @error('time') is-invalid @enderror" value="{{ old('time', $lesson->time) }}" required min="08:00" max="20:00">
                        @error('time')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="course_id">Course <span class="text-danger">*</span></label>
                <select name="course_id" id="course_id" class="form-control form-control-admin @error('course_id') is-invalid @enderror" required>
                    @foreach ($availableCourses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label for="instructor_id">Instructor <span class="text-danger">*</span></label>
                <select name="instructor_id" id="instructor_id" class="form-control form-control-admin @error('instructor_id') is-invalid @enderror" required>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('instructor_id', $lesson->instructor_id) == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->full_name ?? $instructor->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('instructor_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-admin-primary">Save Changes</button>
                <a href="{{ route('admin.lessons.index', $lesson->course_id ? ['course_id' => $lesson->course_id] : []) }}" class="btn btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection