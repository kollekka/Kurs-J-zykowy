@extends('layouts.admin')

@section('title', 'Course Management')

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
        <h1 class="page-title mb-0"><i class="fas fa-book-open mr-2"></i>Course Management</h1>
        <div>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Add Course
            </a>
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
                <tr><th>ID</th><th>Name</th><th>Language</th><th>Level</th><th>Instructor</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->language }}</td>
                    <td>{{ $course->level }}</td>
                    <td>{{ $course->instructor->full_name ?? 'None' }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.lessons.index', ['course_id' => $course->id]) }}" class="btn btn-admin-info btn-sm" title="Manage lessons"><i class="fas fa-list-ul"></i> Lessons</a>
                        <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course? Deleting the course will also remove all related lessons and enrollments.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No courses found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($courses->hasPages())
            <div class="d-flex justify-content-center mt-3">
                 {{ $courses->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection
