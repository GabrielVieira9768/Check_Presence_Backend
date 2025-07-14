<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = User::where('role', 1)->get();

        foreach ($teachers as $index => $teacher) {
            Subject::create([
                'name' => 'Disciplina ' . ($index + 1),
                'code' => 'MAT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'teacher_id' => $teacher->id,
                'description' => 'Descrição da disciplina ' . ($index + 1),
                'credits' => rand(2, 4),
                'capacity' => rand(20, 40),
            ]);
        }
    }
}
