@extends('layouts.app')

@section('title', 'Enroll in ' . $course->name)

@push('styles')
<style>
    :root {
        --main-color: #2c3e50;
        --accent-color: #e67e22;
        --hover-color: #d35400;
        --light-bg: #f8f9fa;
        --success-color: #2ecc71;
        --success-hover-color: #27ae60;
    }

    body {
        background-color: var(--light-bg);
        min-height: 100vh;
    }

    .enroll-card {
        max-width: 600px;
        margin: 2rem auto;
        border: none;
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        background: #fff;
    }

    .card-header-enroll {
        background: linear-gradient(45deg, var(--main-color), var(--accent-color));
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
        text-align: center;
    }
    .card-header-enroll h1 {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    .card-header-enroll .course-name-enroll {
        font-size: 1.3rem;
        font-weight: 600;
    }

    .price-info {
        background-color: var(--light-bg);
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        text-align: center;
        border: 1px solid #e0e0e0;
    }
    .price-info .original-price {
        text-decoration: line-through;
        color: #7f8c8d;
        font-size: 1rem;
        margin-right: 10px;
    }
    .price-info .final-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--accent-color);
    }
    .price-info .discount-notice {
        font-size: 0.9rem;
        color: var(--success-color);
        display: block;
        margin-top: 0.25rem;
    }

    .form-control-enroll {
        border-radius: 25px;
        border: 1px solid rgba(0,0,0,0.1);
        padding: 0.75rem 1.25rem;
        transition: all 0.3s ease;
        height: auto; 
    }

    .form-control-enroll:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(230,126,34,0.25);
    }

    .enroll-label {
        font-weight: 600;
        color: var(--main-color);
        margin-bottom: 0.5rem;
    }

    .btn-enroll {
        background-color: var(--success-color);
        border-color: var(--success-color);
        color: white;
        border-radius: 25px;
        padding: 12px 25px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-enroll:hover {
        background-color: var(--success-hover-color);
        border-color: var(--success-hover-color);
        transform: scale(1.05);
    }

    .btn-back-course {
        border-radius: 25px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    .btn-back-course:hover {
        transform: scale(1.05);
    }

</style>
@endpush

@section('content')

<div class="container mt-4">
    <div class="enroll-card">
        <div class="card-header-enroll">
            <h1><i class="fas fa-graduation-cap mr-2"></i>Enrollment</h1>
            <div class="course-name-enroll">{{ $course->name }}</div>
        </div>
        <div class="card-body p-4">
            <div class="price-info mb-4">
                <span class="original-price">Original Price: ${{ number_format($course->price, 2) }}</span>
                <span class="final-price">Final Price: ${{ number_format($finalAmount, 2) }}</span>
                @if ($course->discount > 0)
                    <span class="discount-notice">You save ${{ number_format($course->price - $finalAmount, 2) }}!</span>
                @endif
            <form method="POST" action="{{ route('enrollment.user.store') }}">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="final_amount" value="{{ $finalAmount }}">

                <div class="form-group">
                    <label for="payment_method" class="enroll-label"><i class="fas fa-credit-card mr-2"></i>Payment Method</label>
                    <select class="form-control form-control-enroll" id="payment_method" name="payment_method" style="height: auto;" required>
                        <option value="" disabled selected>Select a payment method...</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-enroll btn-block mt-4">
                    <i class="fas fa-check-circle mr-2"></i>Confirm Enrollment & Pay
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ url('/course/' . $course->id) }}" class="btn btn-outline-secondary btn-back-course">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Course Details
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
