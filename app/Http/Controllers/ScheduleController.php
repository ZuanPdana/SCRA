<?php

namespace App\Http\Controllers;

use App\Models\JadwalMataKuliah;
use App\Models\JadwalSewa;

class ScheduleController extends Controller
{
    public function jadwalSewa()
    {
        $jadwalSewa = JadwalSewa::query()
            ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('start_time')
            ->get();

        return view('schedules.jadwal-sewa', [
            'jadwalSewa' => $jadwalSewa,
        ]);
    }

    public function jadwalMataKuliah()
    {
        $jadwalMataKuliah = JadwalMataKuliah::query()
            ->with(['classroom', 'dosen'])
            ->orderByRaw("FIELD(day_of_week, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('start_time')
            ->get();

        return view('schedules.jadwal-mata-kuliah', [
            'jadwalMataKuliah' => $jadwalMataKuliah,
        ]);
    }
}
