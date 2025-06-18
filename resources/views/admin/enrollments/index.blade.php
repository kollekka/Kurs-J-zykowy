@extends('layouts.admin')

@section('title', 'Manage Enrollments')

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
        <h1 class="page-title mb-0"><i class="fas fa-user-check mr-2"></i>Manage Enrollments</h1>
        <div>
            <a href="{{ route('admin.enrollments.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Enrollment
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
                <tr><th>Enrollment ID</th><th>User</th><th>Course</th><th>Enrollment Date</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse ($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->id }}</td>
                    <td>{{ $enrollment->user->name ?? 'None' }} ({{ $enrollment->user->email ?? '' }})</td>
                    <td>{{ $enrollment->course->name ?? 'None' }}</td>
                    <td>{{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d.m.Y H:i') : '-' }}</td>
                    <td><span class="badge badge-{{ $enrollment->status == 'active' ? 'success' : ($enrollment->status == 'pending' ? 'warning' : ($enrollment->status == 'completed' ? 'info' : 'secondary')) }}">{{ ucfirst($enrollment->status) }}</span></td>
                    <td class="action-buttons align-middle" style="vertical-align: middle;">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="btn btn-admin-warning btn-sm d-flex align-items-center">
                                <i class="fas fa-edit"></i> <span class="ml-1">Edit</span>
                            </a>
                            <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-admin-danger btn-sm d-flex align-items-center" onclick="return confirm('Are you sure you want to delete this enrollment?');">
                                    <i class="fas fa-trash"></i> <span class="ml-1">Delete Enrollment</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No enrollments.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($enrollments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $enrollments->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection