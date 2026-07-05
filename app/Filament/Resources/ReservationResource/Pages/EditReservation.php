<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Services\ActivityLogService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function afterSave(): void
    {
        $reservation = $this->record;
        ActivityLogService::logReservationStatusChanged($reservation->reservation_status, Auth::user());
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
