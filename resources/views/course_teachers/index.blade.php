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
                                <h5 class="section-title mb-1">Courses & Assigned Teachers</h5>
                                <p class="section-subtitle mb-0">Manage teacher assignments for each course</p>
                            </div>
                            <a href="{{ route('course_teachers.create', ['page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                class="btn btn-primary btn-create">
                                <i class="bi bi-plus-circle me-1"></i>
                                <span class="d-none d-sm-inline">Assign Teachers</span>
                                <span class="d-inline d-sm-none">Add</span>
                            </a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('course_teachers.index') }}" method="GET" class="search-section mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-8 col-lg-9">
                                <div class="search-input-wrapper">
                                    <i class="bi bi-search search-icon"></i>
                                    <input type="text" name="search" class="form-control search-input-field"
                                        placeholder="Search by course name or teacher name"
                                        value="{{ request()->get('search') }}">
                                    @if (request()->get('search'))
                                        <a href="{{ route('course_teachers.index') }}" class="clear-search"
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
                                    <th>Course</th>
                                    <th>Teachers</th>
                                    <th style="width: 200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $key => $course)
                                    <tr>
                                        <td>{{ $courses->firstItem() + $key }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td>
                                            @forelse ($course->teachers as $teacher)
                                                <span class="badge bg-info text-dark me-1">{{ $teacher->name }}</span>
                                            @empty
                                                <span class="text-muted">No teachers assigned</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-3" role="group">
                                                <a href="{{ route('course_teachers.show', ['id' => $course->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('course_teachers.edit', ['id' => $course->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('course_teachers.destroy', $course->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to remove all teachers from this course?');">
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
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                            <p class="mt-2">No courses found</p>
                                            @if (request()->get('search'))
                                                <a href="{{ route('course_teachers.index') }}"
                                                    class="btn btn-sm btn-primary">
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

    <!-- Create/Assign Teachers Modal -->
    <div class="modal fade" id="createCourseTeacherModal" tabindex="-1" aria-labelledby="createCourseTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourseTeacherModalLabel">Assign Teachers to Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('course_teachers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                    <input type="hidden" name="search" value="{{ request()->get('search') }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="create_course_id">Course</label>
                            <select name="course_id" id="create_course_id"
                                class="form-control select2 @error('course_id') is-invalid @enderror" required>
                                <option value="">Select Course</option>
                                @if (isset($allCourses))
                                    @foreach ($allCourses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }} ({{ $course->code }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('course_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_teacher_ids">Teachers</label>
                            <select name="teacher_ids[]" id="create_teacher_ids"
                                class="form-control select2 @error('teacher_ids') is-invalid @enderror" multiple required>
                                @if (isset($allTeachers))
                                    @foreach ($allTeachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ collect(old('teacher_ids', []))->contains($teacher->id) ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('teacher_ids')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Course Teachers Modal -->
    <div class="modal fade" id="editCourseTeacherModal" tabindex="-1" aria-labelledby="editCourseTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseTeacherModalLabel">Edit Teachers for Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($editCourse))
                    <form action="{{ route('course_teachers.update', $editCourse->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                        <input type="hidden" name="search" value="{{ request()->get('search') }}">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_course_name">Course</label>
                                <input type="text" class="form-control" value="{{ $editCourse->name }}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_teacher_ids">Teachers</label>
                                <select name="teacher_ids[]" id="edit_teacher_ids"
                                    class="form-control select2 @error('teacher_ids') is-invalid @enderror" multiple>
                                    @if (isset($allTeachers))
                                        @foreach ($allTeachers as $teacher)
                                            <option value="{{ $teacher->id }}"
                                                {{ $editCourse->teachers->contains($teacher->id) ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('teacher_ids')
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

    <!-- Show Course Teachers Modal -->
    <div class="modal fade" id="showCourseTeacherModal" tabindex="-1" aria-labelledby="showCourseTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showCourseTeacherModalLabel">Course Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($showCourse))
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Course:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showCourse->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Course Code:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showCourse->code }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Assigned Teachers:</label>
                            <div class="col-sm-8">
                                @forelse($showCourse->teachers as $teacher)
                                    <span class="badge bg-info text-dark me-1 mb-1">{{ $teacher->name }}</span>
                                @empty
                                    <p class="form-control-plaintext text-muted">No teachers assigned yet.</p>
                                @endforelse
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
                var createModal = new bootstrap.Modal(document.getElementById('createCourseTeacherModal'));
                createModal.show();

                // Initialize Select2 for create modal
                $('#create_course_id').select2({
                    dropdownParent: $('#createCourseTeacherModal'),
                    placeholder: 'Select a course',
                    allowClear: true
                });
                $('#create_teacher_ids').select2({
                    dropdownParent: $('#createCourseTeacherModal'),
                    placeholder: 'Select teachers',
                    allowClear: true
                });
            });
        </script>
    @endif

    @if (isset($editCourse))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = new bootstrap.Modal(document.getElementById('editCourseTeacherModal'));
                editModal.show();

                // Initialize Select2 for edit modal
                $('#edit_teacher_ids').select2({
                    dropdownParent: $('#editCourseTeacherModal'),
                    placeholder: 'Select teachers',
                    allowClear: true
                });
            });
        </script>
    @endif

    @if (isset($showCourse))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var showModal = new bootstrap.Modal(document.getElementById('showCourseTeacherModal'));
                showModal.show();
            });
        </script>
    @endif

    <script>
        // Redirect to index when any modal is hidden, preserving pagination and search
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var currentPath = window.location.pathname;
                var indexPath = '{{ route('course_teachers.index') }}';

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
