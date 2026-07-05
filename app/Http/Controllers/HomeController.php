<?php

namespace App\Http\Controllers;

use App\Models\Classroom;

class HomeController extends Controller
{
    public function index()
    {
        $classroomsCount = Classroom::query()->count();
        $availableClassrooms = Classroom::query()->where('status', 'Available')->count();

        return view('home', [
            'classroomsCount' => $classroomsCount,
            'availableClassrooms' => $availableClassrooms,
        ]);
    }
}
