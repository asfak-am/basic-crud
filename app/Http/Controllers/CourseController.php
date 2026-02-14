<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $courses = Course::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(8)->appends(['search' => $search]);

        return view('Courses.index', compact('courses', 'search'));
    }

    public function create(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $courses = Course::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(8)->appends(['search' => $search, 'page' => $page]);

        $showCreateModal = true;
        return view('Courses.index', compact('courses', 'showCreateModal', 'search'))->with('currentPage', $page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:courses,code',
            'credits' => 'required|numeric',
        ]);

        Course::create($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('courses.index', ['page' => $page, 'search' => $search])->with('success', 'Course created successfully.');
    }

    public function show(Request $request, string $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $courses = Course::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(8)->appends(['search' => $search, 'page' => $page]);

        $showCourse = Course::findOrFail($id);
        return view('Courses.index', compact('courses', 'showCourse', 'search'))->with('currentPage', $page);
    }

    public function edit(Request $request, string $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $courses = Course::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(8)->appends(['search' => $search, 'page' => $page]);

        $editCourse = Course::findOrFail($id);
        return view('Courses.index', compact('courses', 'editCourse', 'search'))->with('currentPage', $page);
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:courses,code,' . $id,
            'credits' => 'required|numeric',
        ]);

        $course->update($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('courses.index', ['page' => $page, 'search' => $search])->with('success', 'Course updated successfully.');
    }

    public function destroy(Request $request, string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('courses.index', ['page' => $page, 'search' => $search])->with('success', 'Course deleted successfully.');
    }
}
