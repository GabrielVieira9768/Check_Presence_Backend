<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Professores
        User::create([
            'name' => 'Prof. Ana Silva',
            'email' => 'ana@prof.com',
            'password' => Hash::make('password'),
            'registration' => 'PROF001',
            'birth_date' => '1980-05-10',
            'role' => 1,
        ]);

        User::create([
            'name' => 'Prof. João Souza',
            'email' => 'joao@prof.com',
            'password' => Hash::make('password'),
            'registration' => 'PROF002',
            'birth_date' => '1975-08-20',
            'role' => 1,
        ]);

        // Alunos
        for ($i = 1; $i <= 9; $i++) {
            User::create([
                'name' => "Aluno $i",
                'email' => "aluno{$i}@example.com",
                'password' => Hash::make('password'),
                'registration' => 'ALUNO' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'birth_date' => '2000-01-01',
                'role' => 0,
            ]);
        }
    }
}
