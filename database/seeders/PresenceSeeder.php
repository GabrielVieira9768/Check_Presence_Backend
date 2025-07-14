<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 0)->get();
        $classrooms = Classroom::all();

        foreach ($classrooms as $classroom) {
            foreach ($students as $student) {
                Presence::create([
                    'classroom_id' => $classroom->id,
                    'user_id' => $student->id,
                    'status' => rand(0, 1),
                    'date' => $classroom->date,
                    'regisred_at' => now(),
                ]);
            }
        }
    }
}
