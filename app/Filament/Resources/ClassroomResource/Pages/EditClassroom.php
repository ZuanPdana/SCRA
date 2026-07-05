<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use App\Services\ActivityLogService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditClassroom extends EditRecord
{
    protected static string $resource = ClassroomResource::class;

    protected function afterSave(): void
    {
        $classroom = $this->record;
        ActivityLogService::logClassroomUpdated($classroom->room_name, Auth::user());
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function () {
                    $classroom = $this->record;
                    ActivityLogService::logClassroomDeleted($classroom->room_name, Auth::user());
                }),
        ];
    }
}
