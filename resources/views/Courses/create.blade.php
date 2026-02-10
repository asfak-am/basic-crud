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
                    @error("name")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" value="{{ old('code') }}" name="code">
                    @error("code")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="credits">Credits</label>
                    <input type="number" class="form-control" value="{{ old('credits') }}" name="credits">
                    @error("credits")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-xs py-0 mx-1 my-2">Create</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-xs py-0 mx-1 my-2">Back</a>
            </form>
        </div>
    </div>
@endsection
