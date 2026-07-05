<?php

namespace App\Filament\Resources\JadwalSewaResource\Pages;

use App\Filament\Resources\JadwalSewaResource;
use App\Models\JadwalSewa;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateJadwalSewa extends CreateRecord
{
    protected static string $resource = JadwalSewaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $selectedDays = $data['selected_days'] ?? [];

        if (blank($selectedDays)) {
            throw ValidationException::withMessages([
                'selected_days' => 'Pilih minimal satu hari reservasi.',
            ]);
        }

        $lastRecord = null;

        foreach ($selectedDays as $day) {
            $lastRecord = JadwalSewa::query()->updateOrCreate(
                [
                    'day_of_week' => $day,
                    'start_time' => $data['start_time'],
                ],
                [
                    'end_time' => $data['end_time'],
                ],
            );
        }

        return $lastRecord;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
