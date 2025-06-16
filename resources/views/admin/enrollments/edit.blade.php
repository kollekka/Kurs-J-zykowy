@extends('layouts.admin')

@section('title', 'Edit Enrollment Status')

@push('styles')
<style>
    .card-header {
        background:rgb(151, 73, 5) !important;
        color: #fff !important;
    }
    .card-header .page-title {
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Edit Enrollment Status</h4>
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

                <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="enrollment_id_display">Enrollment ID:</label>
                        <input type="text" class="form-control form-control-admin" id="enrollment_id_display" value="{{ $enrollment->id }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select class="form-control form-control-admin" id="user_id" name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $enrollment->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="course_id">Course</label>
                        <select class="form-control form-control-admin" id="course_id" name="course_id" required>
                            {{-- Assuming you pass $courses (all courses) from the controller --}}
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $enrollment->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="enrollment_date">Enrollment Date</label>
                        <input type="datetime-local" class="form-control form-control-admin" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('Y-m-d\TH:i') : '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Enrollment Status</label>
                        <select class="form-control form-control-admin" id="status" name="status" required>
                            @php
                                $statuses = ['pending', 'active', 'cancelled'];
                            @endphp
                            @foreach ($statuses as $statusValue)
                                <option value="{{ $statusValue }}" {{ old('status', $enrollment->status) == $statusValue ? 'selected' : '' }}>{{ ucfirst($statusValue) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-warning"><i class="fas fa-save mr-1"></i> Update Enrollment</button>
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection