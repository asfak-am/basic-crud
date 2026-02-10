@extends('layouts.app')

@section('content')
    <div class="card mb-2">
        <div class="card-body">
            <strong>Courses & Assigned Teachers</strong>
            <a href="{{ route('course_teachers.create') }}" class="btn btn-primary btn-xs float-end py-0">Assign Teachers</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-responsive table-bordered table-stripped" style="margin-top:10px;">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Teachers</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>
                                @foreach ($course->teachers as $teacher)
                                    <span class="badge bg-info">{{ $teacher->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('course_teachers.show', $course->id) }}"
                                    class="btn btn-primary btn-xs py-0 mx-1">Show</a>

                                <a href="{{ route('course_teachers.edit', $course->id) }}"
                                    class="btn btn-warning btn-xs py-0 mx-1">Edit</a>

                                <form action="{{ route('course_teachers.destroy', $course->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to remove all teachers from this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs py-0 mx-1">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        {{$courses->links("pagination::bootstrap-5")}}
    </nav>
@endsection
