<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;

class CourseTeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $courses = Course::with('teachers')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhereHas('teachers', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('course_teachers.index', compact('courses', 'search'));
    }

    public function create(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $courses = Course::with('teachers')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhereHas('teachers', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->paginate(10)
            ->appends(['search' => $search, 'page' => $page]);

        $allCourses = Course::all();
        $allTeachers = Teacher::all();
        $showCreateModal = true;

        return view('course_teachers.index', compact('courses', 'allCourses', 'allTeachers', 'showCreateModal', 'search'))->with('currentPage', $page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $course->teachers()->sync($validated['teacher_ids']);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('course_teachers.index', ['page' => $page, 'search' => $search])
            ->with('success', 'Teachers assigned successfully!');
    }

    public function show(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $courses = Course::with('teachers')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhereHas('teachers', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->paginate(10)
            ->appends(['search' => $search, 'page' => $page]);

        $showCourse = Course::with('teachers')->findOrFail($id);

        return view('course_teachers.index', compact('courses', 'showCourse', 'search'))->with('currentPage', $page);
    }

    public function edit(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $courses = Course::with('teachers')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhereHas('teachers', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->paginate(10)
            ->appends(['search' => $search, 'page' => $page]);

        $editCourse = Course::with('teachers')->findOrFail($id);
        $allTeachers = Teacher::all();

        return view('course_teachers.index', compact('courses', 'editCourse', 'allTeachers', 'search'))->with('currentPage', $page);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'teacher_ids' => 'array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $course = Course::findOrFail($id);
        $course->teachers()->sync($validated['teacher_ids'] ?? []);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('course_teachers.index', ['page' => $page, 'search' => $search])
            ->with('success', 'Teachers updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->teachers()->detach();

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('course_teachers.index', ['page' => $page, 'search' => $search])
            ->with('success', 'All teachers removed from course successfully!');
    }
}
