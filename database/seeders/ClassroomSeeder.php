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
                Classroom::create([
                    'code' => 'AULA-' . strtoupper(Str::random(4)),
                    'subject_id' => $subject->id,
                    'date' => now()->subDays(rand(1, 30)),
                    'location' => 'Sala ' . rand(100, 200),
                    'start_time' => Carbon::parse('08:00')->toTimeString(),
                    'end_time' => Carbon::parse('10:00')->toTimeString(),
                ]);
            }
        }
    }
}
