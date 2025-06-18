@extends('layouts.admin')

@section('title', 'Edit Course: ' . $course->name)

@section('content')
<div class="row">
    <div class="col-md-12 "> 
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-book-reader mr-2"></i>Edit Course: {{ $course->name }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Errors occurred:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <input type="text" class="form-control form-control-admin" id="name" name="name" value="{{ old('name', $course->name) }}" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="language">Language</label>
                        <input type="text" class="form-control form-control-admin" id="language" name="language" value="{{ old('language', $course->language) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control form-control-admin" id="level" name="level" required>
                            <option value="" disabled>Select level</option>
                            @php
                                $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
                            @endphp
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" {{ old('level', $course->level) == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control form-control-admin" id="start_date" name="start_date" value="{{ old('start_date', $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') : '') }}" min="{{ now()->toDateString() }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control form-control-admin" id="end_date" name="end_date" value="{{ old('end_date', $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') : '') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Price (PLN)</label>
                            <input type="number" class="form-control form-control-admin" id="price" name="price" value="{{ old('price', $course->price) }}" step="0.01" min="0" max="1000" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="group_size">Maximum Group Size</label>
                            <input type="number" class="form-control form-control-admin" id="group_size" name="group_size" value="{{ old('group_size', $course->group_size) }}" min="5" max="20" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="instructor_id">Instructor</label>
                        <select class="form-control form-control-admin" id="instructor_id" name="instructor_id" required>
                            <option value="" disabled>Select instructor</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>{{ $instructor->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-warning"><i class="fas fa-save mr-1"></i> Update Course</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>

 
    <div class="col-md-12 mt-4"> 
        <div class="card card-admin h-100"> 
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-list-ul mr-2"></i>Lessons for course: {{ $course->name }}</h4>
                <div>
                    <a href="{{ route('admin.lessons.create', ['course_id' => $course->id]) }}" class="btn btn-admin-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New Lesson
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($course->lessons->isEmpty())
                    <p class="text-center">No lessons defined for this course.</p>
                @else
                    <table class="table table-hover table-admin">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->lessons()->orderBy('date')->orderBy('time')->get() as $lesson)
                                <tr>
                                    <td>{{ $lesson->id }}</td>
                                    <td>{{ $lesson->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lesson->date)->format('d.m.Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lesson->time)->format('H:i') }}</td>
                                    <td>{{ $lesson->duration }}</td>
                                    <td>
                                        <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection