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
                                <h5 class="section-title mb-1">Course List</h5>
                                <p class="section-subtitle mb-0">Manage all courses</p>
                            </div>
                            <a href="{{ route('courses.create', ['page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                class="btn btn-primary btn-create">
                                <i class="bi bi-plus-circle me-1"></i>
                                <span class="d-none d-sm-inline">Create Course</span>
                                <span class="d-inline d-sm-none">Add</span>
                            </a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('courses.index') }}" method="GET" class="search-section mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-8 col-lg-9">
                                <div class="search-input-wrapper">
                                    <i class="bi bi-search search-icon"></i>
                                    <input type="text" name="search" class="form-control search-input-field"
                                        placeholder="Search by name or code" value="{{ request()->get('search') }}">
                                    @if (request()->get('search'))
                                        <a href="{{ route('courses.index') }}" class="clear-search" title="Clear search">
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
                                    <th>Code</th>
                                    <th>Credits</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $key => $course)
                                    <tr>
                                        <td>{{ $courses->firstItem() + $key }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->code }}</td>
                                        <td>{{ $course->credits }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-3" role="group">
                                                <a href="{{ route('courses.show', ['id' => $course->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('courses.edit', ['id' => $course->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this course?');">
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
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                            <p class="mt-2">No courses found</p>
                                            @if (request()->get('search'))
                                                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary">
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
    @if ($courses->hasPages())
        <nav aria-label="Page navigation">
            {{ $courses->links('pagination::bootstrap-5') }}
        </nav>
    @endif

    <!-- Create Course Modal -->
    <div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourseModalLabel">Create Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('courses.store') }}" method="POST">
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
                            <label for="create_code">Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}" name="code" id="create_code" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_credits">Credits</label>
                            <input type="number" class="form-control @error('credits') is-invalid @enderror"
                                value="{{ old('credits') }}" name="credits" id="create_credits" required>
                            @error('credits')
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

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($editCourse))
                    <form action="{{ route('courses.update', $editCourse->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                        <input type="hidden" name="search" value="{{ request()->get('search') }}">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="edit_name" value="{{ old('name', $editCourse->name) }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_code">Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    name="code" id="edit_code" value="{{ old('code', $editCourse->code) }}" required>
                                @error('code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_credits">Credits</label>
                                <input type="number" class="form-control @error('credits') is-invalid @enderror"
                                    name="credits" id="edit_credits" value="{{ old('credits', $editCourse->credits) }}"
                                    required>
                                @error('credits')
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

    <!-- Show Course Modal -->
    <div class="modal fade" id="showCourseModal" tabindex="-1" aria-labelledby="showCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showCourseModalLabel">Course Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($showCourse))
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showCourse->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Code:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showCourse->code }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Credits:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showCourse->credits }}</p>
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
                var createModal = new bootstrap.Modal(document.getElementById('createCourseModal'));
                createModal.show();
            });
        </script>
    @endif

    @if (isset($editCourse))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = new bootstrap.Modal(document.getElementById('editCourseModal'));
                editModal.show();
            });
        </script>
    @endif

    @if (isset($showCourse))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var showModal = new bootstrap.Modal(document.getElementById('showCourseModal'));
                showModal.show();
            });
        </script>
    @endif

    <script>
        // Redirect to index when any modal is hidden, preserving pagination and search
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var currentPath = window.location.pathname;
                var indexPath = '{{ route('courses.index') }}';

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
