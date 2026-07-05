<?php

namespace App\Filament\Resources\JadwalSewaResource\Pages;

use App\Filament\Resources\JadwalSewaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalSewa extends ListRecords
{
    protected static string $resource = JadwalSewaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('hariLibur')
                ->label('Kelola Hari Libur')
                ->icon('heroicon-o-calendar-days')
                ->color('gray')
                ->url(route('filament.admin.resources.hari-liburs.index')),
        ];
    }
}
