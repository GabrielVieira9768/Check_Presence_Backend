<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Lista os alunos matriculados nas disciplinas do professor logado
    public function index()
    {
        $teacher = auth()->user();

        // Pega as disciplinas do professor
        $subjects = Subject::where('teacher_id', $teacher->id)
                    ->with('students')
                    ->get();

        return view('registers.index', compact('subjects'));
    }

    // Mostra o formulário para matricular aluno em uma disciplina específica
    public function create($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);

        // Somente o professor dono da disciplina pode matricular
        if ($subject->teacher_id !== auth()->id()) {
            abort(403);
        }

        // Pega os alunos que ainda não estão matriculados nessa disciplina
        $registeredUserIds = $subject->students->pluck('id')->toArray();
        $students = User::where('role', 0)
                    ->whereNotIn('id', $registeredUserIds)
                    ->get();

        return view('registers.create', compact('subject', 'students'));
    }

    // Salva a matrícula
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $subject = Subject::findOrFail($data['subject_id']);

        if ($subject->teacher_id !== auth()->id()) {
            abort(403);
        }

        // Evita duplicata manualmente (por segurança)
        if ($subject->students()->where('users.id', $data['user_id'])->exists()) {
            return back()->withErrors(['user_id' => 'Aluno já matriculado nessa disciplina.']);
        }

        // Cria a matrícula com a data atual
        $subject->students()->attach($data['user_id'], ['registered_at' => now()]);

        return redirect()->route('registers.index')
            ->with('success', 'Aluno matriculado com sucesso!');
    }

    // Remove matrícula (desmatricula aluno)
    public function destroy(Register $register)
    {
        $subject = $register->subject;

        if ($subject->teacher_id !== auth()->id()) {
            abort(403);
        }

        $register->delete();

        return redirect()->route('registers.index')
            ->with('success', 'Matrícula removida com sucesso!');
    }
}
