<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\BreathingExerciseSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StressEventSeeder;
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
        $this->call([
            RoleSeeder::class,
            StressEventSeeder::class,
            BreathingExerciseSeeder::class,
        ]);

        $adminRoleId = Role::query()->where('name', Role::ADMIN)->value('id');
        $userRoleId = Role::query()->where('name', Role::USER)->value('id');

        User::query()->firstOrCreate([
            'email' => 'admin@cesizen.local',
        ], [
            'role_id' => $adminRoleId,
            'name' => 'Admin CESIZen',
            'password' => Hash::make('password'),
            'gdpr_consent_at' => now(),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'role_id' => $userRoleId,
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'gdpr_consent_at' => now(),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
