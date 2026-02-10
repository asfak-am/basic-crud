@extends('layouts.app')
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body">
                    <strong>Enrollment List</strong>
                    <a href="{{ route('enrollments.create') }}" class="btn btn-primary btn-xs float-end py-0">
                        Create Enrollment
                    </a>
                    <table class="table table-responsive table-bordered table-stripped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrollments as $key => $enrollment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $enrollment->student->name }}</td>
                                    <td>{{ $enrollment->student->id }}</td>
                                    <td>{{ $enrollment->course->name }}</td>
                                    <td>{{ $enrollment->course->code }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('enrollments.show', $enrollment->id) }}"
                                                class="btn btn-primary btn-xs py-0 mx-1">Show</a>
                                            <a href="{{ route('enrollments.edit', $enrollment->id) }}"
                                                class="btn btn-warning btn-xs py-0 mx-1">Edit</a>
                                            <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-xs py-0">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        {{$enrollments->links("pagination::bootstrap-5")}}
    </nav>
@endsection
