@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Course: {{ $course->name }}</h4>

        <p><strong>Assigned Teachers:</strong></p>
        <ul>
            @forelse($course->teachers as $teacher)
                <li>{{ $teacher->name }}</li>
            @empty
                <li>No teachers assigned yet.</li>
            @endforelse
        </ul>

        <a href="{{ route('course_teachers.index') }}" class="btn btn-secondary btn-xs py-0 mx-1">Back</a>
    </div>
</div>
@endsection
