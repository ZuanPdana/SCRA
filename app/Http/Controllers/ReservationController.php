<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\HariLibur;
use App\Models\JadwalSewa;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = $request->user()
            ->reservations()
            ->with('classroom')
            ->latest()
            ->paginate(10);

        return view('reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    public function create(Classroom $classroom)
    {
        if ($classroom->status !== 'Available') {
            return back()->with('error', 'Ruang kelas ini sedang tidak tersedia.');
        }

        return view('reservations.create', [
            'classroom' => $classroom,
            'dosenList' => User::query()
                ->whereHas('role', fn ($query) => $query->where('role_name', 'dosen'))
                ->orderBy('name')
                ->get(['id', 'name']),
            'jadwalSewa' => JadwalSewa::query()
                ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
                ->orderBy('start_time')
                ->get(),
            'hariLibur' => HariLibur::query()
                ->whereDate('holiday_date', '>=', now()->toDateString())
                ->where('is_active', true)
                ->where(function ($query) use ($classroom) {
                    $query->whereNull('classroom_id')
                        ->orWhere('classroom_id', $classroom->id);
                })
                ->orderBy('holiday_date')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'purpose_type' => ['required', 'in:Perkuliahan,Kegiatan Lain'],
            'purpose' => ['nullable', 'string', 'max:255'],
            'mata_kuliah' => ['required_if:purpose_type,Perkuliahan', 'nullable', 'string', 'max:255'],
            'dosen_id' => ['required_if:purpose_type,Perkuliahan', 'nullable', 'exists:users,id'],
            'kegiatan' => ['required_if:purpose_type,Kegiatan Lain', 'nullable', 'string', 'max:1000'],
        ]);

        $classroom = Classroom::query()->findOrFail($validated['classroom_id']);

        $reservationDate = Carbon::parse($validated['reservation_date']);
        $reservationDay = match ($reservationDate->dayOfWeekIso) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        };

        $isHariLibur = HariLibur::query()
            ->whereDate('holiday_date', $validated['reservation_date'])
            ->where('is_active', true)
            ->where(function ($query) use ($classroom) {
                $query->whereNull('classroom_id')
                    ->orWhere('classroom_id', $classroom->id);
            })
            ->exists();

        if ($isHariLibur) {
            return back()->withInput()->with('error', 'Tanggal yang dipilih adalah hari libur. Silakan pilih tanggal lain.');
        }

        $jadwalSewa = JadwalSewa::query()
            ->where('day_of_week', $reservationDay)
            ->get(['start_time', 'end_time']);

        if ($jadwalSewa->isEmpty()) {
            return back()->withInput()->with('error', 'Ruang ini tidak memiliki jadwal sewa pada hari tersebut.');
        }

        $startTime = Carbon::createFromFormat('H:i', $validated['start_time'])->format('H:i:s');
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time'])->format('H:i:s');

        $isWithinSchedule = $jadwalSewa->contains(function ($slot) use ($startTime, $endTime) {
            return $startTime >= $slot->start_time && $endTime <= $slot->end_time;
        });

        if (! $isWithinSchedule) {
            return back()->withInput()->with('error', 'Jam reservasi harus berada dalam jadwal sewa ruang yang tersedia.');
        }

        $conflict = Reservation::query()
            ->where('classroom_id', $classroom->id)
            ->where('reservation_date', $validated['reservation_date'])
            ->whereIn('reservation_status', ['Pending', 'Approved'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'Jadwal bentrok. Silakan pilih waktu lain.');
        }

        $purpose = $validated['purpose'] ?? null;
        if ($validated['purpose_type'] === 'Perkuliahan' && blank($purpose)) {
            $purpose = 'Perkuliahan - '.$validated['mata_kuliah'];
        }
        if ($validated['purpose_type'] === 'Kegiatan Lain' && blank($purpose)) {
            $purpose = $validated['kegiatan'];
        }

        $reservation = Reservation::query()->create([
            'user_id' => $request->user()->id,
            'classroom_id' => $classroom->id,
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'purpose_type' => $validated['purpose_type'],
            'purpose' => $purpose,
            'mata_kuliah' => $validated['mata_kuliah'] ?? null,
            'dosen_id' => $validated['dosen_id'] ?? null,
            'kegiatan' => $validated['kegiatan'] ?? null,
            'reservation_status' => 'Pending',
        ]);

        ActivityLogService::logReservationCreated($classroom->room_name, $request->user());

        $message = $validated['purpose_type'] === 'Kegiatan Lain'
            ? 'Reservasi berhasil dibuat dan menunggu persetujuan admin.'
            : 'Reservasi berhasil dibuat dan menunggu persetujuan dosen.';

        return redirect()->route('reservations.show', $reservation)
            ->with('success', $message);
    }

    public function show(Reservation $reservation, Request $request)
    {
        $user = $request->user();

        if ($user->isMahasiswa() && $reservation->user_id !== $user->id) {
            abort(403);
        }

        $reservation->load(['classroom', 'user', 'verifiedBy']);

        return view('reservations.show', [
            'reservation' => $reservation,
        ]);
    }

    public function destroy(Reservation $reservation, Request $request)
    {
        if ($reservation->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($reservation->reservation_status !== 'Pending') {
            return back()->with('error', 'Hanya reservasi berstatus Menunggu yang bisa dibatalkan.');
        }

        $classroom = $reservation->classroom;
        $reservation->update([
            'reservation_status' => 'Cancelled',
        ]);

        ActivityLogService::logReservationCancelled($classroom->room_name, $request->user());

        return redirect()->route('reservations.index')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
