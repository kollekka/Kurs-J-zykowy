@extends('layouts.admin')

@section('title', 'Dodaj Nową Płatność')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Dodaj Nową Płatność (ręcznie)</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Wystąpiły błędy:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="enrollment_id">ID Zapisu</label>
                        <input type="number" class="form-control form-control-admin" id="enrollment_id" name="enrollment_id" value="{{ old('enrollment_id') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Kwota</label>
                        <input type="number" class="form-control form-control-admin" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Data Płatności</label>
                        <input type="date" class="form-control form-control-admin" id="payment_date" name="payment_date" value="{{ old('payment_date') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Metoda Płatności</label>
                        <select class="form-control form-control-admin" id="payment_method" name="payment_method" required>
                            <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>Wybierz metodę</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Karta</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Przelew bankowy</option>
                            <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Gotówka</option>
                            {{-- Dodaj inne metody, jeśli są potrzebne --}}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status Płatności</label>
                        <select class="form-control form-control-admin" id="status" name="status" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Oczekująca</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Zakończona</option>
                            <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Nieudana</option>
                            <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Zwrócona</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-save mr-1"></i> Dodaj Płatność</button>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection