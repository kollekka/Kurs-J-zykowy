<!-- filepath: e:\projekt laravel\Kurs-J-zykowy\resources\views\errors\419.blade.php -->
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

@section('title', 'Strona wygasła')

@section('content')
<div class="container">
    <div class="error-container text-center">
        <h1>419</h1>
        <p>Strona wygasła. Twoja sesja mogła wygasnąć.<br>
           Za 5 sekund nastąpi automatyczne wylogowanie.</p>
    </div>
</div>

<!-- Ukryty formularz wylogowania -->
<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.getElementById('logoutForm').submit();
    }, 5000); 
});
</script>
@endpush