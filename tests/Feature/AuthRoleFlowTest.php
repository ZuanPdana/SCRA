<?php

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('seeds required default accounts and classrooms', function () {
    $this->seed();

    $admin = User::query()->where('email', 'admin@example.com')->first();
    $dosen = User::query()->where('email', 'dosen@example.com')->first();
    $mahasiswa = User::query()->where('email', 'mahasiswa@example.com')->first();

    expect($admin)->not->toBeNull();
    expect($dosen)->not->toBeNull();
    expect($mahasiswa)->not->toBeNull();

    expect(Hash::check('password', $admin->password))->toBeTrue();
    expect(Hash::check('password', $dosen->password))->toBeTrue();
    expect(Hash::check('password', $mahasiswa->password))->toBeTrue();

    expect(Classroom::query()->count())->toBeGreaterThanOrEqual(5);
});

it('redirects login based on role', function () {
    $this->seed();

    $this->post('/login', [
        'email' => 'mahasiswa@example.com',
        'password' => 'password',
    ])->assertRedirect(route('dashboard', absolute: false));

    auth()->logout();

    $this->post('/login', [
        'email' => 'dosen@example.com',
        'password' => 'password',
    ])->assertRedirect(route('staff.dashboard', absolute: false));

    auth()->logout();

    $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard', absolute: false));
});

it('protects filament admin panel for non admin users', function () {
    $this->seed();

    $mahasiswa = User::query()->where('email', 'mahasiswa@example.com')->firstOrFail();

    $this->actingAs($mahasiswa)
        ->get('/admin')
        ->assertStatus(403);

    $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertStatus(200);
});
