@extends('layouts.app')

@section('title', 'Rejestracja')

@push('styles')
<style>
    :root {
        --main-color: #2c3e50;
        --accent-color: #e67e22;
        --hover-color: #d35400;
        --light-bg: #f8f9fa;
    }

    body {
        background-color: var(--light-bg);
        padding-top: 80px;
        min-height: 100vh;
    }

    .register-card {
        max-width: 500px;
        margin: 0 auto;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .card-header {
        background: linear-gradient(45deg, var(--main-color), var(--accent-color));
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }

    .form-control {
        border-radius: 25px;
        border: 1px solid rgba(0,0,0,0.1);
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
    }

    label {
        font-weight: 600;
        color: var(--main-color);
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background-color: var(--accent-color);
        border-color: var(--accent-color);
        border-radius: 25px;
        padding: 12px 25px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: var(--hover-color);
        transform: scale(1.05);
    }

    .navbar {
        background: var(--main-color) !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .navbar-brand {
        color: var(--accent-color) !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        color: var(--hover-color) !important;
        transform: translateX(3px);
    }

    .nav-link {
        color: #ecf0f1 !important;
        position: relative;
        margin: 0 10px;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent-color);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .btn-outline-danger {
        border: 2px solid #e74c3c;
        color: #e74c3c;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: #e74c3c;
        color: white;
        transform: scale(1.05);
    }

    .text-danger {
        color: #e74c3c !important;
        font-size: 0.9em;
        margin-top: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="register-card">
        <div class="card-header text-center">
            <h3><i class="fas fa-user-plus mr-2"></i>Registration</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name"><i class="fas fa-user mr-2"></i>Name</label>
                    <input type="text" name="name" id="name" 
                           class="form-control" 
                           required autofocus value="{{ old('name') }}" maxlength="50">
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope mr-2"></i>Email address</label>
                    <input type="email" name="email" id="email" 
                           class="form-control" 
                           required value="{{ old('email') }}" maxlength="70">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock mr-2"></i>Password</label>
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           required pattern="^(?=.*[A-Z])(?=.*\d).{8,}$"
                           title="Password must be at least 8 characters long, include at least one uppercase letter, and one digit.">
                </div>

                <div class="form-group">
                    <label for="password_confirmation"><i class="fas fa-lock mr-2"></i>Confirm password</label>
                    <input type="password" name="password_confirmation" 
                           id="password_confirmation" class="form-control" required>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-user-check mr-2"></i>Register
                </button>
            </form>

            <div class="nav-back">
                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-arrow-left mr-2"></i>Back to login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection