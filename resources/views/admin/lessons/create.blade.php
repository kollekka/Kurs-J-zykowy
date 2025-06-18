@extends('layouts.admin')

@section('title')
    Add New Lesson
    @if(isset($selectedCourse))
        - to course: {{ $selectedCourse->name }}
    @endif
@endsection

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0">
            <i class="fas fa-plus-circle mr-2"></i>
            Add New Lesson
            @if(isset($selectedCourse))
                <small class="text-muted">- to course: {{ $selectedCourse->name }}</small>
            @endif
        </h1>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.lessons.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Lesson Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control form-control-admin @error('title') is-invalid @enderror" value="{{ old('title') }}" required maxlength="100" placeholder="e.g. English for Beginners">
                @error('title')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration">Duration (minutes)</label>
                        <input type="time" name="duration" id="duration" class="form-control form-control-admin @error('duration') is-invalid @enderror" value="{{ old('duration') }}" placeholder="e.g. 45">
                        @error('duration')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                    <label for="content">Lesson Content/Description</label>
                    <textarea maxlength="1000" name="content" id="content" rows="4" class="form-control form-control-admin @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Lesson Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control form-control-admin @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                        @error('date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time">Lesson Time <span class="text-danger">*</span></label>
                        <input type="time" name="time" id="time" class="form-control form-control-admin @error('time') is-invalid @enderror" value="{{ old('time') }}" required min="00:30" max="02:00">
                        @error('time')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="course_id">Course <span class="text-danger">*</span></label>
                <select name="course_id" id="course_id" class="form-control form-control-admin @error('course_id') is-invalid @enderror" required>
                    <option value="" disabled {{ !old('course_id') && !isset($selectedCourse) ? 'selected' : '' }}>Select course...</option>
                    @foreach ($availableCourses as $course)
                        <option value="{{ $course->id }}" 
                                {{ old('course_id') == $course->id ? 'selected' : (isset($selectedCourse) && $selectedCourse->id == $course->id && !old('course_id') ? 'selected' : '') }}>
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
                    <option value="" disabled {{ !old('instructor_id') ? 'selected' : '' }}>Select instructor...</option>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->full_name }} 
                        </option>
                    @endforeach
                </select>
                @error('instructor_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-admin-primary">Add Lesson</button>
                <a href="{{ route('admin.lessons.index', isset($selectedCourse) ? ['course_id' => $selectedCourse->id] : []) }}" class="btn btn-admin-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection