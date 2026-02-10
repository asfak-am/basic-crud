@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Enrollment details</p>
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" class="form-control" value="{{$enrollment->student->name}}" readonly>
        </div>

        <div class="form-group">
            <label for="id">Student ID</label>
            <input type="number" class="form-control" value="{{$enrollment->student->id}}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Course Name</label>
            <input type="text" class="form-control" value="{{$enrollment->course->name}}" readonly>
        </div>

        <div class="form-group">
            <label for="joining_date">Course Code</label>
            <input type="text" class="form-control" value="{{$enrollment->course->code}}" readonly>
        </div>

        <a href="{{route('enrollments.index')}}" class="btn btn-primary btn-xs py-0 mx-1 my-2">Back</a>
    </div>
</div>
@endsection
