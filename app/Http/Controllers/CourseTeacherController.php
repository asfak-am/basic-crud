<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;

class CourseTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all courses with their assigned teachers
        $courses = Course::with('teachers')->paginate(8);
        return view('course_teachers.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $teachers = Teacher::all();
        return view('course_teachers.create', compact('courses', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $course = Course::findOrFail($request->course_id);

        // Assign multiple teachers to the course without removing existing ones
        $course->teachers()->syncWithoutDetaching($request->teacher_ids);

        return redirect()->route('course_teachers.index')
                        ->with('success', 'Teachers assigned successfully.');
    }

    /**
     * Display the specified course with its teachers.
     */
    public function show($id)
    {
        $course = Course::with('teachers')->findOrFail($id);
        return view('course_teachers.show', compact('course'));
    }

    /**
     * Show the form for editing the teachers of a course.
     */
    public function edit($id)
    {
        $course = Course::with('teachers')->findOrFail($id);
        $teachers = Teacher::all();

        return view('course_teachers.edit', compact('course', 'teachers'));
    }

    /**
     * Update the assigned teachers for a course.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        $course = Course::findOrFail($id);

        // Update teachers: this will replace existing assignments
        $course->teachers()->sync($request->teacher_ids);

        return redirect()->route('course_teachers.index')
                        ->with('success', 'Course teachers updated successfully.');
    }

    /**
     * Remove all teachers from a course or delete a course-teacher assignment.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Remove all teacher assignments for this course
        $course->teachers()->detach();

        return redirect()->route('course_teachers.index')
                        ->with('success', 'All teachers removed from the course.');
    }
}
