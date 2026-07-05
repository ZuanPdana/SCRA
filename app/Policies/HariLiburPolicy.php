<?php

namespace App\Policies;

use App\Models\HariLibur;
use App\Models\User;

class HariLiburPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, HariLibur $hariLibur): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, HariLibur $hariLibur): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, HariLibur $hariLibur): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, HariLibur $hariLibur): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, HariLibur $hariLibur): bool
    {
        return $user->isAdmin();
    }
}
