<?php

namespace App\Policies;

use App\Models\JadwalMataKuliah;
use App\Models\User;

class JadwalMataKuliahPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isDosen();
    }

    public function view(User $user, JadwalMataKuliah $jadwalMataKuliah): bool
    {
        return $user->isAdmin() || ($user->isDosen() && $user->id === $jadwalMataKuliah->dosen_id);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, JadwalMataKuliah $jadwalMataKuliah): bool
    {
        return $user->isAdmin() || ($user->isDosen() && $user->id === $jadwalMataKuliah->dosen_id);
    }

    public function delete(User $user, JadwalMataKuliah $jadwalMataKuliah): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, JadwalMataKuliah $jadwalMataKuliah): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, JadwalMataKuliah $jadwalMataKuliah): bool
    {
        return $user->isAdmin();
    }
}
