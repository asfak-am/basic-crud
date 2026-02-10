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
                    <strong>Teacher List</strong>
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-xs float-end py-0">
                        Create Teacher
                    </a>
                    <table class="table table-responsive table-bordered table-stripped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $key => $teacher)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->department }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('teachers.show', $teacher->id) }}"
                                                class="btn btn-primary btn-xs py-0 mx-1">Show</a>
                                            <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                class="btn btn-warning btn-xs py-0 mx-1">Edit</a>
                                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
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
        {{$teachers->links("pagination::bootstrap-5")}}
    </nav>
@endsection
