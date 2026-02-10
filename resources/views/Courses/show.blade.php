@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Course details</p>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" value="{{$course->name}}" readonly>
        </div>

        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" value="{{$course->code}}" readonly>
        </div>

        <div class="form-group">
            <label for="credits">Credits</label>
            <input type="number" class="form-control" value="{{$course->credits}}" readonly>
        </div>


        <a href="{{route('courses.index')}}" class="btn btn-primary">Back</a>
    </div>
</div>
@endsection
