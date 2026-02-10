@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <p style="font-size:20px; font-weight:bold;">Create Student</p>
            <form action="{{ route('students.store') }}" method="POST">
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
                    <label for="joining_date">Joining date</label>
                    <input type="date" class="form-control" value="{{ old('joining_date') }}" name="joining_date">
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
