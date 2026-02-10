@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <p style="font-size:20px; font-weight:bold;">Student details</p>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" value="{{$student->name}}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" value="{{$student->email}}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Phone</label>
            <input type="text" class="form-control" value="{{$student->phone}}" readonly>
        </div>

        <div class="form-group">
            <label for="joining_date">Joining date</label>
            <input type="date" class="form-control" value="{{$student->joining_date}}" readonly>
        </div>

        <a href="{{route('students.index')}}" class="btn btn-primary">Back</a>
    </div>
</div>
@endsection
