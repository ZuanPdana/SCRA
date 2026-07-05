<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use App\Services\ActivityLogService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateClassroom extends CreateRecord
{
    protected static string $resource = ClassroomResource::class;

    protected function afterCreate(): void
    {
        $classroom = $this->record;
        ActivityLogService::logClassroomCreated($classroom->room_name, Auth::user());
    }
}
