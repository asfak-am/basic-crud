<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Admin</title>
    <meta name="description" content="Modern admin dashboard built with Bootstrap 5">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f4f6ff;
            font-family: "Inter", sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            width: 260px;
            background: #0b1c39;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar a {
            color: #cfd8ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #1c2e5a;
            color: #fff;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        @media (max-width: 767.98px) {
            .main-content {
                margin-left: 0;
            }
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            background: #f1f3ff;
            border: none;
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #0b1c39;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #1c2e5a;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #2a4070;
        }

         .search-input {
        background: #ffffff;
        border: 1px solid #dee2e6;
        font-size: 14px;
        padding: 10px 15px;
        border-radius: 6px;
    }

    .search-input::placeholder {
        font-size: 13px;
        color: #6c757d;
        font-weight: 400;
    }

    .search-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .btn-group-sm .btn {
        padding: 4px 8px;
        border-radius: 6px !important;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    </style>
</head>

<body>

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="text-dark">Student Management System</h5>
            <button class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="sidebar p-3" style="position: relative; min-height: auto;">
                <nav class="d-grid gap-2">
                    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>

                    <a class="{{ request()->routeIs('students.*') ? 'active' : '' }}"
                        href="{{ route('students.index') }}">
                        <i class="bi bi-bar-chart"></i> Students
                    </a>

                    <a class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}"
                        href="{{ route('teachers.index') }}">
                        <i class="bi bi-person"></i> Teachers
                    </a>

                    <a class="{{ request()->routeIs('courses.*') ? 'active' : '' }}"
                        href="{{ route('courses.index') }}">
                        <i class="bi bi-cart"></i> Courses
                    </a>

                    <a class="{{ request()->routeIs('enrollments.*') ? 'active' : '' }}"
                        href="{{ route('enrollments.index') }}">
                        <i class="bi bi-box"></i> Enrollments
                    </a>

                    <a class="{{ request()->routeIs('course_teachers.*') ? 'active' : '' }}"
                        href="{{ route('course_teachers.index') }}">
                        <i class="bi bi-graph-up"></i> Assignments
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar (Fixed) -->
    <aside class="sidebar p-3 d-none d-md-block">
        <h4 class="text-white h5 mb-4">Student Management System</h4>
        <nav class="d-grid gap-2">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>

            <a class="{{ request()->routeIs('students.*') ? 'active' : '' }}"
                href="{{ route('students.index') }}">
                <i class="bi bi-bar-chart"></i> Students
            </a>

            <a class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}"
                href="{{ route('teachers.index') }}">
                <i class="bi bi-person"></i> Teachers
            </a>

            <a class="{{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                <i class="bi bi-cart"></i> Courses
            </a>

            <a class="{{ request()->routeIs('enrollments.*') ? 'active' : '' }}"
                href="{{ route('enrollments.index') }}">
                <i class="bi bi-box"></i> Enrollments
            </a>

            <a class="{{ request()->routeIs('course_teachers.*') ? 'active' : '' }}"
                href="{{ route('course_teachers.index') }}">
                <i class="bi bi-graph-up"></i> Assignments
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content p-3">

        <!-- Top Bar -->
        <header class="d-flex justify-content-between align-items-center mb-1">

            <!-- Left -->
            <div class="d-flex align-items-center gap-3">
                <!-- Hamburger -->
                <button class="btn btn-outline-secondary d-md-none" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <i class="bi bi-list"></i>
                </button>

                @php
                    $routeName = optional(request()->route())->getName();

                    // Determine title based on route prefix
                    if (str_starts_with($routeName, 'students.')) {
                        $title = 'Students Dashboard';
                    } elseif (str_starts_with($routeName, 'teachers.')) {
                        $title = 'Teachers Dashboard';
                    } elseif (str_starts_with($routeName, 'courses.')) {
                        $title = 'Courses Dashboard';
                    } elseif (str_starts_with($routeName, 'enrollments.')) {
                        $title = 'Enrollments Dashboard';
                    } elseif (str_starts_with($routeName, 'course_teachers.')) {
                        $title = 'Assignments Dashboard';
                    } elseif ($routeName === 'home') {
                        $title = 'Dashboard';
                    } else {
                        $title = 'Dashboard';
                    }
                @endphp
                <h3 class="mb-3">{{ $title }}</h3>
            </div>

            <!-- Right -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="badge bg-dark rounded">Admin</span>
                <img src="https://i.pravatar.cc/44?img=8" class="rounded-circle">
            </div>

        </header>

        <!-- Content Area -->
        @yield('content')

    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>

</html>
