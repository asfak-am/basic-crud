@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session()->get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Counters -->
<section class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card dashboard-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-people-fill text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h6 class="text-muted mb-2">Total Students</h6>
                <h2 class="counter fw-bold text-primary mb-0" data-target="{{ $totalStudents }}">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card dashboard-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-book-fill text-warning" style="font-size: 2.5rem;"></i>
                </div>
                <h6 class="text-muted mb-2">Total Courses</h6>
                <h2 class="counter fw-bold text-warning mb-0" data-target="{{ $totalCourses }}">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card dashboard-card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-clipboard-check-fill text-danger" style="font-size: 2.5rem;"></i>
                </div>
                <h6 class="text-muted mb-2">Total Enrollments</h6>
                <h2 class="counter fw-bold text-danger mb-0" data-target="{{ $totalEnrollments }}">0</h2>
            </div>
        </div>
    </div>
</section>

<!-- Charts -->
<section class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bar-chart-fill text-primary me-2" style="font-size: 1.25rem;"></i>
                    <h6 class="mb-0 fw-semibold">Enrollments per Course</h6>
                </div>
            </div>
            <div class="card-body">
                <canvas id="enrollmentChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-badge-fill text-danger me-2" style="font-size: 1.25rem;"></i>
                    <h6 class="mb-0 fw-semibold">Courses per Teacher</h6>
                </div>
            </div>
            <div class="card-body">
                <canvas id="teacherChart" height="200"></canvas>
            </div>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-graph-up text-success me-2" style="font-size: 1.25rem;"></i>
                    <h6 class="mb-0 fw-semibold">Enrollments Trend (Last 12 Months)</h6>
                </div>
            </div>
            <div class="card-body">
                <canvas id="enrollmentTrendChart" height="100"></canvas>
            </div>
        </div>
    </div>
</section>

<style>
    .dashboard-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
    }

    .dashboard-card .card-body {
        position: relative;
        z-index: 1;
    }

    .icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .counter {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    canvas {
        max-height: 300px;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = Math.ceil(target / 100);
            if(count < target){
                counter.innerText = count + increment;
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    // Chart.js global defaults
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

    // Bar Chart: Enrollments per Course
    new Chart(document.getElementById('enrollmentChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($courseNames),
            datasets: [{
                label: 'Enrollments',
                data: @json($enrollmentsCount),
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Bar Chart: Teachers per Course
    new Chart(document.getElementById('teacherChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($teacherNames),
            datasets: [{
                label: 'Courses Assigned',
                data: @json($coursesPerTeacher),
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Line Chart: Enrollment Trend
    new Chart(document.getElementById('enrollmentTrendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Enrollments',
                data: @json($enrollmentsPerMonth),
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
