<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $students = Student::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(8)->appends(['search' => $search]);

        return view('students.index', compact('students', 'search'));
    }

    public function create(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $students = Student::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search, 'page' => $page]);

        $showCreateModal = true;
        return view('students.index', compact('students', 'showCreateModal', 'search'))->with('currentPage', $page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:20',
            'joining_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
        ]);

        Student::create($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('students.index', ['page' => $page, 'search' => $search])->with('success', 'Student created successfully!');
    }

    public function show(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $students = Student::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search, 'page' => $page]);

        $showStudent = Student::findOrFail($id);
        return view('students.index', compact('students', 'showStudent', 'search'))->with('currentPage', $page);
    }

    public function edit(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $students = Student::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search, 'page' => $page]);

        $editStudent = Student::findOrFail($id);
        return view('students.index', compact('students', 'editStudent', 'search'))->with('currentPage', $page);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|string|max:20',
            'joining_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
        ]);

        $student->update($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('students.index', ['page' => $page, 'search' => $search])->with('success', 'Student updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('students.index', ['page' => $page, 'search' => $search])->with('success', 'Student deleted successfully!');
    }
}
