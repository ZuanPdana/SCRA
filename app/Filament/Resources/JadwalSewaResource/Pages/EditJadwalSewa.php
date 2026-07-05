<?php

namespace App\Filament\Resources\JadwalSewaResource\Pages;

use App\Filament\Resources\JadwalSewaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalSewa extends EditRecord
{
    protected static string $resource = JadwalSewaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
