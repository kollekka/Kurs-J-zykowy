@extends('layouts.app')

@section('title', 'Login')

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

    .login-card {
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

    .card-body {
        padding: 2rem;
        background: white;
        border-radius: 0 0 15px 15px;
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
        padding: 10px 25px;
        transition: all 0.3s ease;
        width: 100%;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: var(--hover-color);
        transform: scale(1.05);
    }

    .text-danger {
        color: #e74c3c !important;
        margin: 0.5rem 0;
        font-size: 0.9em;
    }

    .nav-back {
        text-align: center;
        margin-top: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="login-card">
        <div class="card-header text-center">
            <h3><i class="fas fa-sign-in-alt mr-2"></i>Login</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="name"><i class="fas fa-user mr-2"></i>Username:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock mr-2"></i>Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                @if ($errors->has('message'))
                    <div class="text-danger text-center mb-3">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first('message') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt mr-2"></i>Log in
                </button>
            </form>

            <div class="nav-back">
                <a href="{{ route('main') }}" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-arrow-left mr-2"></i>Back to main page
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-user-check mr-2"></i>Register
                </a>
            </div>
        </div>
    </div>
</div>
@endsection