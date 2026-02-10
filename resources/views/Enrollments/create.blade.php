@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <p style="font-size:20px; font-weight:bold;">Create Enrollment</p>
            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="student_id">Student</label>
                    <select name="student_id" class="form-control">
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                        @error("student_id")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="course_id">Course</label>
                    <select name="course_id" class="form-control">
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error("course_id")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-xs py-0 mx-1 my-2">Enroll</button>
                <a href="{{ route('enrollments.index') }}" class="btn btn-secondary btn-xs py-0 mx-1 my-2">Back</a>
            </form>
        </div>
    </div>
@endsection
