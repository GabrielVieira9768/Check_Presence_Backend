<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            for ($i = 1; $i <= 3; $i++) {
                $date = now()->subDays(rand(1, 30))->startOfDay();
                $startTime = Carbon::parse('08:00')->toTimeString();
                $endTime = Carbon::parse('10:00')->toTimeString();

                Classroom::create([
                    'code' => 'AULA-' . strtoupper(Str::random(4)),
                    'subject_id' => $subject->id,
                    'date' => $date,
                    'location' => 'Sala ' . rand(100, 200),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'password' => $subject->code . '-' . strtoupper(Str::random(6)), // senha aleatória baseada no código da disciplina
                ]);
            }
        }
    }
}
