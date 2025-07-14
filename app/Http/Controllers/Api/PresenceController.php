<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Presence;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'registration' => 'required|string',
            'password' => 'required|string',
        ]);

        // Busca o aluno pela matrícula
        $user = User::where('registration', $request->registration)->where('role', 0)->first();

        if (!$user) {
            return response()->json(['error' => 'Aluno não encontrado.'], 404);
        }

        // Procura uma aula hoje com a senha informada
        $classroom = Classroom::where('password', $request->password)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$classroom) {
            return response()->json(['error' => 'Aula não encontrada ou senha inválida.'], 404);
        }

        // Verifica se o aluno está vinculado à disciplina da aula
        $isRegistered = $user->subjects()->where('subject_id', $classroom->subject_id)->exists();

        if (!$isRegistered) {
            return response()->json(['error' => 'Aluno não está vinculado a essa disciplina.'], 403);
        }

        // Verifica se já foi registrada presença
        $alreadyRegistered = Presence::where('classroom_id', $classroom->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyRegistered) {
            return response()->json(['message' => 'Presença já registrada.'], 200);
        }

        // Registra a presença
        Presence::create([
            'classroom_id' => $classroom->id,
            'user_id' => $user->id,
            'status' => true,
        ]);

        return response()->json(['message' => 'Presença registrada com sucesso!']);
    }
}
