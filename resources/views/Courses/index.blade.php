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
                    <strong>Course List</strong>
                     <a href="{{ route('courses.create') }}" class="btn btn-primary btn-xs float-end py-0">
                        Create Course
                    </a>
                    <table class="table table-responsive table-bordered table-stripped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Credits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $key => $course)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->credits }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('courses.show', $course->id) }}"
                                                class="btn btn-primary btn-xs py-0 mx-1">Show</a>
                                            <a href="{{ route('courses.edit', $course->id) }}"
                                                class="btn btn-warning btn-xs py-0 mx-1">Edit</a>
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
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
        {{$courses->links("pagination::bootstrap-5")}}
    </nav>
@endsection
