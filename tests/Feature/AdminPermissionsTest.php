<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_pages(): void
    {
        $userRole = Role::query()->create([
            'name' => Role::USER,
            'label' => 'Utilisateur',
        ]);

        $user = User::factory()->createOne([
            'role_id' => $userRole->id,
        ]);
        $this->assertInstanceOf(User::class, $user);
        $authUser = User::query()->findOrFail($user->id);

        $this->actingAs($authUser)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs($authUser)
            ->get(route('admin.contents.index'))
            ->assertForbidden();

        $this->actingAs($authUser)
            ->get(route('admin.stress-events.index'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_pages(): void
    {
        $adminRole = Role::query()->create([
            'name' => Role::ADMIN,
            'label' => 'Administrateur',
        ]);

        $admin = User::factory()->createOne([
            'role_id' => $adminRole->id,
        ]);
        $this->assertInstanceOf(User::class, $admin);
        $authAdmin = User::query()->findOrFail($admin->id);

        $this->actingAs($authAdmin)
            ->get(route('admin.users.index'))
            ->assertOk();

        $this->actingAs($authAdmin)
            ->get(route('admin.contents.index'))
            ->assertOk();

        $this->actingAs($authAdmin)
            ->get(route('admin.stress-events.index'))
            ->assertOk();
    }
}
