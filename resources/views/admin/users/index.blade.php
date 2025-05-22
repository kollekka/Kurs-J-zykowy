@extends('layouts.admin') {{-- Zakładając, że layout admina to layouts.admin --}}

@section('title', 'Zarządzanie Użytkownikami')

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0"><i class="fas fa-users mr-2"></i>Zarządzanie Użytkownikami</h1>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Dodaj Użytkownika
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
                    <th>Nazwa</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_admin ? 'Tak' : 'Nie' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edytuj</a>
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Brak użytkowników.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($users->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection