@extends('layouts.admin')

@section('title', 'Zarządzanie Opiniami')

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0"><i class="fas fa-comments mr-2"></i>Zarządzanie Opiniami</h1>
        <div>
            <a href="{{ route('admin.opinions.createForAdmin') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Dodaj Nową Opinię 
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
                <tr><th>ID</th><th>Użytkownik</th><th>Kurs</th><th>Ocena</th><th>Komentarz</th><th>Akcje</th></tr>
            </thead>
            <tbody>
            @forelse ($opinions as $opinion)
                <tr>
                    <td>{{ $opinion->id }}</td>
                    <td>{{ $opinion->user->name ?? 'Brak' }}</td>
                    <td>{{ $opinion->course->name ?? 'Brak' }}</td>
                    <td>{{ $opinion->rating }}/5</td>
                    <td>{{ Str::limit($opinion->opinion, 50) }}</td>
                    <td class="action-buttons">
                        @if($opinion->course)
                        <a href="{{ route('course.show', $opinion->course_id) }}" class="btn btn-admin-info btn-sm" target="_blank" title="Zobacz kurs"><i class="fas fa-eye"></i></a>
                        @endif
                        <a href="{{ route('admin.opinions.edit', $opinion->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edytuj</a>
                        <form action="{{ route('admin.opinions.destroy', $opinion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę opinię?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Brak opinii.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($opinions->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $opinions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection