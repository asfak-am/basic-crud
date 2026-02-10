@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <p style="font-size:20px; font-weight:bold;">Teacher details</p>
            <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ $teacher->name }}" name="name">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" value="{{ $teacher->email }}" name="email">
                </div>

                <div class="form-group">
                    <label for="email">Phone</label>
                    <input type="text" class="form-control" value="{{ $teacher->phone }}" name="phone">
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" value="{{ $teacher->department }}" name="department">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
