<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', User::class);

        $users = User::query()
            ->with('role')
            ->latest()
            ->paginate(20);

        $roles = Role::query()->orderBy('name')->get();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'role_id' => ['nullable', 'exists:roles,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->user()->is($user) && ! (bool) $validated['is_active']) {
            return redirect()
                ->route('admin.users.index')
                ->with('status', 'Impossible de desactiver votre propre compte admin.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('status', 'Utilisateur mis a jour.');
    }
}
