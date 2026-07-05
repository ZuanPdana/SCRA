<?php

namespace App\Filament\Resources\JadwalMataKuliahResource\Pages;

use App\Filament\Resources\JadwalMataKuliahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalMataKuliah extends EditRecord
{
    protected static string $resource = JadwalMataKuliahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
