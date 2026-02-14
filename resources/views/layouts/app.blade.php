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
background: linear-gradient(135deg, #0b1d3a, #1700ea);            color: #fff;
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
        <h4 class="text-white h5 p-2 mb-4"><i class="bi bi-buildings-fill me-2"></i>EnrollNet</h4>
        <nav class="d-grid gap-2">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>

            <a class="{{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                <i class="bi bi-bar-chart"></i> Students
            </a>

            <a class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
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
        <header class="top-bar-wrapper mb-4">
            <div class="top-bar d-flex justify-content-between align-items-center">
                <!-- Left -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Hamburger -->
                    <button class="btn btn-hamburger d-md-none" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i>
                    </button>

                    @php
                        $routeName = optional(request()->route())->getName();

                        // Determine title and icon based on route prefix
                        if (str_starts_with($routeName, 'students.')) {
                            $title = 'Students';
                            $icon = 'bi-people-fill';
                        } elseif (str_starts_with($routeName, 'teachers.')) {
                            $title = 'Teachers';
                            $icon = 'bi-person-badge-fill';
                        } elseif (str_starts_with($routeName, 'courses.')) {
                            $title = 'Courses';
                            $icon = 'bi-book-fill';
                        } elseif (str_starts_with($routeName, 'enrollments.')) {
                            $title = 'Enrollments';
                            $icon = 'bi-clipboard-check-fill';
                        } elseif (str_starts_with($routeName, 'course_teachers.')) {
                            $title = 'Assignments';
                            $icon = 'bi-diagram-3-fill';
                        } elseif ($routeName === 'home') {
                            $title = 'Dashboard';
                            $icon = 'bi-grid-fill';
                        } else {
                            $title = 'Dashboard';
                            $icon = 'bi-grid-fill';
                        }
                    @endphp

                    <div class="d-flex align-items-center gap-3">
                        <div class="title-icon d-none d-md-flex">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        <div>
                            <h3 class="page-title mb-0">{{ $title }}</h3>
                            <p class="page-subtitle mb-0">Manage your {{ strtolower($title) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Notifications (optional) -->
                    <button class="btn btn-icon d-none d-md-flex" title="Notifications">
                        <i class="bi bi-bell-fill"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <!-- User Info -->
                    <div class="user-profile d-flex align-items-center gap-2">
                        <div class="text-end d-none d-md-block">
                            <p class="user-name mb-0">Administrator</p>
                            <p class="user-role mb-0">Admin</p>
                        </div>
                        <div class="user-avatar">
                            <img src="https://i.pravatar.cc/40?img=8" class="rounded-circle" alt="Admin">
                            <span class="status-indicator"></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        @yield('content')

    </main>

    <style>
        .sidebar {
            background: #0b1c39
        }
        .top-bar-wrapper {
            position: sticky;
            top: 0;
            z-index: 100;
            margin: -12px -12px 24px -12px;
            padding: 12px;
            background: var(--bg-light);
        }

        .top-bar {
            background: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-hamburger {
            border: none;
            background: white;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-hamburger:hover {
            background: #f1f5f9;
            transform: scale(1.05);
        }

        .title-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
background: linear-gradient(135deg, #0b1d3a, #1700ea);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 2px;
        }

        .btn-icon {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #002fff;
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            padding: 4px;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-profile:hover {
            background: #f8fafc;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            color: #64748b;
            line-height: 1.2;
        }

        .user-avatar {
            position: relative;
            width: 40px;
            height: 40px;
        }

        .user-avatar img {
            width: 40px;
            height: 40px;
            border: 2px solid #002fff;
            object-fit: cover;
        }

        .status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: #10b981;
            border: 2px solid white;
            border-radius: 50%;
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .top-bar {
                padding: 12px 16px;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .page-subtitle {
                display: none;
            }

            .user-avatar img {
                width: 36px;
                height: 36px;
            }


        }

        /* Section Header */
    .section-header {
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: #64748b;
    }

    .btn-create {
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }

    /* Search Section */
    .search-section {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        color: #94a3b8;
        font-size: 1.125rem;
        z-index: 1;
        pointer-events: none;
    }

    .search-input-field {
        padding: 12px 16px 12px 44px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        background: white;
        transition: all 0.3s ease;
        width: 100%;
    }

    .search-input-field:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .search-input-field::placeholder {
        color: #94a3b8;
        font-size: 0.875rem;
    }

    .clear-search {
        position: absolute;
        right: 12px;
        color: #94a3b8;
        font-size: 1.25rem;
        transition: all 0.2s ease;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
    }

    .clear-search:hover {
        color: #64748b;
        transform: scale(1.1);
    }

    .btn-search {
        padding: 12px 20px;
        font-weight: 600;
        border-radius: 10px;
        background: #1e293b;
        border: none;
        color: white;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        color: black;
    }

    .btn-search:active {
        transform: translateY(0);
    }

    /* Responsive */
    @media (max-width: 767.98px) {
        .section-header {
            padding-bottom: 12px;
        }

        .section-title {
            font-size: 1.125rem;
        }

        .section-subtitle {
            font-size: 0.8125rem;
        }

        .btn-create {
            padding: 8px 12px;
            font-size: 0.875rem;
        }

        .search-section {
            padding: 12px;
        }

        .search-input-field {
            font-size: 0.875rem;
            padding: 10px 14px 10px 40px;
        }

        .btn-search {
            padding: 10px 16px;
            font-size: 0.875rem;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>

</html>
