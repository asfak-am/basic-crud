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
                                <h5 class="section-title mb-1">Enrollment List</h5>
                                <p class="section-subtitle mb-0">Manage student course enrollments</p>
                            </div>
                            <a href="{{ route('enrollments.create', ['page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                class="btn btn-primary btn-create">
                                <i class="bi bi-plus-circle me-1"></i>
                                <span class="d-none d-sm-inline">Create Enrollment</span>
                                <span class="d-inline d-sm-none">Add</span>
                            </a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('enrollments.index') }}" method="GET" class="search-section mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-8 col-lg-9">
                                <div class="search-input-wrapper">
                                    <i class="bi bi-search search-icon"></i>
                                    <input type="text" name="search" class="form-control search-input-field"
                                        placeholder="Search by student name or course name"
                                        value="{{ request()->get('search') }}">
                                    @if (request()->get('search'))
                                        <a href="{{ route('enrollments.index') }}" class="clear-search"
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
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Course Name</th>
                                    <th>Course Code</th>
                                    <th style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($enrollments as $key => $enrollment)
                                    <tr>
                                        <td>{{ $enrollments->firstItem() + $key }}</td>
                                        <td>{{ $enrollment->student->name }}</td>
                                        <td>{{ $enrollment->student->id }}</td>
                                        <td>{{ $enrollment->course->name }}</td>
                                        <td>{{ $enrollment->course->code }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-3" role="group">
                                                <a href="{{ route('enrollments.show', ['id' => $enrollment->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('enrollments.edit', ['id' => $enrollment->id, 'page' => request()->get('page', 1), 'search' => request()->get('search')]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('enrollments.destroy', $enrollment->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this enrollment?');">
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
                                            <p class="mt-2">No enrollments found</p>
                                            @if (request()->get('search'))
                                                <a href="{{ route('enrollments.index') }}" class="btn btn-sm btn-primary">
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
    @if ($enrollments->hasPages())
        <nav aria-label="Page navigation">
            {{ $enrollments->links('pagination::bootstrap-5') }}
        </nav>
    @endif

    <!-- Create Enrollment Modal -->
    <div class="modal fade" id="createEnrollmentModal" tabindex="-1" aria-labelledby="createEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEnrollmentModalLabel">Create Enrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('enrollments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                    <input type="hidden" name="search" value="{{ request()->get('search') }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="create_student_id">Student</label>
                            <select name="student_id" id="create_student_id"
                                class="form-control select2 @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                                @if (isset($students))
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('student_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="create_course_id">Course</label>
                            <select name="course_id" id="create_course_id"
                                class="form-control select2 @error('course_id') is-invalid @enderror" required>
                                <option value="">Select Course</option>
                                @if (isset($courses))
                                    @foreach ($courses as $course)
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Enroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Enrollment Modal -->
    <div class="modal fade" id="editEnrollmentModal" tabindex="-1" aria-labelledby="editEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEnrollmentModalLabel">Edit Enrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($editEnrollment))
                    <form action="{{ route('enrollments.update', $editEnrollment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                        <input type="hidden" name="search" value="{{ request()->get('search') }}">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_student_id">Student</label>
                                <select name="student_id" id="edit_student_id"
                                    class="form-control select2 @error('student_id') is-invalid @enderror" required>
                                    <option value="">Select Student</option>
                                    @if (isset($students))
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}"
                                                {{ old('student_id', $editEnrollment->student_id) == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('student_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="edit_course_id">Course</label>
                                <select name="course_id" id="edit_course_id"
                                    class="form-control select2 @error('course_id') is-invalid @enderror" required>
                                    <option value="">Select Course</option>
                                    @if (isset($courses))
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ old('course_id', $editEnrollment->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }} ({{ $course->code }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('course_id')
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

    <!-- Show Enrollment Modal -->
    <div class="modal fade" id="showEnrollmentModal" tabindex="-1" aria-labelledby="showEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showEnrollmentModalLabel">Enrollment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if (isset($showEnrollment))
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Student Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showEnrollment->student->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Student ID:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showEnrollment->student->id }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Course Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showEnrollment->course->name }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label fw-bold">Course Code:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext">{{ $showEnrollment->course->code }}</p>
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
                var createModal = new bootstrap.Modal(document.getElementById('createEnrollmentModal'));
                createModal.show();

                // Initialize Select2 for create modal
                $('#create_student_id').select2({
                    dropdownParent: $('#createEnrollmentModal'),
                    placeholder: 'Select Student',
                    allowClear: true
                });
                $('#create_course_id').select2({
                    dropdownParent: $('#createEnrollmentModal'),
                    placeholder: 'Select Course',
                    allowClear: true
                });
            });
        </script>
    @endif

    @if (isset($editEnrollment))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = new bootstrap.Modal(document.getElementById('editEnrollmentModal'));
                editModal.show();

                // Initialize Select2 for edit modal
                $('#edit_student_id').select2({
                    dropdownParent: $('#editEnrollmentModal'),
                    placeholder: 'Select Student',
                    allowClear: true
                });
                $('#edit_course_id').select2({
                    dropdownParent: $('#editEnrollmentModal'),
                    placeholder: 'Select Course',
                    allowClear: true
                });
            });
        </script>
    @endif

    @if (isset($showEnrollment))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var showModal = new bootstrap.Modal(document.getElementById('showEnrollmentModal'));
                showModal.show();
            });
        </script>
    @endif

    <script>
        // Redirect to index when any modal is hidden, preserving pagination and search
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                var currentPath = window.location.pathname;
                var indexPath = '{{ route('enrollments.index') }}';

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
