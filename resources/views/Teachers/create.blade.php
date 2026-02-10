@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <p style="font-size:20px; font-weight:bold;">Create Teacher</p>
            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email">
                </div>

                <div class="form-group">
                    <label for="email">Phone</label>
                    <input type="text" class="form-control" value="{{ old('phone') }}" name="phone">
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" value="{{ old('department') }}" name="department">
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
