<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return Subject::with('teacher')->get();
    }

    public function store(Request $request)
    {
        return Subject::create($request->all());
    }

    public function show(Subject $subject)
    {
        return $subject->load('teacher', 'classrooms');
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->all());
        return $subject;
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->noContent();
    }

    public function classrooms($subjectId)
    {
        $subject = Subject::with('classrooms.presences.user')->findOrFail($subjectId);

        // Garantir que o professor só veja suas próprias matérias
        abort_if(auth()->id() !== $subject->teacher_id, 403);

        return view('subjects.classrooms', compact('subject'));
    }

}
