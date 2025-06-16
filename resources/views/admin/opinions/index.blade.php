@extends('layouts.admin')

@section('title', 'Manage Opinions')

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
        <h1 class="page-title mb-0"><i class="fas fa-comments mr-2"></i>Manage Opinions</h1>
        <div>
            <a href="{{ route('admin.opinions.createForAdmin') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Opinion
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
                <tr><th>ID</th><th>User</th><th>Course</th><th>Rating</th><th>Comment</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($opinions as $opinion)
                <tr>
                    <td>{{ $opinion->id }}</td>
                    <td>{{ $opinion->user->name ?? 'None' }}</td>
                    <td>{{ $opinion->course->name ?? 'None' }}</td>
                    <td>{{ $opinion->rating }}/5</td>
                    <td>{{ Str::limit($opinion->opinion, 50) }}</td>
                    <td class="action-buttons">
                        @if($opinion->course)
                        <a href="{{ route('course.show', $opinion->course_id) }}" class="btn btn-admin-info btn-sm" target="_blank" title="View course"><i class="fas fa-eye"> View</i></a><br>
                        @endif
                        <a href="{{ route('admin.opinions.edit', $opinion->id) }}" class="btn btn-admin-warning btn-sm w-100 mb-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.opinions.destroy', $opinion->id) }}" method="POST" class="d-inline w-100" onsubmit="return confirm('Are you sure you want to delete this opinion?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No opinions.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($opinions->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $opinions->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection