@extends('layouts.admin')

@section('title', 'Edytuj Kurs: ' . $course->name)

@section('content')
<div class="row"> {{-- Główny wiersz dla dwóch kolumn --}}
    <div class="col-md-6"> {{-- Kolumna dla formularza edycji kursu --}}
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-book-reader mr-2"></i>Edytuj Kurs: {{ $course->name }}</h4>
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

                <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nazwa Kursu</label>
                        <input type="text" class="form-control form-control-admin" id="name" name="name" value="{{ old('name', $course->name) }}" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="language">Język</label>
                        <input type="text" class="form-control form-control-admin" id="language" name="language" value="{{ old('language', $course->language) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="level">Poziom</label>
                        <select class="form-control form-control-admin" id="level" name="level" required>
                            <option value="" disabled>Wybierz poziom</option>
                            @php
                                $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
                            @endphp
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" {{ old('level', $course->level) == $level ? 'selected' : '' }}>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Opis</label>
                        <textarea maxlength="1000" class="form-control form-control-admin" id="description" name="description" rows="4">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Data rozpoczęcia</label>
                            <input type="date" class="form-control form-control-admin" id="start_date" name="start_date" value="{{ old('start_date', $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') : '') }}" min="{{ now()->toDateString() }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Data zakończenia</label>
                            <input type="date" class="form-control form-control-admin" id="end_date" name="end_date" value="{{ old('end_date', $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') : '') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Cena (PLN)</label>
                            <input type="number" class="form-control form-control-admin" id="price" name="price" value="{{ old('price', $course->price) }}" step="0.01" min="0" max="1000"required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="group_size">Maksymalny rozmiar grupy</label>
                            <input type="number" class="form-control form-control-admin" id="group_size" name="group_size" value="{{ old('group_size', $course->group_size) }}" min="5" max="20" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="instructor_id">Instruktor</label>
                        <select class="form-control form-control-admin" id="instructor_id" name="instructor_id" required>
                            <option value="" disabled>Wybierz instruktora</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>{{ $instructor->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-warning"><i class="fas fa-save mr-1"></i> Zaktualizuj Kurs</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Sekcja Zarządzania Lekcjami --}}
    <div class="col-md-6"> {{-- Kolumna dla sekcji zarządzania lekcjami --}}
        <div class="card card-admin h-100"> {{-- Dodano h-100, aby karty miały taką samą wysokość --}}
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-list-ul mr-2"></i>Lekcje dla kursu: {{ $course->name }}</h4>
                <div>
                    <a href="{{ route('admin.lessons.create', ['course_id' => $course->id]) }}" class="btn btn-admin-primary btn-sm">
                        <i class="fas fa-plus"></i> Dodaj Nową Lekcję
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($course->lessons->isEmpty())
                    <p class="text-center">Brak zdefiniowanych lekcji dla tego kursu.</p>
                @else
                    <table class="table table-hover table-admin">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tytuł</th>
                                <th>Data</th>
                                <th>Godzina</th>
                                <th>Czas trwania</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->lessons()->orderBy('date')->orderBy('time')->get() as $lesson)
                                <tr>
                                    <td>{{ $lesson->id }}</td>
                                    <td>{{ $lesson->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lesson->date)->format('d.m.Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lesson->time)->format('H:i') }}</td>
                                    <td>{{ $lesson->duration }}</td>
                                    <td>
                                        <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-admin-warning btn-sm"><i class="fas fa-edit"></i> Edytuj</a>
                                        <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Czy na pewno chcesz usunąć tę lekcję?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-admin-danger btn-sm"><i class="fas fa-trash"></i> Usuń</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection