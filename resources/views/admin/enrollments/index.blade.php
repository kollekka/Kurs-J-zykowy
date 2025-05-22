@extends('layouts.admin')

@section('title', 'Zarządzanie Zapisami')

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0"><i class="fas fa-user-check mr-2"></i>Zarządzanie Zapisami</h1>
        <div>
            <a href="{{ route('admin.enrollments.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Dodaj Nowy Zapis
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
                <tr><th>ID Zapisu</th><th>Użytkownik</th><th>Kurs</th><th>Data Zapisu</th><th>Status</th><th>Akcje</th></tr>
            </thead>
            <tbody>
            @forelse ($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->id }}</td>
                    <td>{{ $enrollment->user->name ?? 'Brak' }} ({{ $enrollment->user->email ?? '' }})</td>
                    <td>{{ $enrollment->course->name ?? 'Brak' }}</td>
                    <td>{{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d.m.Y H:i') : '-' }}</td>
                    <td><span class="badge badge-{{ $enrollment->status == 'active' ? 'success' : ($enrollment->status == 'pending' ? 'warning' : ($enrollment->status == 'completed' ? 'info' : 'secondary')) }}">{{ ucfirst($enrollment->status) }}</span></td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Zmień Status</a>
                        <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten zapis?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń Zapis</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Brak zapisów.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($enrollments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $enrollments->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection