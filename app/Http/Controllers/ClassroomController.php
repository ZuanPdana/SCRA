<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\HariLibur;
use App\Models\JadwalSewa;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::query();

        if ($request->filled('search')) {
            $query->where('room_name', 'like', '%' . $request->string('search') . '%');
        }

        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', (int) $request->input('capacity'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $classrooms = $query->latest()->paginate(12)->withQueryString();
        $jadwalSewa = JadwalSewa::query()
            ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('start_time')
            ->get();

        return view('classrooms.index', [
            'classrooms' => $classrooms,
            'jadwalSewa' => $jadwalSewa,
            'search' => $request->input('search', ''),
            'capacity' => $request->input('capacity', ''),
            'status' => $request->input('status', ''),
        ]);
    }

    public function show(Classroom $classroom)
    {
        $jadwalSewa = JadwalSewa::query()
            ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('start_time')
            ->get();

        $reservations = $classroom->reservations()
            ->whereIn('reservation_status', ['Pending', 'Approved'])
            ->where('reservation_date', '>=', now()->toDateString())
            ->orderBy('reservation_date')
            ->orderBy('start_time')
            ->get();

        $hariLibur = HariLibur::query()
            ->whereDate('holiday_date', '>=', now()->toDateString())
            ->where('is_active', true)
            ->where(function ($query) use ($classroom) {
                $query->whereNull('classroom_id')
                    ->orWhere('classroom_id', $classroom->id);
            })
            ->orderBy('holiday_date')
            ->get();

        return view('classrooms.show', [
            'classroom' => $classroom,
            'jadwalSewa' => $jadwalSewa,
            'hariLibur' => $hariLibur,
            'reservations' => $reservations,
        ]);
    }
}
