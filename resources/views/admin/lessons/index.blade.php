@extends('layouts.admin')

@section('title')
    Manage Lessons
    @if(isset($course))
        - {{ $course->name }}
    @endif
@endsection

@push('styles')
<style>
    .card-header {
        background: rgb(151, 73, 5) !important;
        color: #fff !important;
    }
    .card-header .page-title {
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0">
            <i class="fas fa-chalkboard-teacher mr-2"></i>
            Manage Lessons
            @if(isset($course))
                <small>- for course: {{ $course->name }}</small>
            @endif
        </h1>
        <div>
            @if(isset($course))
                <a href="{{ route('admin.lessons.create', ['course_id' => $course->id]) }}" class="btn btn-admin-primary btn-sm w-100 mb-2" style="min-width:90px;"><i class="fas fa-plus"></i> Add Lesson</a>
                <a href="{{ route('admin.lessons.index') }}" class="btn btn-admin-primary btn-sm w-100" style="min-width:90px;"><i class="fas fa-list"></i> All Lessons</a>
            @else
                <a href="{{ route('admin.lessons.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Add New Lesson</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-hover table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lesson Title</th>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>
                            @if($lesson->course)
                                <a href="{{ route('admin.courses.edit', $lesson->course_id) }}">{{ $lesson->course->name }}</a>
                            @else
                                No course
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($lesson->date)->format('d.m.Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($lesson->time)->format('H:i') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No lessons to display.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($lessons->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $lessons->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection
