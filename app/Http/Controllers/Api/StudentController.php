<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Presence;
use Zxing\QrReader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    public function subjects(Request $request)
    {
        $user = $request->user();

        // ✅ Corrigido
        $subjects = $user->registeredSubjects()->withCount('classrooms')->get();

        return response()->json($subjects);
    }

    public function classes(Request $request, Subject $subject)
    {
        $user = $request->user();

        // ✅ Corrigido
        if (!$user->registeredSubjects->contains($subject->id)) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $classrooms = $subject->classrooms()
            ->with(['presences' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->orderBy('date', 'desc')
            ->get();

        // ✅ Retorno formatado
        $data = $classrooms->map(function ($class) {
        $presence = $class->presences->first();

        return [
            'id' => $class->id,
            'code' => $class->code,
            'date' => $class->date,
            'start_time' => \Carbon\Carbon::parse($class->start_time)->format('H:i'),
            'end_time' => \Carbon\Carbon::parse($class->end_time)->format('H:i'),
            'location' => $class->location,
            'status' => $presence ? ($presence->status ? 'Presente' : 'Ausente') : 'Não registrado',
            'registered_at' => $presence?->regisred_at,
        ];
    });

        return response()->json($data);
    }

    public function read(Request $request)
    {
        $request->validate([
            'image_base64' => 'required|string',
        ]);

        try {
            $imageData = base64_decode($request->image_base64);
            $filename = 'qr_temp_' . time() . '.png';
            $filePath = storage_path('app/' . $filename);

            file_put_contents($filePath, $imageData);

            // Utiliza o Zxing\QrReader para ler o conteúdo
            $qrcode = new QrReader($filePath);
            $text = $qrcode->text();

            // Apaga a imagem temporária
            unlink($filePath);

            if (!$text) {
                return response()->json(['error' => 'QR Code não encontrado'], 400);
            }

            return response()->json(['code' => $text]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao processar imagem'], 500);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // Ex: "AULA123-ABC456"
        $code = $request->input('code');

        // Buscar a aula com essa senha
        $classroom = Classroom::where('password', $code)->first();

        if (!$classroom) {
            return response()->json(['message' => 'Código inválido.'], 404);
        }

        // Verificar se o aluno já registrou presença
        $existing = Presence::where('classroom_id', $classroom->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Presença já registrada.'], 200);
        }

        // Registrar presença
        $presence = Presence::create([
            'classroom_id' => $classroom->id,
            'user_id' => Auth::id(),
            'status' => true,
            'date' => now(),
            'regisred_at' => now()->format('H:i:s'),
        ]);

        return response()->json(['message' => 'Presença registrada com sucesso.', 'data' => $presence]);
    }

}
