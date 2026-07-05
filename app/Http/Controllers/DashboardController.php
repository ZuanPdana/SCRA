<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $user = Auth::user();

        $totalReservations = $user->reservations()->count();
        $latestReservation = $user->reservations()->latest()->first();
        $availableClassrooms = Classroom::query()->where('status', 'Available')->count();
        $reservationHistory = $user->reservations()->with('classroom')->latest()->take(5)->get();

        return view('dashboard.user', compact(
            'totalReservations',
            'latestReservation',
            'availableClassrooms',
            'reservationHistory'
        ));
    }

    public function dosenDashboard()
    {
        $pendingReservations = Reservation::query()->where('reservation_status', 'Pending')->count();
        $approvedReservations = Reservation::query()->where('reservation_status', 'Approved')->count();
        $rejectedReservations = Reservation::query()->where('reservation_status', 'Rejected')->count();
        $recentPending = Reservation::query()
            ->where('reservation_status', 'Pending')
            ->with(['user', 'classroom'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.staff', compact(
            'pendingReservations',
            'approvedReservations',
            'rejectedReservations',
            'recentPending'
        ));
    }

    public function adminDashboard()
    {
        return redirect('/admin');
    }
}
