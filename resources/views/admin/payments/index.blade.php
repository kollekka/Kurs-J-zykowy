@extends('layouts.admin')

@section('title', 'Zarządzanie Płatnościami')

@section('content')


<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0"><i class="fas fa-credit-card mr-2"></i>Zarządzanie Płatnościami</h1>
        <div>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Dodaj Płatność
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
                    <th>Użytkownik</th>
                    <th>Kurs (ID)</th>
                    <th>Kwota</th>
                    <th>Metoda</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->user->name ?? 'Brak' }} ({{ $payment->user->email ?? 'N/A' }})</td>
                        <td>{{ $payment->enrollment->course->name ?? 'N/A' }} (ID: {{ $payment->enrollment_id ?? 'N/A' }})</td>
                        <td>{{ number_format($payment->amount, 2, ',', ' ') }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td><span class="badge badge-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($payment->status) }}</span></td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edytuj</a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę płatność?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Brak zarejestrowanych płatności.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($payments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

