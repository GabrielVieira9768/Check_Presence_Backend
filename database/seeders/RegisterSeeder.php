<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Register;
use App\Models\User;
use App\Models\Subject;

class RegisterSeeder extends Seeder
{
    public function run(): void
    {
        // Pega alguns alunos
        $students = User::where('role', 0)->take(10)->get();

        // Pega todas as matérias
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            // Matricula aleatoriamente até 5 alunos por matéria
            $randomStudents = $students->random(min(5, $students->count()));

            foreach ($randomStudents as $student) {
                // Evita duplicata (por garantia)
                $exists = $subject->students()->where('users.id', $student->id)->exists();
                if (!$exists) {
                    $subject->students()->attach($student->id, ['registered_at' => now()]);
                }
            }
        }
    }
}
