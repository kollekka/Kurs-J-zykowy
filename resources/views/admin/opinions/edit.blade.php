@extends('layouts.admin') {{-- Lub layouts.app, jeśli użytkownicy też mają dostęp do tego formularza przez inny layout --}}

@section('title', 'Edytuj Opinię')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-comment-edit mr-2"></i>Edytuj Opinię</h4>
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

                <form action="{{ route('admin.opinions.update', $opinion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="course_name">Kurs:</label>
                        <input type="text" class="form-control form-control-admin" id="course_name" value="{{ $opinion->course->name ?? 'Nie przypisano do kursu' }}" readonly>
                        {{-- Można by tu dodać ukryte pole z course_id, jeśli byłoby potrzebne, ale zazwyczaj nie edytujemy przypisania opinii do kursu --}}
                    </div>

                    <div class="form-group">
                        <label for="user_name">Autor:</label>
                        <input type="text" class="form-control form-control-admin" id="user_name" value="{{ $opinion->user->name ?? 'Anonim' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="rating">Ocena (1-5)</label>
                        <select class="form-control form-control-admin" id="rating" name="rating" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating', $opinion->rating) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="comment">Komentarz</label>
                        <textarea class="form-control form-control-admin" id="comment" name="comment" rows="5" required>{{ old('comment', $opinion->comment) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-admin-warning"><i class="fas fa-save mr-1"></i> Zaktualizuj Opinię</button>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.opinions.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                    @else
                        <a href="{{ route('course.show', $opinion->course_id) }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Anuluj</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection