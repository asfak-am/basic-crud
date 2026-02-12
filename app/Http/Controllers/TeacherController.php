<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teachers = Teacher::paginate(8);
        return view('Teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|numeric|unique:teachers,phone',
            'department' => 'string',
        ]);

        Teacher::create($request->all());

        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = Teacher::find($id);

        return view('Teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = Teacher::find($id);

        return view('Teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'required|numeric|unique:teachers,phone,' . $id,
            'department' => 'string',
        ]);

        $teacher = Teacher::find($id);
        $teacher->update($request->all());

        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();

        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher deleted successfully.');
    }
}
