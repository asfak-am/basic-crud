@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Teacher details</p>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" value="{{$teacher->name}}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" value="{{$teacher->email}}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Phone</label>
            <input type="text" class="form-control" value="{{$teacher->phone}}" readonly>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" value="{{$teacher->department}}" readonly>
        </div>

        <a href="{{route('teachers.index')}}" class="btn btn-primary">Back</a>
    </div>
</div>
@endsection
