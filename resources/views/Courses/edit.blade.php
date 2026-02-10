@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <p style="font-size:20px; font-weight:bold;">Course details</p>
            <form action="{{ route('courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ $course->name }}" name="name">
                </div>

                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" value="{{ $course->code }}" name="code">
                </div>

                <div class="form-group">
                    <label for="credits">Credits</label>
                    <input type="number" class="form-control" value="{{ $course->credits }}" name="credits">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
