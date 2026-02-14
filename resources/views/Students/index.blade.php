@extends('layouts.app')
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body">
                   <!-- Header with Title and Create Button -->
<div class="section-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="section-title mb-1">Student List</h5>
            <p class="section-subtitle mb-0">Manage all students</p>
        </div>
        <a href="{{ route('students.create', ['page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
            class="btn btn-primary btn-create">
            <i class="bi bi-plus-circle me-1"></i>
            <span class="d-none d-sm-inline">Create Student</span>
            <span class="d-inline d-sm-none">Add</span>
        </a>
    </div>
</div>

<!-- Search Form -->
<form action="{{ route('students.index') }}" method="GET" class="search-section mb-4">
    <div class="row g-2 align-items-center">
        <div class="col-md-8 col-lg-9">
            <div class="search-input-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input type="text"
                       name="search"
                       class="form-control search-input-field"
                       placeholder="Search by name, email or phone"
                       value="{{ request()->get('search') }}">
                @if (request()->get('search'))
                    <a href="{{ route('students.index') }}"
                       class="clear-search"
                       title="Clear search">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <button class="btn btn-search w-100" type="submit">
                <i class="bi bi-search me-1"></i>
                <span>Search</span>
            </button>
        </div>
    </div>
</form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joining Date</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $key => $student)
                                    <tr>
                                        <td>{{ $students->firstItem() + $key }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($student->joining_date)->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-3" role="group">
                                                <a href="{{ route('students.show', ['id' => $student->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('students.edit', ['id' => $student->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('students.destroy', $student->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                                                    <input type="hidden" name="search" value="{{ request()->get('search') }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                            <p class="mt-2">No students found</p>
                                            @if(request()->get('search'))
                                                <a href="{{ route('students.index') }}" class="btn btn-sm btn-primary">
                                                    Clear Search
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
        <nav aria-label="Page navigation">
            {{ $students->links('pagination::bootstrap-5') }}
        </nav>
    @endif

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
                                value="{{ old('name') }}" name="name" id="create_name" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" name="email" id="create_email" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_phone">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" name="phone" id="create_phone" required>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
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
                                    name="name" id="edit_name" value="{{ old('name', $editStudent->name) }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="edit_email" value="{{ old('email', $editStudent->email) }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_phone">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" id="edit_phone" value="{{ old('phone', $editStudent->phone) }}" required>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showStudent->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Email:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showStudent->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Phone:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showStudent->phone }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Joining Date:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($showStudent->joining_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        // Redirect to index when any modal is hidden, preserving pagination and search
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var currentPath = window.location.pathname;
                var indexPath = '{{ route('students.index') }}';

                if (currentPath !== indexPath) {
                    var urlParams = new URLSearchParams(window.location.search);
                    var page = urlParams.get('page') || '{{ request()->get('page', 1) }}';
                    var search = urlParams.get('search') || '{{ request()->get('search') }}';

                    var redirectUrl = indexPath + '?page=' + page;
                    if (search) {
                        redirectUrl += '&search=' + encodeURIComponent(search);
                    }

                    window.location.href = redirectUrl;
                }
            });
        });
    </script>
@endsection
