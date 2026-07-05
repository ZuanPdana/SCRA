<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalSewaResource\Pages;
use App\Models\JadwalSewa;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class JadwalSewaResource extends Resource
{
    protected static ?string $model = JadwalSewa::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Jadwal Sewa Universal';

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Jadwal Sewa Universal (Semua Ruang)')
                ->schema([
                    Forms\Components\Placeholder::make('keterangan_jadwal')
                        ->label('Keterangan')
                        ->content('Pilih satu atau beberapa hari reservasi. Hari yang tidak dipilih akan ditutup untuk reservasi.')
                        ->columnSpanFull(),
                    Forms\Components\CheckboxList::make('selected_days')
                        ->label('Hari Reservasi')
                        ->options([
                            'Senin' => 'Senin',
                            'Selasa' => 'Selasa',
                            'Rabu' => 'Rabu',
                            'Kamis' => 'Kamis',
                            'Jumat' => 'Jumat',
                            'Sabtu' => 'Sabtu',
                            'Minggu' => 'Minggu',
                        ])
                        ->columns(3)
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->visible(fn (string $operation): bool => $operation === 'create'),
                    Forms\Components\Select::make('day_of_week')
                        ->label('Hari')
                        ->options([
                            'Senin' => 'Senin',
                            'Selasa' => 'Selasa',
                            'Rabu' => 'Rabu',
                            'Kamis' => 'Kamis',
                            'Jumat' => 'Jumat',
                            'Sabtu' => 'Sabtu',
                            'Minggu' => 'Minggu',
                        ])
                        ->required(fn (string $operation): bool => $operation === 'edit')
                        ->visible(fn (string $operation): bool => $operation === 'edit'),
                    Forms\Components\TimePicker::make('start_time')
                        ->label('Jam Mulai')
                        ->required(),
                    Forms\Components\TimePicker::make('end_time')
                        ->label('Jam Selesai')
                        ->rules(['after:start_time'])
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('Hari')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('day_of_week')
                    ->label('Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('day_of_week', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalSewa::route('/'),
            'create' => Pages\CreateJadwalSewa::route('/create'),
            'edit' => Pages\EditJadwalSewa::route('/{record}/edit'),
        ];
    }
}
