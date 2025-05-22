@extends('layouts.admin')

@section('title', 'Zarządzanie Kursami')

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0"><i class="fas fa-book-open mr-2"></i>Zarządzanie Kursami</h1>
        <div>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-admin-primary btn-sm">
                <i class="fas fa-plus"></i> Dodaj Kurs
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
                <tr><th>ID</th><th>Nazwa</th><th>Język</th><th>Poziom</th><th>Instruktor</th><th>Akcje</th></tr>
            </thead>
            <tbody>
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->language }}</td>
                    <td>{{ $course->level }}</td>
                    <td>{{ $course->instructor->full_name ?? 'Brak' }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.lessons.index', ['course_id' => $course->id]) }}" class="btn btn-admin-info btn-sm" title="Zarządzaj lekcjami"><i class="fas fa-list-ul"></i> Lekcje</a>
                        <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edytuj</a>
                        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten kurs? Usunięcie kursu usunie również wszystkie powiązane z nim lekcje i zapisy.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Brak kursów.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        @if ($courses->hasPages())
            <div class="d-flex justify-content-center mt-3">
                 {{ $courses->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection