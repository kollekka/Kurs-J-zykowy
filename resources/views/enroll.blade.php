@extends('layouts.app')

@section('title', 'Enroll in ' . $course->name)

@section('content')
<div class="container mt-4">
    <h1>Enroll in {{ $course->name }}</h1>
    <p><strong>Price:</strong> ${{ $course->price }}</p>
    <form method="POST" action="{{ route('enrollment.user.store') }}">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="card">Card</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Confirm Enrollment</button>
    </form>
    <a href="{{ url('/course/' . $course->id) }}" class="btn btn-secondary mt-2">Back to Course</a>
</div>