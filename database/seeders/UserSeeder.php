<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()->where('role_name', 'admin')->firstOrFail();
        $dosenRole = Role::query()->where('role_name', 'dosen')->firstOrFail();
        $mahasiswaRole = Role::query()->where('role_name', 'mahasiswa')->firstOrFail();

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'phone' => '081200000001',
                'department' => 'Administrasi',
                'role_id' => $adminRole->id,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'dosen@example.com'],
            [
                'name' => 'Dosen',
                'password' => Hash::make('password'),
                'phone' => '081200000002',
                'department' => 'Akademik',
                'role_id' => $dosenRole->id,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'mahasiswa@example.com'],
            [
                'name' => 'Mahasiswa',
                'password' => Hash::make('password'),
                'phone' => '081200000003',
                'department' => 'Teknik Informatika',
                'role_id' => $mahasiswaRole->id,
            ]
        );
    }
}
