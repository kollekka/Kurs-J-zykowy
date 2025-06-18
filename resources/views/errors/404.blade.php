@extends('layouts.app')

@push('styles')
<style>
    :root {
        --main-color: #2c3e50;
        --accent-color: #e67e22;
        --hover-color: #d35400;
        --light-bg: #f8f9fa;
    }

    .error-container {
        background: linear-gradient(120deg, #fff 70%, var(--light-bg) 100%);
        border: 1px solid #ececec;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-top: 100px;
    }
    .error-container h1 {
        font-size: 4rem;
        font-weight: bold;
        color: var(--main-color);
    }
    .error-container p {
        font-size: 1.25rem;
        color: #555;
    }
    .error-container a.btn {
        font-size: 1.1rem;
        padding: 10px 30px;
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    .error-container a.btn:hover {
        background-color: var(--hover-color);
        transform: scale(1.05);
    }
</style>
@endpush

@section('title', 'Page not found')

@section('content')
<div class="container">
    <div class="error-container text-center">
        <h1>404</h1>
        <p>The page you are looking for could not be found.</p>
        <a href="{{ route('main') }}" class="btn btn-primary">Back to homepage</a>
    </div>
</div>
@endsection