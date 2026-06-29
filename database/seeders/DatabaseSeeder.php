<?php

namespace Database\Seeders;

use App\Models\Periodo;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@tecsup.edu.pe'],
            [
                'name' => 'Administrador General',
                'role' => 'administrador',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'bienestar@tecsup.edu.pe'],
            [
                'name' => 'Bienestar Estudiantil',
                'role' => 'bienestar',
                'password' => Hash::make('password'),
            ]
        );

        $tutorUser = User::updateOrCreate(
            ['email' => 'tutor@tecsup.edu.pe'],
            [
                'name' => 'Tutor Demo',
                'role' => 'tutor',
                'password' => Hash::make('password'),
            ]
        );

        Tutor::updateOrCreate(
            ['codigo' => 'TUT-001'],
            [
                'user_id' => $tutorUser->id,
                'telefono' => '999999999',
                'especialidad' => 'Acompanamiento estudiantil',
                'activo' => true,
            ]
        );

        Periodo::updateOrCreate(
            ['nombre' => '2026-I'],
            [
                'fecha_inicio' => '2026-03-01',
                'fecha_fin' => '2026-07-31',
                'activo' => true,
            ]
        );

        foreach ([
            [$admin, 'admin-token-demo'],
            [User::where('email', 'bienestar@tecsup.edu.pe')->first(), 'bienestar-token-demo'],
            [$tutorUser, 'tutor-token-demo'],
        ] as [$user, $tokenName]) {
            $user->tokens()->delete();
            $plainToken = $user->createToken($tokenName)->plainTextToken;

            $this->command?->warn("Token Sanctum {$tokenName}: {$plainToken}");
        }
    }
}
