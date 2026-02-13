@extends('layouts.app')
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">

                <div class="card-body">
                    <strong>Student List</strong>
                    <a href="{{ route('students.create', ['page' => request()->get('page', 1)]) }}"
                        class="btn btn-primary btn-xs float-end py-0">
                        Create Student
                    </a>
                    <table class="table table-responsive table-bordered table-stripped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joining Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $student)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->joining_date }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('students.show', ['id' => $student->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                class="btn btn-primary btn-xs py-0 mx-1">
                                                Show
                                            </a>
                                            <a href="{{ route('students.edit', ['id' => $student->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                class="btn btn-warning btn-xs py-0 mx-1">
                                                Edit
                                            </a>
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="page"
                                                    value="{{ request()->get('page', 1) }}">
                                                <input type="hidden" name="search"
                                                    value="{{ request()->get('search') }}">
                                                <button type="submit" class="btn btn-danger btn-xs py-0">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example">
        {{ $students->links('pagination::bootstrap-5') }}
    </nav>

    <!-- Create Student Modal -->
    <div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStudentModalLabel">Create Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                    <input type="hidden" name="search" value="{{ request()->get('search') }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="create_name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" name="name" id="create_name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" name="email" id="create_email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_phone">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" name="phone" id="create_phone">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_joining_date">Joining date</label>
                            <input type="date" class="form-control @error('joining_date') is-invalid @enderror"
                                value="{{ old('joining_date') }}" name="joining_date" id="create_joining_date"
                                max="{{ date('Y-m-d') }}" required>
                            @error('joining_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($editStudent))
                    <form action="{{ route('students.update', $editStudent->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                        <input type="hidden" name="search" value="{{ request()->get('search') }}">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="edit_name" value="{{ old('name', $editStudent->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="edit_email" value="{{ old('email', $editStudent->email) }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_phone">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" id="edit_phone" value="{{ old('phone', $editStudent->phone) }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="edit_joining_date">Joining date</label>
                                <input type="date" class="form-control @error('joining_date') is-invalid @enderror"
                                    name="joining_date" id="edit_joining_date"
                                    value="{{ old('joining_date', $editStudent->joining_date) }}"
                                    max="{{ date('Y-m-d') }}" required>
                                @error('joining_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Show Student Modal -->
    <div class="modal fade" id="showStudentModal" tabindex="-1" aria-labelledby="showStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showStudentModalLabel">Student Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($showStudent))
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="show_name">Name</label>
                            <input type="text" class="form-control" id="show_name" value="{{ $showStudent->name }}"
                                readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="show_email">Email</label>
                            <input type="email" class="form-control" id="show_email"
                                value="{{ $showStudent->email }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="show_phone">Phone</label>
                            <input type="text" class="form-control" id="show_phone"
                                value="{{ $showStudent->phone }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="show_joining_date">Joining date</label>
                            <input type="date" class="form-control" id="show_joining_date"
                                value="{{ $showStudent->joining_date }}" readonly>
                        </div>
                    </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if (isset($showCreateModal) && $showCreateModal)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var createModal = new bootstrap.Modal(document.getElementById('createStudentModal'));
                createModal.show();
            });
        </script>
    @endif

    @if (isset($editStudent))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
                editModal.show();
            });
        </script>
    @endif

    @if (isset($showStudent))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var showModal = new bootstrap.Modal(document.getElementById('showStudentModal'));
                showModal.show();
            });
        </script>
    @endif

    <script>
        // Redirect to index when any modal is hidden, preserving pagination
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var currentPath = window.location.pathname;
                var indexPath = '{{ route('students.index') }}';

                // Check if we're not already on the index page
                if (currentPath !== indexPath) {
                    // Get the page from URL
                    var urlParams = new URLSearchParams(window.location.search);
                    var page = urlParams.get('page') || '{{ request()->get('page', 1) }}';

                    // Redirect to index with page parameter
                    window.location.href = indexPath + '?page=' + page;
                }
            });
        });
    </script>
@endsection
