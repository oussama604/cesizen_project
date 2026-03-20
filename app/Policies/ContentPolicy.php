<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(?User $user, Content $content): bool
    {
        return $content->is_published;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Content $content): bool
    {
        return false;
    }

    public function delete(User $user, Content $content): bool
    {
        return false;
    }
}
