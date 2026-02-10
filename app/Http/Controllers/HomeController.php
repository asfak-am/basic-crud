<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Enrollment;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Counters
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();

        // Bar Chart: Enrollments per Course
        $courses = Course::all();
        $courseNames = $courses->pluck('name');
        $enrollmentsCount = $courses->map(fn($course) => $course->enrollments()->count());

        // Bar Chart: Teachers per Course
        $teachers = Teacher::all();
        $teacherNames = $teachers->pluck('name');
        $coursesPerTeacher = $teachers->map(fn($teacher) => $teacher->courses()->count());

        // Line Chart: Enrollment Trend last 12 months
        $months = [];
        $enrollmentsPerMonth = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M Y');
            $months[] = $month;
            $count = Enrollment::whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                               ->whereYear('created_at', Carbon::now()->subMonths($i)->year)
                               ->count();
            $enrollmentsPerMonth[] = $count;
        }

        return view('index', compact(
            'totalStudents',
            'totalCourses',
            'totalEnrollments',
            'courseNames',
            'enrollmentsCount',
            'teacherNames',
            'coursesPerTeacher',
            'months',
            'enrollmentsPerMonth'
        ));
    }
}
