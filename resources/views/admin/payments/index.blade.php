@extends('layouts.admin')

@section('title', 'Manage Payments')

@push('styles')
<style>
    .card-header {
        background: rgb(151, 73, 5) !important;
        color: #fff !important;
    }
    .card-header .page-title {
        color: #fff !important;
    }
</style>
@endpush

@section('content')


<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0"><i class="fas fa-credit-card mr-2"></i>Manage Payments</h1>
        <div>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Add Payment
            </a>
        </div>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-hover table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Course (ID)</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->enrollment->user->name ?? 'None' }} | {{ $payment->enrollment->user->email ?? 'N/A' }}</td>
                        <td>{{ $payment->enrollment->course->name ?? 'N/A' }} (ID: {{ $payment->enrollment_id ?? 'N/A' }})</td>
                        <td>{{ number_format($payment->amount, 2, ',', ' ') }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td><span class="badge badge-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($payment->status) }}</span></td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No registered payments.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($payments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $payments->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection
