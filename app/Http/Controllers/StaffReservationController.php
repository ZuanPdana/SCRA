<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class StaffReservationController extends Controller
{
    public function pendingReservations()
    {
        $reservations = Reservation::query()
            ->where('reservation_status', 'Pending')
            ->with(['user', 'classroom'])
            ->latest()
            ->paginate(10);

        return view('staff.reservations.pending', [
            'reservations' => $reservations,
        ]);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'classroom']);

        return view('staff.reservations.show', [
            'reservation' => $reservation,
        ]);
    }

    public function approve(Reservation $reservation, Request $request)
    {
        if ($reservation->reservation_status !== 'Pending') {
            return back()->with('error', 'Hanya reservasi Menunggu yang bisa disetujui.');
        }

        if ($reservation->purpose_type === 'Kegiatan Lain') {
            return back()->with('error', 'Reservasi kegiatan lain hanya bisa disetujui oleh admin.');
        }

        $classroom = $reservation->classroom;
        $reservation->update([
            'reservation_status' => 'Approved',
            'verified_by' => $request->user()->id,
            'rejection_reason' => null,
        ]);

        ActivityLogService::logReservationApproved($classroom->room_name, $request->user());

        return redirect()->route('staff.reservations.pending')
            ->with('success', 'Reservasi berhasil disetujui.');
    }

    public function reject(Reservation $reservation, Request $request)
    {
        if ($reservation->reservation_status !== 'Pending') {
            return back()->with('error', 'Hanya reservasi Menunggu yang bisa ditolak.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $classroom = $reservation->classroom;
        $reservation->update([
            'reservation_status' => 'Rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'verified_by' => $request->user()->id,
        ]);

        ActivityLogService::logReservationRejected($classroom->room_name, $request->user());

        return redirect()->route('staff.reservations.pending')
            ->with('success', 'Reservasi berhasil ditolak.');
    }
}
