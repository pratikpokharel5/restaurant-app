<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $staff): bool
    {
        return $user->isAdmin()
            && $staff->role === User::ROLE_STAFF;
    }

    public function resetPassword(User $user, User $staff): bool
    {
        return $user->isAdmin()
            && $staff->role === User::ROLE_STAFF;
    }

    public function archive(User $user, User $staff): bool
    {
        return $user->isAdmin()
            && $staff->role === User::ROLE_STAFF
            && $staff->id !== $user->id;
    }

    public function restore(User $user, User $staff): bool
    {
        return $user->isAdmin()
            && $staff->role === User::ROLE_STAFF;
    }
}
