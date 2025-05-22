@extends('layouts.admin')

@section('title', 'Edytuj Status Zapisu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Edytuj Status Zapisu</h4>
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

                <form action="{{ route('admin.enrollments.update', $enrollment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="enrollment_id_display">ID Zapisu:</label>
                        <input type="text" class="form-control form-control-admin" id="enrollment_id_display" value="{{ $enrollment->id }}" readonly>
                        {{-- ID zazwyczaj nie jest edytowalne, ale możemy je wyświetlić --}}
                    </div>

                    <div class="form-group">
                        <label for="user_id">Użytkownik</label>
                        <select class="form-control form-control-admin" id="user_id" name="user_id" required>
                            {{-- Zakładam, że przekażesz $users (wszystkich użytkowników) z kontrolera --}}
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $enrollment->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="course_id">Kurs</label>
                        <select class="form-control form-control-admin" id="course_id" name="course_id" required>
                            {{-- Zakładam, że przekażesz $courses (wszystkie kursy) z kontrolera --}}
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $enrollment->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="enrollment_date">Data Zapisu</label>
                        <input type="datetime-local" class="form-control form-control-admin" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('Y-m-d\TH:i') : '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status Zapisu</label>
                        <select class="form-control form-control-admin" id="status" name="status" required>
                            @php
                                $statuses = ['pending', 'active', 'completed', 'cancelled', 'refunded']; // Przykładowe statusy
                            @endphp
                            @foreach ($statuses as $statusValue)
                                <option value="{{ $statusValue }}" {{ old('status', $enrollment->status) == $statusValue ? 'selected' : '' }}>{{ ucfirst($statusValue) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-admin-warning"><i class="fas fa-save mr-1"></i> Zaktualizuj Zapis</button>
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection