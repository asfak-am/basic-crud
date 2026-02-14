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
                                <h5 class="section-title mb-1">Teacher List</h5>
                                <p class="section-subtitle mb-0">Manage all teachers</p>
                            </div>
                            <a href="{{ route('teachers.create', ['page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                class="btn btn-primary btn-create">
                                <i class="bi bi-plus-circle me-1"></i>
                                <span class="d-none d-sm-inline">Create Teacher</span>
                                <span class="d-inline d-sm-none">Add</span>
                            </a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('teachers.index') }}" method="GET" class="search-section mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-8 col-lg-9">
                                <div class="search-input-wrapper">
                                    <i class="bi bi-search search-icon"></i>
                                    <input type="text" name="search" class="form-control search-input-field"
                                        placeholder="Search by name, email or department"
                                        value="{{ request()->get('search') }}">
                                    @if (request()->get('search'))
                                        <a href="{{ route('teachers.index') }}" class="clear-search" title="Clear search">
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
                                    <th>Department</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $key => $teacher)
                                    <tr>
                                        <td>{{ $teachers->firstItem() + $key }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>{{ $teacher->department }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-3" role="group">
                                                <a href="{{ route('teachers.show', ['id' => $teacher->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('teachers.edit', ['id' => $teacher->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ request()->get('page', 1) }}">
                                                    <input type="hidden" name="search"
                                                        value="{{ request()->get('search') }}">
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
                                            <p class="mt-2">No teachers found</p>
                                            @if (request()->get('search'))
                                                <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-primary">
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
    @if ($teachers->hasPages())
        <nav aria-label="Page navigation">
            {{ $teachers->links('pagination::bootstrap-5') }}
        </nav>
    @endif

    <!-- Create Teacher Modal -->
    <div class="modal fade" id="createTeacherModal" tabindex="-1" aria-labelledby="createTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTeacherModalLabel">Create Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('teachers.store') }}" method="POST">
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
                            <label for="create_department">Department</label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror"
                                value="{{ old('department') }}" name="department" id="create_department" required>
                            @error('department')
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

    <!-- Edit Teacher Modal -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeacherModalLabel">Edit Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($editTeacher))
                    <form action="{{ route('teachers.update', $editTeacher->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                        <input type="hidden" name="search" value="{{ request()->get('search') }}">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="edit_name" value="{{ old('name', $editTeacher->name) }}"
                                    required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="edit_email" value="{{ old('email', $editTeacher->email) }}"
                                    required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_phone">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" id="edit_phone" value="{{ old('phone', $editTeacher->phone) }}"
                                    required>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_department">Department</label>
                                <input type="text" class="form-control @error('department') is-invalid @enderror"
                                    name="department" id="edit_department"
                                    value="{{ old('department', $editTeacher->department) }}" required>
                                @error('department')
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

    <!-- Show Teacher Modal -->
    <div class="modal fade" id="showTeacherModal" tabindex="-1" aria-labelledby="showTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showTeacherModalLabel">Teacher Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($showTeacher))
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showTeacher->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Email:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showTeacher->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Phone:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showTeacher->phone }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Department:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showTeacher->department }}</p>
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
                var createModal = new bootstrap.Modal(document.getElementById('createTeacherModal'));
                createModal.show();
            });
        </script>
    @endif

    @if (isset($editTeacher))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = new bootstrap.Modal(document.getElementById('editTeacherModal'));
                editModal.show();
            });
        </script>
    @endif

    @if (isset($showTeacher))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var showModal = new bootstrap.Modal(document.getElementById('showTeacherModal'));
                showModal.show();
            });
        </script>
    @endif

    <script>
        // Redirect to index when any modal is hidden, preserving pagination and search
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var currentPath = window.location.pathname;
                var indexPath = '{{ route('teachers.index') }}';

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
