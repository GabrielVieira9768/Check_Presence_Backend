<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    public function index()
    {
        return Classroom::with('subject')->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $subject = \App\Models\Subject::findOrFail($data['subject_id']);

        if ($subject->teacher_id !== auth()->id()) {
            abort(403, 'Você não pode adicionar aulas para essa disciplina.');
        }

        \App\Models\Classroom::create($data);

        return redirect()->route('subjects.classrooms', $subject->id)
                        ->with('success', 'Aula criada com sucesso!');
    }

    public function show(Classroom $classroom)
    {
        return $classroom->load('subject', 'presences');
    }

    public function update(Request $request, Classroom $classroom)
    {
        $classroom->update($request->all());
        return $classroom;
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return response()->noContent();
    }

    public function generateQrCode(Classroom $classroom)
    {
        if ($classroom->subject->teacher_id !== auth()->id()) {
            abort(403, 'Acesso negado.');
        }

        // Gera a senha apenas se ainda não existir
        if (!$classroom->password) {
            $senha = $classroom->code . '-' . Str::random(6);
            $classroom->password = $senha;
            $classroom->save();
        } else {
            $senha = $classroom->password;
        }

        $qrCodeSvg = QrCode::size(300)->generate($senha);

        return view('subjects.qrcode', compact('qrCodeSvg', 'classroom', 'senha'));
    }

}
