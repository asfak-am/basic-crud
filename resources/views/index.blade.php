@extends('layouts.app')

@section('content')
@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<!-- Counters -->
<section class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h6>Total Students</h6>
            <h3 class="counter" data-target="{{ $totalStudents }}">0</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h6>Total Courses</h6>
            <h3 class="counter" data-target="{{ $totalCourses }}">0</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h6>Total Enrollments</h6>
            <h3 class="counter" data-target="{{ $totalEnrollments }}">0</h3>
        </div>
    </div>
</section>

<!-- Charts -->
<section class="row g-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Enrollments per Course</h6>
            <canvas id="enrollmentChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Teachers per Course</h6>
            <canvas id="teacherChart" height="200"></canvas>
        </div>
    </div>
</section>

<section class="row g-4 mt-4">
    <div class="col-md-12">
        <div class="card p-3">
            <h6>Enrollments Trend (Last 12 Months)</h6>
            <canvas id="enrollmentTrendChart" height="200"></canvas>
        </div>
    </div>
</section>
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
            } else { counter.innerText = target; }
        };
        updateCount();
    });

    // Bar Chart: Enrollments per Course
    new Chart(document.getElementById('enrollmentChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($courseNames),
            datasets: [{
                label: 'Enrollments',
                data: @json($enrollmentsCount),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Bar Chart: Teachers per Course
    new Chart(document.getElementById('teacherChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($teacherNames),
            datasets: [{
                label: 'Courses Assigned',
                data: @json($coursesPerTeacher),
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Line Chart: Enrollment Trend
    new Chart(document.getElementById('enrollmentTrendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Enrollments',
                data: @json($enrollmentsPerMonth),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: { responsive: true }
    });
});
</script>
@endpush
