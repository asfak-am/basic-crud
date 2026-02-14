<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $enrollments = Enrollment::with(['student', 'course'])
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('enrollments.index', compact('enrollments', 'search'));
    }

    public function create(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $enrollments = Enrollment::with(['student', 'course'])
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->paginate(10)
            ->appends(['search' => $search, 'page' => $page]);

        $students = Student::all();
        $courses = Course::all();
        $showCreateModal = true;

        return view('enrollments.index', compact('enrollments', 'students', 'courses', 'showCreateModal', 'search'))->with('currentPage', $page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        Enrollment::create($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('enrollments.index', ['page' => $page, 'search' => $search])
            ->with('success', 'Enrollment created successfully!');
    }

    public function show(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $enrollments = Enrollment::with(['student', 'course'])
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->paginate(10)
            ->appends(['search' => $search, 'page' => $page]);

        $showEnrollment = Enrollment::with(['student', 'course'])->findOrFail($id);

        return view('enrollments.index', compact('enrollments', 'showEnrollment', 'search'))->with('currentPage', $page);
    }

    public function edit(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $enrollments = Enrollment::with(['student', 'course'])
            ->when($search, function ($query) use ($search) {
                return $query->search($search);
            })
            ->paginate(10)
            ->appends(['search' => $search, 'page' => $page]);

        $editEnrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        $students = Student::all();
        $courses = Course::all();

        return view('enrollments.index', compact('enrollments', 'editEnrollment', 'students', 'courses', 'search'))->with('currentPage', $page);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment->update($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('enrollments.index', ['page' => $page, 'search' => $search])
            ->with('success', 'Enrollment updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('enrollments.index', ['page' => $page, 'search' => $search])
            ->with('success', 'Enrollment deleted successfully!');
    }
}
