@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <p style="font-size:20px; font-weight:bold;">Create Course</p>
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name">
                </div>

                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" value="{{ old('code') }}" name="code">
                </div>

                <div class="form-group">
                    <label for="credits">Credits</label>
                    <input type="number" class="form-control" value="{{ old('credits') }}" name="credits">
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
