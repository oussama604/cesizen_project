<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::query()->updateOrCreate(
            ['name' => Role::USER],
            ['label' => 'Utilisateur']
        );

        Role::query()->updateOrCreate(
            ['name' => Role::ADMIN],
            ['label' => 'Administrateur']
        );
    }
}
