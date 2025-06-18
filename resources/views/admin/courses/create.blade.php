@extends('layouts.admin')

@section('title', 'Add New Course')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Add New Course</h4>
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

                <form action="{{ route('admin.courses.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Course Name</label>
                        <input type="text" class="form-control form-control-admin" id="name" name="name" value="{{ old('name') }}" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="language">Language</label>
                        <input type="text" class="form-control form-control-admin" id="language" name="language" value="{{ old('language') }}" required maxlength="50"> 
                    </div>

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control form-control-admin" id="level" name="level" required>
                            <option value="" disabled {{ old('level') ? '' : 'selected' }}>Select level</option>
                            @php
                                $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
                            @endphp
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" {{ old('level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea maxlength="1000" class="form-control form-control-admin" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control form-control-admin" id="start_date" name="start_date" value="{{ old('start_date') }}" required min="{{ now()->toDateString() }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control form-control-admin" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Price </label>
                            <input type="number" class="form-control form-control-admin" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"  max="1000" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="group_size">Maximum Group Size</label>
                            <input type="number" class="form-control form-control-admin" id="group_size" name="group_size" value="{{ old('group_size') }}" min="5" max="20" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="instructor_id">Instructor</label>
                        <select class="form-control form-control-admin" id="instructor_id" name="instructor_id" required>
                            <option value="" disabled {{ old('instructor_id') ? '' : 'selected' }}>Select instructor</option>
                            @foreach ($instructors as $id => $name) {{-- Assuming $instructors is an array [id => name] --}}
                                <option value="{{ $id }}" {{ old('instructor_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-save mr-1"></i> Add Course</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection