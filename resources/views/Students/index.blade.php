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
                    <strong>Student List</strong>
                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-xs float-end py-0">
                        Create Student
                    </a>
                    <table class="table table-responsive table-bordered table-stripped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joining Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $student)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->joining_date }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('students.show', $student->id) }}"
                                                class="btn btn-primary btn-xs py-0 mx-1">Show</a>
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-warning btn-xs py-0 mx-1">Edit</a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST">
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
        {{$students->links("pagination::bootstrap-5")}}
    </nav>
@endsection
