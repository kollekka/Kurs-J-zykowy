@extends('layouts.admin')

@section('title')
    Zarządzanie Lekcjami
    @if(isset($course))
        - {{ $course->name }}
    @endif
@endsection

@section('content')
<div class="card card-admin">
    <div class="card-header">
        <h1 class="page-title mb-0">
            <i class="fas fa-chalkboard-teacher mr-2"></i>
            Zarządzanie Lekcjami
            @if(isset($course))
                <small class="text-muted">- dla kursu: {{ $course->name }}</small>
            @endif
        </h1>
        <div>
            @if(isset($course))
                <a href="{{ route('admin.lessons.create', ['course_id' => $course->id]) }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Dodaj Lekcję do tego Kursu</a>
                <a href="{{ route('admin.lessons.index') }}" class="btn btn-admin-secondary btn-sm"><i class="fas fa-list"></i> Pokaż Wszystkie Lekcje</a>
            @else
                <a href="{{ route('admin.lessons.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Dodaj Nową Lekcję</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Można tu dodać formularz filtrowania np. po kursie, jeśli nie jest już przekazany --}}

        <table class="table table-hover table-admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tytuł Lekcji</th>
                    <th>Kurs</th>
                    <th>Data</th>
                    <th>Godzina</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>
                            @if($lesson->course)
                                <a href="{{ route('admin.courses.edit', $lesson->course_id) }}">{{ $lesson->course->name }}</a>
                            @else
                                Brak kursu
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($lesson->date)->format('d.m.Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($lesson->time)->format('H:i') }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edytuj</a>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę lekcję?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Brak lekcji do wyświetlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($lessons->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $lessons->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection