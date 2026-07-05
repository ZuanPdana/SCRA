<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    public function changeRole(User $user, User $model): bool
    {
        // Only admins can change roles
        if (!$user->isAdmin()) {
            return false;
        }

        // Prevent admin from changing their own role
        if ($user->id === $model->id) {
            return false;
        }

        return true;
    }
}
