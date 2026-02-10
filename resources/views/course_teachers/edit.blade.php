@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Teachers for "{{ $course->name }}"</h4>

        <form action="{{ route('course_teachers.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Course (readonly) --}}
            <div class="form-group mb-3">
                <label for="course_name">Course</label>
                <input type="text" class="form-control" value="{{ $course->name }}" readonly>
            </div>

            {{-- Select Teachers --}}
            <div class="form-group mb-3">
                <label for="teacher_ids">Teachers</label>
                <select name="teacher_ids[]" id="teacher_ids" class="form-control select2" multiple>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ $course->teachers->contains($teacher->id) ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_ids')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-xs py-0 mx-1">Update</button>
            <a href="{{ route('course_teachers.index') }}" class="btn btn-secondary btn-xs py-0 mx-1">Back</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#teacher_ids').select2({
        placeholder: 'Select teachers',
        width: '100%'
    });
});
</script>
@endpush
