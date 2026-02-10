@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h3>Assign Teachers to Course</h3>

        <form action="{{ route('course_teachers.store') }}" method="POST">
            @csrf

            {{-- Select Course --}}
            <div class="form-group mb-3">
                <label for="course_id">Course</label>
                <select name="course_id" id="course_id" class="form-control select2-single">
                    <option value="">Select Course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Select Teachers --}}
            <div class="form-group mb-3">
                <label for="teacher_ids">Teachers</label>
                <select name="teacher_ids[]" id="teacher_ids" class="form-control select2" multiple>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ collect(old('teacher_ids', []))->contains($teacher->id) ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_ids')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Assign</button>
            <a href="{{ route('course_teachers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Select teachers',
        width: '100%'
    });
    $('.select2-single').select2({
        placeholder: 'Select a course',
        width: '100%'
    });
});
</script>
@endpush
