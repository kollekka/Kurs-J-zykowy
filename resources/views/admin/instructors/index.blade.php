@extends('layouts.admin')

@section('title', 'Manage Instructors')

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
        <h1 class="page-title mb-0"><i class="fas fa-chalkboard-teacher mr-2"></i>Manage Instructors</h1>
        <div>
            <a href="{{ route('admin.instructors.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Add Instructor
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
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->id }}</td>
                    <td>{{ $instructor->full_name }}</td>
                    <td>{{ $instructor->email }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.instructors.destroy', $instructor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this instructor?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No instructors found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
        @if ($instructors ->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $instructors->links('pagination::bootstrap-4') }}
            </div>
        @endif
@endsection
