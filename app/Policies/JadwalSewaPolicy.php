<?php

namespace App\Policies;

use App\Models\JadwalSewa;
use App\Models\User;

class JadwalSewaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, JadwalSewa $jadwalSewa): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, JadwalSewa $jadwalSewa): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, JadwalSewa $jadwalSewa): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, JadwalSewa $jadwalSewa): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, JadwalSewa $jadwalSewa): bool
    {
        return $user->isAdmin();
    }
}
