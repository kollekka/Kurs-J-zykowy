@extends('layouts.admin')

@section('title', 'Edit Payment ID: ' . $payment->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-money-check-alt mr-2"></i>Edit Payment ID: {{ $payment->id }}</h4>
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

                <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="enrollment_id">Enrollment ID</label>
                        <input type="number" class="form-control form-control-admin" id="enrollment_id" name="enrollment_id" value="{{ old('enrollment_id', $payment->enrollment_id) }}" required>
                        @if($payment->enrollment)
                            <small class="form-text text-muted">Related course: {{ $payment->enrollment->course->name ?? 'N/A' }}</small>
                            <small class="form-text text-muted">User: {{ $payment->enrollment->user->name ?? 'N/A' }} ({{ $payment->enrollment->user->email ?? '' }})</small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control form-control-admin" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" class="form-control form-control-admin" id="payment_date" name="payment_date" value="{{ old('payment_date', $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control form-control-admin" id="payment_method" name="payment_method" required>
                            <option value="" disabled>Select method</option>
                            <option value="card" {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="paypal" {{ old('payment_method', $payment->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Payment Status</label>
                        <select class="form-control form-control-admin" id="status" name="status" required>
                            <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-warning"><i class="fas fa-save mr-1"></i> Update Payment</button>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
