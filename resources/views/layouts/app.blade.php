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
        }

        .sidebar {
            width: 260px;
            background: #0b1c39;
            min-height: 100vh;
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

        .card {

            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            background: #f1f3ff;
            border: none;
        }
    </style>
</head>

<body>

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas  d-md-none" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="text-dark">Student Management System</h5>
            <button class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <aside class="sidebar p-3">
                <nav class="d-grid gap-2">
                <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="bi bi-grid"></i> Dashboard</a>
                <a class="{{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}"><i class="bi bi-bar-chart"></i> Students</a>
                <a class="{{ request()->routeIs('teachers.index') ? 'active' : '' }}" href="{{ route('teachers.index') }}"><i class="bi bi-person"></i> Teachers</a>
                <a class="{{ request()->routeIs('courses.index') ? 'active' : '' }}" href="{{ route('courses.index') }}"><i class="bi bi-cart"></i> Courses</a>
                <a class="{{ request()->routeIs('enrollments.index') ? 'active' : '' }}" href="{{ route('enrollments.index') }}"><i class="bi bi-box"></i> Enrollments</a>
                <a class="{{ request()->routeIs('course_teachers.index') ? 'active' : '' }}" href="{{ route('course_teachers.index') }}"><i class="bi bi-graph-up"></i> Assignments</a>
                </nav>
            </aside>
        </div>
    </div>

    <div class="d-flex">

        <!-- Desktop Sidebar -->
        <aside class="sidebar p-3 d-none d-md-block">
            <h4 class="text-white mb-4">Student Management System</h4>
            <nav class="d-grid gap-2">
                <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="bi bi-grid"></i> Dashboard</a>
                <a class="{{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}"><i class="bi bi-bar-chart"></i> Students</a>
                <a class="{{ request()->routeIs('teachers.index') ? 'active' : '' }}" href="{{ route('teachers.index') }}"><i class="bi bi-person"></i> Teachers</a>
                <a class="{{ request()->routeIs('courses.index') ? 'active' : '' }}" href="{{ route('courses.index') }}"><i class="bi bi-cart"></i> Courses</a>
                <a class="{{ request()->routeIs('enrollments.index') ? 'active' : '' }}" href="{{ route('enrollments.index') }}"><i class="bi bi-box"></i> Enrollments</a>
                <a class="{{ request()->routeIs('course_teachers.index') ? 'active' : '' }}" href="{{ route('course_teachers.index') }}"><i class="bi bi-graph-up"></i> Assignments</a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-grow-1 p-3">

            <!-- Top Bar -->
            <header class="d-flex justify-content-between align-items-center mb-1">

                <!-- Left -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Hamburger -->
                    <button class="btn btn-outline-secondary d-md-none" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i>
                    </button>

                    <h3 class="mb-0">Dashboard</h3>
                </div>

                <!-- Right -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Desktop search -->
                    <input type="search" class="form-control search-input-dark d-none d-md-block"
                        placeholder="Search here...">

                    <!-- Mobile search icon -->
                    <button class="btn btn-outline-secondary d-md-none">
                        <i class="bi bi-search"></i>
                    </button>

                    <img src="https://i.pravatar.cc/44?img=7" class="rounded-circle">
                </div>

            </header>
            @yield('content')

        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

     @stack('scripts')
</body>

</html>
