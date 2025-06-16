@extends('layouts.admin')

@section('title', 'Add New Instructor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-plus mr-2"></i>Add New Instructor</h4>
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

                <form action="{{ route('admin.instructors.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control form-control-admin" id="full_name" name="full_name" value="{{ old('full_name') }}" required maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control form-control-admin" id="email" name="email" value="{{ old('email') }}" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="bio">Biography / Description</label>
                        <textarea maxlength="1000" class="form-control form-control-admin" id="bio" name="bio" rows="5" required>{{ old('bio') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-save mr-1"></i> Add Instructor</button>
                    <a href="{{ route('admin.instructors.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection