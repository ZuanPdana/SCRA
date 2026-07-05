<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StaffReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Registration disabled - only admin can create users via Filament
    // Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])
        ->middleware('role:mahasiswa')
        ->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::prefix('classrooms')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('classrooms.index');
        Route::get('/{classroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
    });

    Route::prefix('schedules')->group(function () {
        Route::get('/jadwal-sewa', [ScheduleController::class, 'jadwalSewa'])->name('schedules.jadwal-sewa');
        Route::get('/jadwal-mata-kuliah', [ScheduleController::class, 'jadwalMataKuliah'])->name('schedules.jadwal-mata-kuliah');
    });

    Route::prefix('reservations')->middleware('role:mahasiswa')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/create/{classroom}', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    Route::prefix('staff')->middleware('role:dosen')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dosenDashboard'])->name('staff.dashboard');
        Route::get('/reservations/pending', [StaffReservationController::class, 'pendingReservations'])->name('staff.reservations.pending');
        Route::get('/reservations/{reservation}', [StaffReservationController::class, 'show'])->name('staff.reservations.show');
        Route::put('/reservations/{reservation}/approve', [StaffReservationController::class, 'approve'])->name('staff.reservations.approve');
        Route::put('/reservations/{reservation}/reject', [StaffReservationController::class, 'reject'])->name('staff.reservations.reject');
    });

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    });
});
