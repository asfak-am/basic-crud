<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $teachers = Teacher::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search]);

        return view('teachers.index', compact('teachers', 'search'));
    }

    public function create(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $teachers = Teacher::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search, 'page' => $page]);

        $showCreateModal = true;
        return view('teachers.index', compact('teachers', 'showCreateModal', 'search'))->with('currentPage', $page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:255',
        ]);

        Teacher::create($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('teachers.index', ['page' => $page, 'search' => $search])->with('success', 'Teacher created successfully!');
    }

    public function show(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $teachers = Teacher::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search, 'page' => $page]);

        $showTeacher = Teacher::findOrFail($id);
        return view('teachers.index', compact('teachers', 'showTeacher', 'search'))->with('currentPage', $page);
    }

    public function edit(Request $request, $id)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);

        $teachers = Teacher::when($search, function ($query) use ($search) {
            return $query->search($search);
        })->paginate(10)->appends(['search' => $search, 'page' => $page]);

        $editTeacher = Teacher::findOrFail($id);
        return view('teachers.index', compact('teachers', 'editTeacher', 'search'))->with('currentPage', $page);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:255',
        ]);

        $teacher->update($validated);

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('teachers.index', ['page' => $page, 'search' => $search])->with('success', 'Teacher updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        $page = $request->get('page', 1);
        $search = $request->get('search');

        return redirect()->route('teachers.index', ['page' => $page, 'search' => $search])->with('success', 'Teacher deleted successfully!');
    }
}
